<?php

namespace App\Console\Commands;

use App\Exceptions\NotFound;
use App\Trello\Card;
use App\Trello\List_;
use App\Trello\Member;
use App\Trello\RepeatMonthlyRule;
use App\Trello\Trello;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Osmianski\Helper\Exceptions\NotImplemented;
use Symfony\Component\Yaml\Yaml;

class TrelloRepeat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trello:repeat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repetitive cards in Trello for the next month';

    protected Trello $trello;
    protected Member $me;

    protected array $listCache = [];
    protected array $cardCache = [];

    protected int $created = 0;
    protected int $updated = 0;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->trello = new Trello();
        $this->me = $this->trello->getMe();

        $config = Yaml::parseFile(base_path('trello.yml'));

        foreach ($config['repeat_monthly'] ?? [] as $data) {
            $this->handleMonthlyRule(new RepeatMonthlyRule($data));
        }

        $this->info("{$this->created} cards created, {$this->updated} updated");
        Log::info("trello:repeat: {$this->created} cards created, {$this->updated} updated");
    }

    protected function getList(string $workspaceName, string $boardName, string $listName)
        : List_
    {
        $key = "$workspaceName|$boardName|$listName";

        if (!isset($this->listCache[$key])) {
            if (!($workspace = $this->trello->getWorkspaceByName($workspaceName))) {
                throw new NotFound("Workspace '{$workspaceName}' not found.");
            }

            if (!($board = $workspace->getBoardByName($boardName))) {
                throw new NotFound("Board '{$boardName}' not found.");
            }

            if (!($list = $board->getListByName($listName))) {
                throw new NotFound("List '{$listName}' not found.");
            }

            $this->listCache[$key] = $list;
        }

        return $this->listCache[$key];
    }

    /**
     * @param List_ $list
     * @return array|Card[]
     */
    protected function getCards(List_ $list): array {
        if (!isset($this->cardCache[$list->id])) {
            $this->cardCache[$list->id] = $list->getCards();
        }

        return $this->cardCache[$list->id];
    }

    protected function handleMonthlyRule(RepeatMonthlyRule $rule): void
    {
        $this->createMonthlyCard($rule, now()->setDay($rule->day)
            ->setHour(9)->setMinute(0)->setSecond(0));
        $this->createMonthlyCard($rule, now()->addMonth()->setDay($rule->day)
            ->setHour(9)->setMinute(0)->setSecond(0));
    }

    protected function createMonthlyCard(RepeatMonthlyRule $rule,
        Carbon $due): void
    {
        if ($due->lessThan(now())) {
            return;
        }

        $list = $this->getList($rule->workspace, $rule->board, $rule->list);

        if ($card = $this->getMonthlyCard($list, $rule->name, $due)) {
            if (!$card->reminder || !in_array($this->me->id, $card->members)) {
                $card->update([
                    'reminder' => 5,
                    'members' => array_unique(array_merge($card->members, [$this->me->id])),
                ]);
                $this->updated++;
            }
        }
        else {
            $list->createCard([
                'name' => $rule->name,
                'due' => $due,
                'reminder' => 5,
                'members' => [$this->me->id],
            ]);
            $this->created++;
        }
    }

    protected function getMonthlyCard(List_ $list, string $cardName, Carbon $due): ?Card
    {
        foreach ($this->getCards($list) as $card) {
            if (trim($card->name) !== $cardName) {
                continue;
            }

            if ($card->due?->toDateString() !== $due->toDateString()) {
                continue;
            }

            return $card;
        }

        return null;
    }
}

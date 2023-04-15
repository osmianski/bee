<?php

namespace App\Console\Commands;

use App\Exceptions\NotFound;
use App\Trello\Card;
use App\Trello\List_;
use App\Trello\Member;
use App\Trello\Rule;
use App\Trello\Trello;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
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
            $this->handleMonthlyRule(new Rule\RepeatMonthly($data));
        }

        foreach ($config['repeat_quarterly'] ?? [] as $data) {
            $this->handleQuarterlyRule(new Rule\RepeatQuarterly($data));
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

    protected function handleMonthlyRule(Rule\RepeatMonthly $rule): void
    {
        $this->createCard($rule, now()->setDay($rule->day)
            ->setHour(9)->setMinute(0)->setSecond(0));
        $this->createCard($rule, now()->addMonth()->setDay($rule->day)
            ->setHour(9)->setMinute(0)->setSecond(0));
    }

    protected function handleQuarterlyRule(Rule\RepeatQuarterly $rule): void
    {
        // 1 => -1, 2 => -2, 3 => -3, 4 => -1, 5 => -2, 6 => -3,
        // 7 => -1, 8 => -2, 9 => -3, 10 => -1, 11 => -2, 12 => -3
        $offset = -1 * ((now()->month  - 1) % 3 + 1);

        $this->createCard($rule, now()
            ->addMonths($offset + $rule->month)->setDay($rule->day)
            ->setHour(9)->setMinute(0)->setSecond(0));
        $this->createCard($rule, now()
            ->addMonths($offset + $rule->month + 3)->setDay($rule->day)
            ->setHour(9)->setMinute(0)->setSecond(0));
    }

    protected function createCard(Rule $rule, Carbon $due): void
    {
        if ($due->lessThan(now())) {
            return;
        }

        $list = $this->getList($rule->workspace, $rule->board, $rule->list);

        if ($card = $this->getCard($list, $rule->name, $due)) {
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

    protected function getCard(List_ $list, string $cardName, Carbon $due): ?Card
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

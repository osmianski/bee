<?php

use Osmianski\Sync\Facades\Sync;
use function Spatie\Snapshots\assertMatchesObjectSnapshot;
use Osmianski\Workflowy\Facades\Workflowy;

it('renders the home page')->get('/')->assertStatus(200);

it('expects workflowy data to stay the same', function() {
    $raw = Workflowy::getWorkspace()->raw;

    assertMatchesObjectSnapshot($raw);

    return $raw;
});

it('syncs calendar from an array', function() {
    $inserted = Str::uuid()->toString();
    $updated = Str::uuid()->toString();
    $deleted = Str::uuid()->toString();

    Sync::from([
        [
            'workflowy_id' => $updated,
        ],
        [
            'workflowy_id' => $deleted,
        ],
    ])->to(CalendarEntry::class)->now();

    $this->assertDatabaseCount('calendar_entries', 2);
    $this->assertDatabaseMissing('calendar_entries', [
        'workflowy_id' => $inserted,
    ]);
    $this->assertDatabaseHas('calendar_entries', [
        'workflowy_id' => $updated,
    ]);
    $this->assertDatabaseHas('calendar_entries', [
        'workflowy_id' => $deleted,
    ]);

    Sync::from([
        [
            'workflowy_id' => $inserted,
        ],
        [
            'workflowy_id' => $updated,
        ],
    ])->to(CalendarEntry::class)->now();

    $this->assertDatabaseCount('calendar_entries', 2);
    $this->assertDatabaseHas('calendar_entries', [
        'workflowy_id' => $inserted,
    ]);
    $this->assertDatabaseHas('calendar_entries', [
        'workflowy_id' => $updated,
    ]);
    $this->assertDatabaseMissing('calendar_entries', [
        'workflowy_id' => $deleted,
    ]);
});

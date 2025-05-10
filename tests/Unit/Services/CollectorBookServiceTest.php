<?php

use App\Models\Book;
use App\Models\Collector;
use App\Services\CollectorBookService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns the most recently created books for each type', function () {
    $collector = Collector::factory()->create();

    $fiction1 = Book::factory()->create(['collector_id' => $collector->id, 'type' => 'Fiction']);
    $fiction2 = Book::factory()->create(['collector_id' => $collector->id, 'type' => 'Fiction']);
    $fiction1->update(['created_at' => now()->subDay()]);
    $fiction2->update(['created_at' => now()->subDays(2)]);

    $nonFiction1 = Book::factory()->create(['collector_id' => $collector->id, 'type' => 'Non-Fiction']);
    $nonFiction2 = Book::factory()->create(['collector_id' => $collector->id, 'type' => 'Non-Fiction']);
    $nonFiction1->update(['created_at' => now()->subDay()]);
    $nonFiction2->update(['created_at' => now()->subDays(2)]);

    $technical1 = Book::factory()->create(['collector_id' => $collector->id, 'type' => 'Technical']);
    $technical2 = Book::factory()->create(['collector_id' => $collector->id, 'type' => 'Technical']);
    $technical1->update(['created_at' => now()->subDay()]);
    $technical2->update(['created_at' => now()->subDays(2)]);

    $selfHelp1 = Book::factory()->create(['collector_id' => $collector->id, 'type' => 'Self-Help']);
    $selfHelp2 = Book::factory()->create(['collector_id' => $collector->id, 'type' => 'Self-Help']);
    $selfHelp1->update(['created_at' => now()->subDay()]);
    $selfHelp2->update(['created_at' => now()->subDays(2)]);

    $service = new CollectorBookService;
    $summary = $service->getRecentlyAddedBooks($collector);

    expect($summary)->toHaveKey('Fiction')
        ->and($summary['Fiction']['id'])->toBe($fiction1->id)
        ->and($summary)->toHaveKey('Non-Fiction')
        ->and($summary['Non-Fiction']['id'])->toBe($nonFiction1->id)
        ->and($summary)->toHaveKey('Technical')
        ->and($summary['Technical']['id'])->toBe($technical1->id)
        ->and($summary)->toHaveKey('Self-Help')
        ->and($summary['Self-Help']['id'])->toBe($selfHelp1->id);
});

it('returns an empty summary if no books are found', function () {
    $collector = Collector::factory()->create();

    $service = new CollectorBookService;
    $summary = $service->getRecentlyAddedBooks($collector);

    expect($summary)->toBeEmpty();
});


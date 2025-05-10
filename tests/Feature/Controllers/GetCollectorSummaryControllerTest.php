<?php

use App\Models\Book;
use App\Models\Collector;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns the most recently added books for each type for a collector', function () {
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

    $response = $this->getJson("/api/collectors/{$collector->id}/recently-added");

    $response->assertOk();
    $response->assertJsonFragment([
        'Fiction' => [
            'id' => $fiction1->id,
            'title' => $fiction1->title,
            'created_at' => $fiction1->created_at->toDateTimeString(),
        ],
        'Non-Fiction' => [
            'id' => $nonFiction1->id,
            'title' => $nonFiction1->title,
            'created_at' => $nonFiction1->created_at->toDateTimeString(),
        ],
        'Technical' => [
            'id' => $technical1->id,
            'title' => $technical1->title,
            'created_at' => $technical1->created_at->toDateTimeString(),
        ],
        'Self-Help' => [
            'id' => $selfHelp1->id,
            'title' => $selfHelp1->title,
            'created_at' => $selfHelp1->created_at->toDateTimeString(),
        ],
    ]);
});

it('returns an empty summary if no books are found', function () {
    $collector = Collector::factory()->create();

    $response = $this->getJson("/api/collectors/{$collector->id}/recently-added");

    $response->assertOk();
    $response->assertJson([]);
});

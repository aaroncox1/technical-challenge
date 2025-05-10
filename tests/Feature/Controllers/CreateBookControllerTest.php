<?php

use App\Models\Collector;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a book and returns a 201 response', function () {
    $collector = Collector::factory()->create();

    $payload = [
        'title' => 'Make a Book',
        'type' => 'Technical',
        'collector_id' => $collector->id,
    ];

    $response = $this->postJson('/api/books', $payload);

    $response->assertCreated()
        ->assertJson([
            'message' => 'Book created successfully',
        ]);

    $this->assertDatabaseHas('books', [
        'title' => $payload['title'],
        'type' => $payload['type'],
        'collector_id' => $collector->id,
    ]);
});

it('returns 422 validation errors when request data is invalid', function () {
    $response = $this->postJson('/api/books', [
        'title' => '',
        'type' => 'InvalidType',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['title', 'type', 'collector_id']);
});

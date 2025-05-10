<?php

use App\Models\Book;
use App\Models\Collector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;

uses(RefreshDatabase::class);

it('returns the book data with resource formatting and ISBN', function () {
    // Arrange
    $collector = Collector::factory()->create();
    $book = Book::factory()->create([
        'collector_id' => $collector->id,
    ]);

    $isbn = '123-4567890123';

    // Act
    $response = $this->getJson("/api/books/{$book->id}");

    // Assert
    $response->assertOk();

    $response->assertJsonStructure([
        'data' => [
            'id',
            'title',
            'type',
            'isbn',
            'collector' => [
                'id',
                'name',
            ],
        ],
    ]);

    // Optional: validate that UUID is used correctly
    expect(Uuid::isValid($response->json('data.id')))->toBeTrue();
});

it('returns 404 if book is not found', function () {
    $invalidUuid = Uuid::uuid4()->toString();

    $response = $this->getJson("/api/books/{$invalidUuid}");

    $response->assertNotFound();
});

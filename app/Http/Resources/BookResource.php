<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Client\IsbnClient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

final class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'isbn' => $this->getIsbn(),
            'collector' => [
                'id' => $this->collector->id,
                'name' => $this->collector->name,
            ],
        ];
    }

    private function getIsbn(): ?string
    {
        try {
            $client = new IsbnClient('test-user', 'test-pass');
            return $client->get(Uuid::fromString($this->id));
        } catch (\Throwable $e) {
            Log::error('System error - Could not get ISBN for Book: ' . $this->id, [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}

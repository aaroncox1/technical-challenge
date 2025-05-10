<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Book;
use App\Models\Collector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class CollectorBookService
{
    public function getRecentlyAddedBooks(Collector $collector): Collection
    {
        $latestBooks = DB::table('books as b1')
            ->select('b1.id', 'b1.title', 'b1.type', 'b1.created_at')
            ->where('b1.collector_id', $collector->id)
            ->whereIn('b1.type', Book::getTypes())
            ->whereRaw('b1.created_at = (
                    SELECT MAX(b2.created_at)
                    FROM books b2
                    WHERE b2.type = b1.type AND b2.collector_id = b1.collector_id
                )')
            ->get();

        return $latestBooks->mapWithKeys(fn ($book) => [
            $book->type => [
                'id' => $book->id,
                'title' => $book->title,
                'created_at' => $book->created_at,
            ],
        ]);
    }
}

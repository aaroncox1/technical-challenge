<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Book;

final class BookService
{
    public function create(array $data): Book
    {
        return Book::create($data);
    }
}

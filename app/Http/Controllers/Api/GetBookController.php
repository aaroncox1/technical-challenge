<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\BookResource;
use App\Models\Book;

final class GetBookController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Book $book): BookResource
    {
        return new BookResource($book);
    }
}

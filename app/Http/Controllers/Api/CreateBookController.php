<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateBookRequest;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

final class CreateBookController
{
    private BookService $service;

    public function __construct(BookService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateBookRequest $request): JsonResponse
    {
        $this->service->create($request->validated());

        return response()->json([
            'message' => 'Book created successfully',
        ], 201);
    }
}

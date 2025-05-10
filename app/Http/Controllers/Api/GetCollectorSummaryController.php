<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Collector;
use App\Services\CollectorBookService;
use Illuminate\Http\JsonResponse;

final class GetCollectorSummaryController
{
    private CollectorBookService $service;

    public function __construct(CollectorBookService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Collector $collector): JsonResponse
    {
        $summary = $this->service->getRecentlyAddedBooks($collector);

        return response()->json($summary);
    }
}

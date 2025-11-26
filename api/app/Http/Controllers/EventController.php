<?php

declare(strict_types=1);

namespace App\Api\Http\Controllers;

use App\Api\Http\Requests\EventRequest;
use App\Services\EventManager;
use Demo\Api\Http\Controllers\ApiController;
use Demo\Http\Response\JsonResponseFactory;
use Demo\Http\Response\JsonSuccessResponse;
use Symfony\Component\HttpFoundation\Response;

class EventController extends ApiController
{
    /**
     * Commit an event
     *
     * This endpoint needs to register specific events from the client.
     *
     * 1 - Register event about login to the specific auction.
     *     Required param: auction.
     * 2 - Register event about logout from the specific auction.
     *     Required param: auction.
     */
    public function __invoke(EventRequest $request, int $event): JsonSuccessResponse
    {
        $user = $this->currentUser();

        EventManager::make($user, $event)->commit($request->validated());

        return JsonResponseFactory::success();
    }
}

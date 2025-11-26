<?php

declare(strict_types=1);

namespace App\Api\Http\Controllers;

use App\Api\Http\Requests\ParseBidRequest;
use App\Models\Bid;
use App\Jobs\ParseBidInfoFromImage;
use Illuminate\Http\JsonResponse;
use Demo\Api\Http\Controllers\ApiController as BaseController;
use Symfony\Component\HttpFoundation\Response;

class BidsController extends BaseController
{
    /**
     * Send base64 image string to parse bids info
     *
     */
    public function parse(ParseBidRequest $request): JsonResponse
    {
        $this->authorize('create', Bid::class);

        ParseBidInfoFromImage::dispatch($request->validated('image'), $request->validated('auction'));

        return FormSuccessResponse::make();
    }
}

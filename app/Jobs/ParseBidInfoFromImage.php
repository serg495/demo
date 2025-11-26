<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\BidStatus;
use App\Models\Bid;
use App\Services\ImageParser\Base64ToImageDecoder;
use App\Services\ImageParser\ImageParserFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ParseBidInfoFromImage implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $image,
        protected string $auction,
    ) {}

    public function handle(): bool
    {
        $decoder = Base64ToImageDecoder::make($this->image);
        $parser = ImageParserFactory::parser($auction = $this->auction, $decoder->decode());

        Bid::query()->create([
            'user_id' => ($user = $this->currentUser())->id,
            'session_id' => $user->sessions()->latest()->first()->id,
            'lot_number' => $parser->getLotNumber(),
            'amount' => $parser->getBid(),
            'auction' => $auction,
            'status' => BidStatus::IN_PROGRESS,
        ]);

        $decoder->deleteImage();

        return true;
    }
}
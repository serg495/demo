<?php

declare(strict_types=1);

namespace Models;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Demo\Component\Money\Casts\EloquentMoneyCaster;
use App\Enums\Auction;
use App\Enums\BidStatus;
use Demo\Database\LkEloquentBuilder;
use Demo\Models\Model as BaseModel;
use Demo\Models\User;

class Bid extends BaseModel
{
    protected $casts = [
        'amount' => EloquentMoneyCaster::class,
    ];

    protected $fillable = [
        'lot_number',
        'user_id',
        'session_id',
        'amount',
        'auction',
        'status',
        'vin',
    ];

    protected static array $attributesListsMap = [
        'auction' => Auction::class,
        'status' => BidStatus::class,
    ];

    protected string $localizeTranslationPath = 'models.' . self::class;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class);
    }
}

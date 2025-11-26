<?php

declare(strict_types=1);

namespace App\Api\Http\Requests;

use App\Enums\Auction;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'auction' => ['required', Rule::in(Auction::values())]
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class TokenDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'name' => $this->accessToken->name,
            'abilities' => $this->accessToken->abilities,

            //'tokenable_id' => $this->accessToken->tokenable_id,
            //'access_token' => $this->plainTextToken,

            'created_at' => $this->accessToken->created_at,
            'updated_at' => $this->accessToken->updated_at,
        ];
    }
}

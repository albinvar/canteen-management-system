<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'first_name' => $this->profile->first_name,
            'last_name' => $this->profile->last_name,
            'phone' => $this->profile->phone,
            'phone_info' => $this->profile->phone_info(),
            'email' => $this->email,
            'role_id' => $this->role_id,
            'role' => new RoleResource($this->role),
            //'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

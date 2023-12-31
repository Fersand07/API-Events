<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'username' => $this->username,
            'email' => $this->email,
            'cellphone' => $this->cellphone,
            'profile_image_url' => $this->profile_image_url
        ];
    }
}

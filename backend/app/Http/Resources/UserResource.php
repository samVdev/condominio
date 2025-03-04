<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'name' => $this->persona->fullName,
          'email' => $this->email,
          'avatar' => $this->avatar,
          'isAdmin' => $this->isAdmin(),
          'role_id' => $this->role_id,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return $this->getCampi();
    }

    protected function getCampi()
    {
        return [
            "id" => $this->id,
            "user" => $this->user,
            "role_id" => $this->role_id,
            "role" => $this->role,
            "state_id" => $this->state_id,
            "state" => $this->state,
            "person_id" => $this->person_id,
            "person" => $this->person,
            "scadenza_sfida" => $this->scadenza_sfida,
            "secret_jwt" => $this->secret_jwt
        ];
    }
}

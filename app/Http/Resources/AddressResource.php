<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            "person_id" => $this->person_id,
            "address_type_id" => $this->address_type_id,
            "address_type" => $this->addressType,
            "indirizzo" => $this->indirizzo,
            "civico" => $this->civico,
            "municipality_id" => $this->municipality_id,
            "municipality" => $this->municipality,
            "CAP" => $this->CAP,
            "nation_id" => $this->nation_id,
            "nation" => $this->nation,
        ];
    }
}

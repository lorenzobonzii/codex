<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NationResource extends JsonResource
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

    protected function getCampi(){
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "continente" => $this->continente,
            "iso" => $this->iso,
            "iso3" => $this->iso3,
            "prefisso_telefonico" => $this->prefisso_telefonico,
        ];
    }
}

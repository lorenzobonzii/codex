<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            "cognome" => $this->cognome,
            "data_nascita" => $this->data_nascita,
            "sesso" => $this->sesso,
            "cf" => $this->cf,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MunicipalityResource extends JsonResource
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
            "comune" => $this->comune,
            "regione" => $this->regione,
            "provincia" => $this->provincia,
            "sigla" => $this->sigla,
            "codice_belfiore" => $this->codice_belfiore,
            "cap" => $this->cap,
        ];
    }
}

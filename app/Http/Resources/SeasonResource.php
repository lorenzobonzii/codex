<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeasonResource extends JsonResource
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
            "titolo" => $this->titolo,
            "ordine" => $this->ordine,
            "anno" => $this->anno,
            "trama" => $this->trama,
            "copertina" => $this->copertina,
            "url_copertina" => $this->url_copertina,
            "episodes" => $this->episodes,
        ];
    }
}

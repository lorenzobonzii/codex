<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EpisodeResource extends JsonResource
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
            "durata" => $this->durata,
            "copertina" => $this->copertina,
            "url_copertina" => $this->url_copertina,
            "descrizione" => $this->descrizione,
            //"season" => $this->season,
        ];
    }
}

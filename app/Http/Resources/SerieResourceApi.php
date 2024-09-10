<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SerieResourceApi extends JsonResource
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
            "regia" => $this->regia,
            "attori" => $this->attori,
            "anno" => $this->anno,
            "durata" => count($this->seasons),
            "lingua" => $this->lingua,
            "copertina_v" => $this->copertina_v,
            "copertina_o" => $this->copertina_o,
            "genres_ids" => $this->genres->pluck('id')->toArray(),
            "url_copertina_v" => $this->url_copertina_v,
            "url_copertina_o" => $this->url_copertina_o,
            "url_copertina_o_min" => $this->url_copertina_o_min,
            "anteprima" => $this->anteprima,
            "trama" => $this->trama,
            "nation" => $this->nation,
            "genres" => $this->genres,
            "seasons" => $this->seasons,
        ];
    }
}

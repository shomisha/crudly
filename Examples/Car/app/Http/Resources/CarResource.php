<?php

namespace App\Http\Resources;

use App\Http\Resources\ManufacturerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray($request)
    {
        return ['id' => $this->id, 'model' => $this->model, 'manufacturer' => new ManufacturerResource($this->whenLoaded('manufacturer')), 'production_year' => $this->production_year, 'first_registration_date' => $this->first_registration_date, 'horse_power' => $this->horse_power, 'updated_at' => $this->updated_at, 'created_at' => $this->created_at];
    }
}
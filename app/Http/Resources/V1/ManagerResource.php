<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $jsonface = json_encode($this->face);
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'face' => json_decode($jsonface,true),
            'description' => $this->description,
            'updated_at' => $this->updated_at->format('d/m/Y à H:i')
        ];
    }
}

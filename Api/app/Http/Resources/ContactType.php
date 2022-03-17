<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactType extends JsonResource {
    public function toArray($request) {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y')
        ];
    }
}
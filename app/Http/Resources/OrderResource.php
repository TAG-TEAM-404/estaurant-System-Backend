<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_date' => $this->order_date,
            'total_amount' => $this->total_amount,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'items' => TakesResource::collection($this->takes), 
        ];
    }
}


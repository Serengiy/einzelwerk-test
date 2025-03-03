<?php

namespace App\Http\Resources;

use App\Models\Contagent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Contagent
 */
class ContragentResource extends JsonResource
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
            'inn' => $this->inn,
            'ogrn' => $this->ogrn,
            'address' => $this->address,
            'name' => $this->name,
            'user'=> $this->whenLoaded(
                'user', fn() => UserResource::make($this->user)
            ),
        ];
    }
}

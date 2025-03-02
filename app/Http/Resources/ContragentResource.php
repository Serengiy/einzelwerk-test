<?php

namespace App\Http\Resources;

use App\Http\Resources\API\Activity\ActivityMetaResource;
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
            'address' => $this->address,
            'name' => $this->name,
            'user'=> $this->whenLoaded(
                'user', fn() => UserResource::make($this->user)
            ),
        ];
    }
}

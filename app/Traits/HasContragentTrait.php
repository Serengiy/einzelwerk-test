<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasContragentTrait
{
    /**
     * @param Builder $query
     * @param array $data
     *
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $data): Builder
    {
        if($inn = $data['inn'] ?? null){
            $query->where('inn', $inn);
        }

        if($name = $data['name'] ?? null){
            $query->where('name', 'like', "%$name%");
        }

        if($ogrn = $data['ogrn'] ?? null){
            $query->where('ogrn',  $ogrn);
        }

        if($address = $data['address'] ?? null){
            $query->where('address','like', "%$address%");
        }


        return $query;
    }
}

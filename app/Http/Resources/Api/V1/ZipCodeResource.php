<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ZipCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'zip_code' => $this->d_codigo ?? '',
            'locality' => Str::upper($this->d_ciudad),
            'federal_entity' => [
                'key' =>  (int) $this->c_estado,
                'name' => Str::upper($this->d_estado),
                'code' => $this->c_CP,
            ],
            'settlements' => $this->settlements,
            'municipality' => [
                'key' => (int) $this->c_mnpio,
                'name' => Str::upper($this->D_mnpio),
            ]
        ];
    }
}

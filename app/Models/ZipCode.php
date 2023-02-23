<?php

namespace App\Models;

use App\Traits\CleanStringTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    use HasFactory;
    use CleanStringTrait;

    protected $primaryKey =  "d_codigo";

    /**
     * Scope a query to only include users of a given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeZipCode($query, $zipCode)
    {
        return $query->where('d_codigo', $zipCode);
    }

    public function scopeAvoidZipCode($query, $zipCode)
    {
        return $query->whereNotIn('id', [$zipCode]);
    }

    /**
     * Get the user's first name.
     */
    protected function dCiudad(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->clean($value),
        );
    }

    protected function dAsenta(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->clean($value),
        );
    }

    protected function dEstado(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->clean($value),
        );
    }

    protected function dZona(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->clean($value),
        );
    }

    protected function dMnpio(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->clean($value),
        );
    }
}

<?php

namespace App\Services\Api\V1\ZipCode;

use App\Models\ZipCode;
use Error;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ZipCodeService
{
    public function resolveSettlements($settlementId, $zipCode)
    {
        abort_if(empty($zipCode), Response::HTTP_BAD_REQUEST);
        $settlements = ZipCode::zipCode($zipCode)->get();
        return $this->solveSettlements($settlements);
    }

    protected function solveSettlements($settlements)
    {
        $parsed = collect([]);

        foreach ($settlements as $key => $settlement) {
            $parsed->push([
                'key' => (int) $settlement->id_asenta_cpcons,
                'name' => Str::upper($settlement->d_asenta),
                'zone_type' => Str::upper($settlement->d_zona),
                'settlement_type' => [
                    'name' => $settlement->d_tipo_asenta,
                ],
            ]);
        }

        return $parsed;
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ZipCodeResource;
use App\Models\ZipCode;
use App\Services\Api\V1\ZipCode\ZipCodeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ZipCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['message' => ""], Response::HTTP_NOT_FOUND);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        return response()->json(['message' => ""], Response::HTTP_NOT_FOUND);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ZipCode  $zipCode
     * @return \Illuminate\Http\Response
     */
    public function show(ZipCode $zipCode)
    {
        $settlements = (new ZipCodeService)->resolveSettlements($zipCode->id, $zipCode->d_codigo);
        $zipCode->settlements = $settlements;
        return ZipCodeResource::make($zipCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ZipCode  $zipCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $zipCode)
    {
        return response()->json(['message' => ""], Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ZipCode  $zipCode
     * @return \Illuminate\Http\Response
     */
    public function destroy($zipCode)
    {
        return response()->json(['message' => ""], Response::HTTP_NOT_FOUND);
    }
}

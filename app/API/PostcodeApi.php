<?php

namespace App\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class PostcodeApi
{
    public static function getDestination($postcode) : JsonResponse
    {
        $response = Http::get("api.postcodes.io/postcodes/{$postcode}/validate");
        if ($response->status() !== 200) {
            return response()->json(['message' => 'The postcode is not valid!']);
        }
        $destination = Http::get("api.postcodes.io/postcodes/{$postcode}");
        return response()->json([
            'destination' => $destination,
        ]);
    }
    public static function getOrigin($home_postcode) : JsonResponse
    {
        $origin = Http::get("api.postcodes.io/postcodes/{$home_postcode}");
        return response()->json([
            'origin' => $origin
        ]);
    }
}

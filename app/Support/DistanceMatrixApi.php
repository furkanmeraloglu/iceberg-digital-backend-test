<?php

namespace App\Support;

use TeamPickr\DistanceMatrix\DistanceMatrix;
use TeamPickr\DistanceMatrix\Licenses\StandardLicense;

class DistanceMatrixApi
{
    public static function getDistanceAndDuration($destLat, $destLon): \Illuminate\Http\JsonResponse
    {
        $originLat = config('google.originLat');
        $originLon = config('google.originLon');
        $license = new StandardLicense(config('google.key'));
        $request = new DistanceMatrix($license);
        $response = DistanceMatrix::license($license)
            ->addOrigin($originLat . ',' . ' ' . $originLon)
            ->addDestination($destLat . ',' . ' ' . $destLon)
            ->request();
        $rows = $response->rows();
        $elements = $rows[0]->elements();
        $element = $elements[0];
        $distanceText = $element->distanceText();
        $durationText = $element->durationText();
        return response()->json([
            'distance' => $distanceText,
            'duration' => $durationText
        ]);
    }
}

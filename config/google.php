<?php

return [
    'license_type' => env('GOOGLE_LICENSE_TYPE', 'standard'),
    'key' => env('GOOGLE_MAPS_KEY', ''),
    'client_id'      => env('GOOGLE_CLIENT_ID', ''),
    'encryption_key' => env('GOOGLE_ENCRYPTION_KEY', ''),
    'originLat' => env('OFFICE_LAT', ''),
    'originLon' => env('OFFICE_LON', '')
];

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeoLocationController extends Controller
{
    public function getLocationByPhoneNumber($phoneNumber)
    {
        $client = new \GuzzleHttp\Client();
        $url = 'https://api.teleport.me/api/v1/location/'.$phoneNumber;
        $response = $client->request('GET', $url);
        $data = json_decode($response->getBody(), true);

        // Extract the location information from the response
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $city = $data['city'];
        $country = $data['country'];

        // Return the location information
        return view('location', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'city' => $city,
            'country' => $country,
        ]);
    }

}

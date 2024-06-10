<?php

namespace App\Http\Controllers\Booking;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsappController
{
    public function webhook(Request $request) {
        $data = $this->getHubChallenge($request->fullUrl());

        return $data;
    }

    function getHubChallenge($inputString)
    {
        // Parse the URL to get the query part
        $urlComponents = parse_url($inputString);

        // Check if query part exists
        if (!isset($urlComponents['query'])) {
            return "hub.challenge parameter is not found.";
        }

        // Parse the query string into an associative array
        parse_str($urlComponents['query'], $queryParams);

        // Check if 'hub.challenge' parameter is set
        if (isset($queryParams['hub.challenge'])) {
            return $queryParams['hub.challenge'];
        } else {
            return "hub.challenge parameter is not found.";
        }
    }
}

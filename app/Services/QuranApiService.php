<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuranApiService
{
    public function getAccessToken()
    {
        $clientId = env('QURAN_API_CLIENT_ID');
        $clientSecret = env('QURAN_API_CLIENT_SECRET');

        $response = Http::withOptions([
            'verify' => false  // désactive la vérification SSL
        ])->withHeaders([
            'Authorization' => 'Basic ' . base64_encode("$clientId:$clientSecret"),
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->asForm()->post('https://prelive-oauth2.quran.foundation/oauth2/token', [
            'grant_type' => 'client_credentials',
            'scope' => 'content',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['access_token'];
        } else {
            return response()->json(['error' => 'Failed to get access token', 'details' => $response->json()], 500);
        }
    }

    public function getChapters()
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return ['error' => 'Access token not available'];
        }
        $response = Http::withOptions([
            'verify' => false,  // temporairement pour dev
        ])->withHeaders([
            'x-auth-token' => $token,
            'x-client-id' => config('services.quran.client_id'),
        ])->get('https://apis-prelive.quran.foundation/content/api/v4//quran/verses/uthmani_tajweed');

        return $response->json();
    }
}

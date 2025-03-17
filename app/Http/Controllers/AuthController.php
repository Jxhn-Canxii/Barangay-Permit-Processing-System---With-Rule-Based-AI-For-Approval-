<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Get email and session_token from the URL
        $email = $request->query('email');
        $session_token = $request->query('session_token');

        // If missing, redirect to main login page
        if (!$email || !$session_token) {
            return redirect()->away('https://smartbarangayconnect.com/login');
        }

        // ✅ Fetch registerlanding data from SmartBarangay Connect API
        $api_url = "https://smartbarangayconnect.com/api_get_registerlanding.php";
        $response = Http::get($api_url);
        $data = $response->json();

        // If API call fails
        if (!$data) {
            return response()->json(['error' => 'Failed to fetch data from SmartBarangay Connect'], 500);
        }

        // ✅ Verify user session token in API response
        $user = collect($data)->firstWhere(fn($user) => $user['email'] === $email && $user['session_token'] === $session_token);

        if (!$user) {
            return redirect()->away('https://smartbarangayconnect.com/login')->with('error', 'Invalid session token.');
        }

        // ✅ Store session in Laravel
        Session::put('id', $user['id']);
        Session::put('email', $user['email']);
        Session::put('first_name', $user['first_name']);
        Session::put('last_name', $user['last_name']);
        Session::put('session_token', $session_token);
        Session::put('role', 3); // Assign role 2

        // ✅ Redirect to dashboard
        return redirect()->route('dashboard.index');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->away('https://smartbarangayconnect.com'); // Redirect to main site after logout
    }
}

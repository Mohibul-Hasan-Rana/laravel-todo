<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function fetchPosts()
    {
        try {
            $response = Http::get('https://jsonplaceholder.typicode.com/posts');
            if ($response->successful()) {
                $posts = collect($response->json())->take(10);
                return $posts;
            }
            // $response = Http::get('https://jsonplaceholder.typicode.com/posts', [
            //     '_limit' => 5
            // ]);

            // if ($response->successful()) {
            //     return $response->json();
            // }
            
            return [];
        } catch (\Exception $e) {
            \Log::error('API fetch error: ' . $e->getMessage());
            return [];
        }
    }
}
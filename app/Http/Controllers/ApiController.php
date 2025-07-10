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
                $posts = $response->json();
                return array_slice($posts, 0, 10); 
            }
            
            return [];
        } catch (\Exception $e) {
            \Log::error('API fetch error: ' . $e->getMessage());
            return [];
        }
    }
}
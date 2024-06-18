<?php
namespace App\Http\Controllers;
// app/Http/Controllers/OpenAIController.php

use Illuminate\Http\Request;

class OpenAIController extends Controller
{
    public function getApiKey()
    {
        return response()->json(['api_key' => env('OPENAI_API_KEY')]);
    }
}


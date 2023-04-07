<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FallbackContoller extends Controller
{
    public function __invoke()
    {
        return view('fallback.index');
    }
}

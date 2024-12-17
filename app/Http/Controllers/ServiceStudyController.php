<?php

namespace App\Http\Controllers;

use App\Contracts\Video\VideoHosting;
use App\Services\Video\Youtube;
use Illuminate\Http\Request;

class ServiceStudyController extends Controller
{
    public function index(VideoHosting $service)
    {
        return view('studyservice', ['service' => $service ]);
    }
}

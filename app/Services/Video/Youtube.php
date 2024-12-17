<?php

namespace App\Services\Video;

use App\Contracts\Video\VideoHosting;

class Youtube implements VideoHosting
{
    protected $random;

    public function __construct()
    {
        $this->random = rand(0, 10000);
    }

    public function showMeString()
    {
        return 'You tube' . $this->random;
    }

    public function getVideoWidth()
    {
        return 750;
    }

    public function getVideoHeight()
    {
        return 800;
    }

    public function showString()
    {
        return $this->showMeString();
    }
}

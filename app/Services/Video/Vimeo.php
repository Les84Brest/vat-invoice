<?php

namespace App\Services\Video;

use App\Contracts\Video\VideoHosting;

class Vimeo implements VideoHosting
{
    protected $random;

    public function __construct()
    {
        $this->random = rand(0, 10000);
    }

    public function showMeRandomString()
    {
        return 'Vimeo' . $this->random;
    }


    public function getVideoWidth()
    {
        return 300;
    }

    public function getVideoHeight()
    {
        return 200;
    }

    public function showString()
    {
        return $this->showMeRandomString();
    }
}

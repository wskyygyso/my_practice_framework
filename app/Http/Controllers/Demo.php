<?php

namespace App\Http\Controllers;

use Library\Components\Response;
use Library\Http\Controller;

class Demo extends Controller
{
    public function welcome()
    {
        return (new Response())->msg("hello world!");
    }

    public function test()
    {
        return (new Response())->msg("this is test!");
    }
}

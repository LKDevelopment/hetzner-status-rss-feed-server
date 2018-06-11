<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CloudHostController extends Controller
{
    public function form()
    {
        return view('cloud_host.app');
    }
}

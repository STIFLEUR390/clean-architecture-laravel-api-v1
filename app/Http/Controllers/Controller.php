<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use KennedyOsaze\LaravelApiResponse\Concerns\RendersApiResponse;

class Controller extends BaseController
{
    // use AuthorizesRequests, ValidatesRequests;
    use AuthorizesRequests, DispatchesJobs, RendersApiResponse, ValidatesRequests;
}

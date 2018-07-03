<?php

namespace App\Http\Controllers\Internal\Api;

use App\Model\App\Build;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 *
 */
class BuildController extends Controller
{
    /**
     * @param $version_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBuildNumber($version_code)
    {
        return response()->json(['build' => Build::generateNewBuildNumberFor($version_code)]);
    }
}

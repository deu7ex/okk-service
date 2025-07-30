<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Http\Resources\LogResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LogController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        return LogResource::collection(Log::getList());
    }

    public function show(Log $log): LogResource
    {
        return new LogResource($log);
    }

}

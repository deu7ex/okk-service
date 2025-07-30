<?php

namespace App\Http\Controllers;

use App\Models\Segment;
use App\Http\Resources\SegmentResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SegmentController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        return SegmentResource::collection(Segment::getList());
    }

    public function show(Segment $segment): SegmentResource
    {
        return new SegmentResource($segment);
    }

}

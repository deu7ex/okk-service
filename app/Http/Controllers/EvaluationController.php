<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Http\Resources\EvaluationResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EvaluationController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        return EvaluationResource::collection(Evaluation::getList());
    }

    public function show(Evaluation $evaluation): EvaluationResource
    {
        return new EvaluationResource($evaluation);
    }

}

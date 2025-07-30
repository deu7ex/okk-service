<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\StoreTaskRequest;

class TaskController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        return TaskResource::collection(Task::getList());
    }

    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::recordDB($request->validated());

        return response()->json([
            'message' => 'Task created',
            'data' => $task
        ]);
    }

}

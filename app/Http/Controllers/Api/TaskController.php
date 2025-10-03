<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function show(Request $request)
    {
        $resp = [
            "success" => false,
            "data" => null,
            "message" => "Something went wrong!"
        ];

        // ✅ Simple API key check
        $apiKey = $request->header('X-API-KEY'); // or query param
        $validKey = config('app.api_key', 'MY_SECRET_KEY'); // set in .env if needed

        if ($apiKey !== $validKey) {
            $resp["message"] = "Unauthorized access.";
            return response()->json($resp, 401);
        }

        // ✅ Validate code param
        $request->validate([
            'code' => 'required|string',
        ]);

        $task = Task::with([
            'category' => function ($query) {
                $query->select('id', 'title', 'description');
            },
            'lists' => function ($q) {
                $q->select('id', 'task_id', 'title', 'type', 'total_time', 'is_timebase', 'image');
            },
            'lists.options' => function ($query) {
                $query->select('id', 'task_list_id', 'title', 'type', 'image', 'is_right');
            },
        ])
            ->where('code', $request->code)
            ->first();

        if (!$task) {
            $resp["message"] = "Task not found.";
            return response()->json($resp, 404);
        }

        $resp["success"] = true;
        $resp["data"] = $task;
        $resp["message"] = "Result fetched successfully.";
        return response()->json($resp);
    }
}

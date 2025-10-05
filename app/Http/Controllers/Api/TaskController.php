<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function show(Request $request)
    {
        $resp = [
            "success" => false,
            "data" => null,
            "message" => "Something went wrong!"
        ];

        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            // add other rules here: 'task_id' => 'required|integer', etc.
        ]);

        if ($validator->fails()) {
            $resp['message'] = 'Validation failed';
            $resp['data'] = $validator->errors(); // array of field => [errors]
            return response()->json($resp, 200);
        }

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

    public function submit(Request $request)
    {
        $resp = [
            "success" => false,
            "data" => null,
            "message" => "Something went wrong!"
        ];

        $validator = Validator::make($request->all(), [
            'code'        => 'required|string',
            'task_id'     => 'required|exists:tasks,id',
            'user_id'     => 'nullable|exists:users,id',
            'response'    => 'required|array',
            'response.*.id'  => 'required|integer|exists:task_lists,id',
            'response.*.ans' => 'required|integer|exists:task_list_options,id',
            'name'        => 'required_without:user_id|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $resp['message'] = 'Validation failed';
            $resp['data'] = $validator->errors();
            return response()->json($resp, 200);
        }

        // ✅ Fetch task with nested relations
        $task = Task::with([
            'category:id,title,description',
            'lists:id,task_id,title,type,total_time,is_timebase,image',
            'lists.options:id,task_list_id,title,type,image,is_right',
        ])->where('code', $request->code)->first();

        if (!$task) {
            $resp["message"] = "Task not found.";
            return response()->json($resp, 404);
        }

        // ✅ Decode response array
        $responses = $request->response;

        //dd($responses);

        $correct = 0;
        $wrong   = 0;

        foreach ($responses as $item) {
            $questionId = $item['id'];
            $selectedOptionId = $item['ans'];

            $question = $task->lists->firstWhere('id', $questionId);
            if (!$question) continue;

            $correctOption = $question->options->firstWhere('is_right', true);

            if ($correctOption && $correctOption->id == $selectedOptionId) {
                $correct++;
            } else {
                $wrong++;
            }
        }

        $result = [
            "total_questions" => count($task->lists),
            "attempted"       => count($responses),
            "correct"         => $correct,
            "wrong"           => $wrong,
        ];

        try {
            DB::beginTransaction();

            $result_message = sprintf(
                "Out of %d questions, you answered %d correctly and %d incorrectly.",
                $result['total_questions'],
                $result['correct'],
                $result['wrong']
            );
            TaskSubmission::create([
                'task_id'     => $request->task_id,
                'user_id'     => $request->user_id ?? null,
                'result'      => $result_message,
                'description' => $request->description ?? null,
                'remarks'     => $request->remarks ?? null,
                'response'    => json_encode($responses),
                'name'        => $request->name ?? null,
            ]);

            $resp["message"] = $result_message;

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $resp['message'] = 'Failed to save submission.';
            $resp['data'] = ['error' => $e->getMessage()];
            return response()->json($resp, 500);
        }
        $resp["success"] = true;
        unset($task['lists']);
        $resp["data"] = [
            "task"   => $task,
            "result" => $result,
            //"submission" => $submission,
        ];
        //$resp["message"] = "Result fetched successfully.";

        return response()->json($resp);
    }
}

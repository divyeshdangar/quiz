<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use Illuminate\Http\RedirectResponse;
use App\Models\Task;
use App\Models\TaskCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $metaData = [
            "breadCrumb" => [
                ["title" => "Task", "route" => ""],
            ],
            "title" => "Task List"
        ];
        $dataList = Task::orderBy('id', 'DESC');
        $dataList = $dataList->searching()->paginate(10)->withQueryString();
        return view('dashboard.task.index', ['dataList' => $dataList, 'metaData' => $metaData]);
    }

    public function view(Request $request, $id)
    {
        $dataDetail = Task::find(CommonHelper::decUrlParam($id));
        if ($dataDetail) {
            $metaData = [
                "breadCrumb" => [
                    ["title" => "Task", "route" => "dashboard.task"],
                    ["title" => "Detail", "route" => ""]
                ],
                "title" => "Task Detail"
            ];
            return view('dashboard.task.view', ['dataDetail' => $dataDetail, 'metaData' => $metaData]);
        } else {
            $message = [
                "message" => [
                    "type" => "error",
                    "title" => __('dashboard.bad'),
                    "description" => __('dashboard.no_record_found')
                ]
            ];
            return redirect()->route('dashboard')->with($message);
        }
    }

    public function list(Request $request, $id)
    {
        $dataDetail = Task::find(CommonHelper::decUrlParam($id));
        if ($dataDetail) {
            $metaData = [
                "breadCrumb" => [
                    ["title" => "Task", "route" => "dashboard.task"],
                    ["title" => "List", "route" => ""]
                ],
                "title" => "Task Detail"
            ];
            return view('dashboard.task.list', ['dataDetail' => $dataDetail, 'metaData' => $metaData]);
        } else {
            $message = [
                "message" => [
                    "type" => "error",
                    "title" => __('dashboard.bad'),
                    "description" => __('dashboard.no_record_found')
                ]
            ];
            return redirect()->route('dashboard')->with($message);
        }
    }

    public function create(Request $request)
    {
        $metaData = [
            "breadCrumb" => [
                ["title" => "Task", "route" => "dashboard.task"],
                ["title" => "Create", "route" => ""]
            ],
            "title" => "Create Task"
        ];
        $categoryData = TaskCategory::orderBy('title')->get();
        return view('dashboard.task.create', ['metaData' => $metaData, 'categoryData' => $categoryData]);
    }

    public function edit(Request $request, $id)
    {
        $dataDetail = Task::find(CommonHelper::decUrlParam($id));
        if ($dataDetail) {
            $categoryData = TaskCategory::orderBy('title')->get();
            return view('dashboard.task.edit', ['dataDetail' => $dataDetail, 'categoryData' => $categoryData, 'metaData' => []]);
        } else {
            $message = [
                "message" => [
                    "type" => "error",
                    "title" => __('dashboard.bad'),
                    "description" => __('dashboard.no_record_found')
                ]
            ];
            return redirect()->route('dashboard')->with($message);
        }
    }

    public function store(Request $request, $id): RedirectResponse
    {
        $id = CommonHelper::decUrlParam($id);
        $dataDetail = Task::find($id);
        if ($dataDetail || $id == 0) {
            if ($id == 0) {
                $dataDetail = new Task();
            }
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'code' => ['required', 'unique:Tasks,code,' . $id, 'min:5', 'max:255', 'regex:/^[a-z][a-z0-9]*(-[a-z0-9]+)*$/i'],                
                'description' => 'required',
                'task_category_id' => 'required',
                'total_time' => 'sometimes|integer',
            ]);

            if ($validator->fails()) {
                if ($id > 0) {
                    return redirect('dashboard/Task/edit/' . $id)->withErrors($validator)->withInput();
                } else {
                    return redirect('dashboard/Task/create')->withErrors($validator)->withInput();
                }
            }

            $dataToInsert = $validator->validated();

            if ($request->croppedImage != null) {
                $croped_image = $request->croppedImage;
                list($type, $croped_image) = explode(';', $croped_image);
                list(, $croped_image)      = explode(',', $croped_image);
                $croped_image = base64_decode($croped_image);
                $image_name = time() . rand(10000000, 999999999) . '.png';
                file_put_contents("./images/task/" . $image_name, $croped_image);
                $dataDetail->image = $image_name;
            }

            $is_timebase = $request->has('is_timebase');
            $is_individual = $request->has('is_individual');

            $dataDetail->title = $dataToInsert['title'];
            $dataDetail->user_id = Auth::id();
            $dataDetail->description = $dataToInsert['description'];
            $dataDetail->code = $dataToInsert['code'];
            $dataDetail->total_time = $dataToInsert['total_time'];
            $dataDetail->task_category_id = $dataToInsert['task_category_id'];
            $dataDetail->is_timebase = $is_timebase;
            $dataDetail->is_individual = $is_individual;
            $dataDetail->save();

            $message = [
                "message" => [
                    "type" => "success",
                    "title" => __('dashboard.great'),
                    "description" => __('dashboard.details_submitted')
                ]
            ];
            return redirect()->route('dashboard.task')->with($message);
        } else {
            return redirect()->route('dashboard.task');
        }
    }

    public function delete(Request $request, $id)
    {
        $dataDetail = Task::find(CommonHelper::decUrlParam($id));
        if ($dataDetail) {
            $dataDetail->delete();
            $message = [
                "message" => [
                    "type" => "success",
                    "title" => __('dashboard.great'),
                    "description" => __('dashboard.record_deleted')
                ]
            ];
            return redirect()->route('dashboard.task')->with($message);
        } else {
            $message = [
                "message" => [
                    "type" => "error",
                    "title" => __('dashboard.bad'),
                    "description" => __('dashboard.no_record_found')
                ]
            ];
            return redirect()->route('dashboard.task')->with($message);
        }
    }
}

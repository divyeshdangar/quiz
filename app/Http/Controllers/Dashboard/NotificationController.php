<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $metaData = [
            "breadCrumb" => [
                ["title" => "Notification", "route" => ""]
            ],
            "title" => "Notification"
        ];

        $dataList = Notification::orderBy('id', 'DESC');
        $dataList = $dataList->searching()->where('user_id', Auth::id())->paginate(10)->withQueryString();
        
        if($dataList->count() > 0) {
            foreach ($dataList as $key => $value) {

                $data = [
                    "user" => ($value->user) ? ucwords($value->user->name) : "",
                    "user2" => ($value->user2) ? ucwords($value->user2->name) : "",
                    "extra" => ($value->extra($value->message_tag)) ? $value->extra($value->message_tag)->title : "",
                ];
                $value->msg = __($value->message_tag, $data);
            }
        }
        return view('dashboard.user.notification', ['dataList' => $dataList, 'metaData' => $metaData]);
    }

    public function action(Request $request, $action)
    {
        $message = [
            "message" => [
                "type" => "error",
                "title" => __('dashboard.bad'),
                "description" => __('dashboard.no_record_found')
            ]
        ];
        try {
            $data = decrypt($action);
            if(!empty($data) && !empty($data["id"] > 0)) {
                $notificationDetail = Notification::find($data["id"]);
                if($notificationDetail) {
                    if($notificationDetail->is_action_done == 0) {

                        $memberDetail = Member::where([
                            'user_id' => $notificationDetail->user_id2,
                            'member_id' => $notificationDetail->user_id,
                            'status' => '0'
                        ])->first();

                        if($memberDetail) {
                            $memberDetail->status = $data["status"];
                            $memberDetail->save();

                            $notificationDetail->is_action_done = '1';
                            $notificationDetail->save();

                            $message = [
                                "message" => [
                                    "type" => "success",
                                    "title" => __('dashboard.great'),
                                    "description" => __('dashboard.details_submitted')
                                ]
                            ];
                        }
                    } else {
                        $message["message"]["description"] = "Invalid Action.";                        
                    }
                }
            }
        } catch (\Throwable $th) {
        }

        return redirect()->route('dashboard.notification')->with($message);
    }
}

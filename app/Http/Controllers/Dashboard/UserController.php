<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMenu;
use App\Models\Menu;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $metaData = [
            "breadCrumb" => [
                ["title" => __('dashboard.user'), "route" => ""]
            ],
            "title" => __('dashboard.user')
        ];
        $dataList = User::orderBy('id', 'DESC');
        $dataList = $dataList->searching()->paginate(10)->withQueryString();    
        return view('dashboard.user.index', ['dataList' => $dataList, 'metaData' => $metaData]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|email|unique:users,email',
            'first_name' => 'required|min:3|max:255',
            'last_name' => 'required|min:3|max:255',
            'password' => 'required|min:6|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('dashboard/user')->withErrors($validator)->withInput();
        }

        $dataToInsert = $validator->validated();
        $data = [
            'name' => $dataToInsert['first_name'] . " " . $dataToInsert['last_name'],
            'first_name' => $dataToInsert['first_name'],
            'last_name' => $dataToInsert['last_name'],
            'email' => $dataToInsert['email'],
            'token' => "",
            'profile' => "default.png",
            'social_id' => "",
            'login_type' => 'SL',
            'password' => \Hash::make($dataToInsert['password'])
        ];

        $user = User::create($data);
        if (!empty($user) && isset($user->id)) {
            $data = [
                'message_tag' => 'msg.your_account_created_by',
                'user_id' => $user->id,
                'user_id2' => Auth::id(),
            ];
            Notification::create($data);
        }

        $message = [
            "message" => [
                "type" => "success",
                "title" => __('dashboard.great'),
                "description" => __('dashboard.details_submitted')
            ]
        ];
        return redirect()->route('dashboard.user')->with($message);
    }

    public function edit(Request $request, $id)
    {
        $dataDetail = User::find($id);
        $menuList = Menu::where('title_only', '0')->orderBy('order', 'ASC')->get();
        
        if($dataDetail) {
            $metaData = [
                "breadCrumb" => [
                    ["title" => "User", "route" => "dashboard.user"],
                    ["title" => "Edit", "route" => ""]
                ],
                "title" => "Edit User"
            ];

            return view('dashboard.user.edit', ['dataDetail' => $dataDetail, 'metaData' => $metaData, 'menuList' => $menuList]);
        } else {
            $message = [
                "message" => [
                    "type" => "error",
                    "title" => __('dashboard.bad'),
                    "description" => __('dashboard.no_record_found')
                ]
            ];
            return redirect()->route('dashboard.user')->with($message);
        }
    }

    public function access(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'menuIds' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return redirect('dashboard/user')->withErrors($validator)->withInput();
        }

        $dataToInsert = $validator->validated();

        $dataDetail = UserMenu::where('user_id', $id)->first();        
        if(!$dataDetail) {
            $dataDetail = new UserMenu();
            $dataDetail->user_id = $id;
        }
        
        if(isset($dataToInsert['menuIds'])) {
            $dataDetail->menuIds = implode(",", $dataToInsert['menuIds']);
        } else {
            $dataDetail->menuIds = "";
        }
        $dataDetail->save();

        $message = [
            "message" => [
                "type" => "success",
                "title" => __('dashboard.great'),
                "description" => __('dashboard.details_submitted')
            ]
        ];
        return redirect()->route('dashboard.user.edit', ['id' => $id])->with($message);
    }


}

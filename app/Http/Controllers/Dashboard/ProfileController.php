<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function show(Request $request): View
    {
        $dataDetail = User::find(Auth::id());
        if($dataDetail) {
            return view('dashboard.user.profile', ['dataDetail' => $dataDetail, 'metaData' => []]);
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

    public function index(Request $request): View
    {
        $dataDetail = User::find(Auth::id());
        if($dataDetail) {
            return view('dashboard.user.profile-edit', ['dataDetail' => $dataDetail, 'metaData' => []]);
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

    public function store(Request $request): RedirectResponse
    {
        $dataDetail = User::find(Auth::id());
        if($dataDetail) {
            $validator = Validator::make($request->all(), [
                // 'first_name' => 'required|max:255',
                // 'last_name' => 'required|max:255',
                // 'email' => 'required|max:255|email',
                'username' => ['required','unique:users,username,'.Auth::id(), 'min:5','max:20','regex:/^[a-z][a-z0-9]*(_[a-z0-9]+)*$/i'],
                'phone' => 'required|digits:10',
                'bio' => 'required',
            ]);
    
            if ($validator->fails()) {
                return redirect('user/profile/edit')->withErrors($validator)->withInput();
            }    
            $dataToInsert = $validator->validated();
            $dataDetail->bio = $dataToInsert['bio'];
            $dataDetail->phone = $dataToInsert['phone'];
            $dataDetail->username = $dataToInsert['username'];
            $dataDetail->save();

            $message = [
                "message" => [
                    "type" => "success",
                    "title" => __('dashboard.great'),
                    "description" => __('dashboard.details_submitted')
                ]
            ];
            return redirect()->route('dashboard')->with($message);
        } else {
            return redirect()->route('dashboard');
        }
    }
}

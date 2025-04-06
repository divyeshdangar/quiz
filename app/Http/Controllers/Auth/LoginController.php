<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            $message = [
                "message" => [
                    "type" => "info",
                    "title" => __('dashboard.wait'),
                    "description" => __('dashboard.already_login')    
                ]
            ];
            return redirect()->route('dashboard')->with($message);
        } else {
            // to set meta data of page
            $metaData = [
                "title" => "Login to GujjuTicks",
                "description" => "Reach out to GujjuTicks easily with our contact form or contact information. Whether you have questions, feedback, or inquiries, we're here to assist you promptly. Connect with us now!",
                //"image" => "",
                "url" => route('login')
            ];
            return view('pages.auth.login', ['metaData' => $metaData]);
        }
    }

    public function login(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')->withErrors($validator)->withInput();
        }  
                
        $credentials = $request->only('email', 'password'); 
        if (Auth::attempt($credentials)) {
            $dataToInsert = $validator->validated();
            $data = [
                "email" => $dataToInsert['email'],
            ];
            $user = User::where($data)->first();
            Auth::login($user);
            return redirect()->route('dashboard');
        } else {
            $message = [
                "message" => [
                    "type" => "warning",
                    "title" => __('dashboard.wait'),
                    "description" => __('dashboard.login_error')
                ]
            ];
            return redirect()->route('login')->with($message);
        }
    }    

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}

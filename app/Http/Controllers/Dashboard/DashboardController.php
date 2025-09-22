<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserMenu;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.dashboard.home', ['metaData' => []]);
    }
}

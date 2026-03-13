<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $user = Auth::user();


        if ($user->role === 'admin') {
            return view('pages.admin.dashboard');
        } elseif ($user->role === 'organizer') {
            return view('pages.organizer.dashboard');
        } else {
            return view('pages.user.dashboard');
        }
    }
}

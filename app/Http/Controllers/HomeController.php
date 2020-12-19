<?php

namespace App\Http\Controllers;

use App\Constants\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->role == Role::VENDOR) {
            return redirect()->route('productsByVendor', Auth::user()->vendorId());
        } elseif (Auth::check() && Auth::user()->role == Role::ORGANIZER) {
            return redirect()->route('eventsByOrganizer', Auth::user()->organizerId());
        } else {
            return redirect()->route('events');
        }
    }
}

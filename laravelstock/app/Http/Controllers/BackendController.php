<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function dashboard(){
        return view('backend.pages.dashboard');
    }
    public function blank(){
        return view('backend.pages.blank');
    }
    public function logout(){
        return redirect('login');
    }
    public function Reports(){
        return redirect('reports');
    }
    public function users(){
        return redirect('users');
    }
    public function settings(){
        return redirect('settings');
    }
    public function nopermission(){
        return view('backend.pages.nopermission');
    }
}

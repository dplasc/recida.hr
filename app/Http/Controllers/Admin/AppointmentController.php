<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class AppointmentController extends Controller
{
    public function appointments(){
        return view('admin.appointment.index');
    }
}

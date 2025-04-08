<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageNotificationController extends Controller
{
    //For Message
     public function showSweetAlertMessages(){

     // Flash messages settings
    
     session()->flash("success", "This is success message");

     session()->flash("warning", "This is warning message");

     session()->flash("info", "This is information message");

     session()->flash("error", "This is error message");

     return view("sweetalert-notification");
   }

}

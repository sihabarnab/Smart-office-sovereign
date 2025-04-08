<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        return view('admin/home');
    }

    public function hrm()
    {
        return view('hrm/home');
    }

    public function inventory()
    {
        return view('inventory/home');
    }
    public function purchase()
    {
        return view('purchase/home');
    }

    public function sales()
    {
        return view('sales/home');
    }

    public function service()
    {
        return view('service/home');
    }

    public function crm()
    {
        return view('crm/home');
    }

    public function maintenance()
    {
        return view('maintenance/home');
    }

    public function worker()
    {
        return view('worker.home');
    }
    public function mechanical()
    {
        return view('mechanical.home');
    }
    public function electrical()
    {
        return view('electrical.home');
    }
   
}

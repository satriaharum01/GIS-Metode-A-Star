<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Graf;
use App\Models\Halte;
use App\Models\Koridor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->data['count_halte'] = $this->getAllHalte();
        $this->data['count_user'] = $this->getAllUser();
        $this->data['count_bus'] = $this->getAllBus();
        $this->data['count_koridor'] = $this->getAllKoridor();
        $this->data['count_graf'] = $this->getAllGraf();
        $this->data['title'] = 'Dashboard Admin';
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('index',$this->data);
    }

    public function getAllHalte()
    {
        $data = Halte::select('*')->count();

        return $data;
    }
    
    public function getAllUser()
    {
        $data = User::select('*')->count();

        return $data;
    }

    public function getAllBus()
    {
        $data = Bus::select('*')->count();

        return $data;
    }
    
    public function getAllKoridor()
    {
        $data = Koridor::select('*')->count();

        return $data;
    }
    
    public function getAllGraf()
    {
        $data = Graf::select('*')->count();

        return $data;
    }
}

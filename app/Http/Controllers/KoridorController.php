<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Halte;
use App\Models\Koridor;
use App\Models\Node;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class KoridorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data['title'] = 'Data Koridor';
        $this->middleware('auth');
        $this->data['add_url'] = url('admin/koridor/new');
        $this->data['back_url'] = url('admin/koridor');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('koridor.index', $this->data);
    }

    public function edit($id)
    {
        $data = Koridor::select('*')
            ->where('id', '=', $id)
            ->first();
        $this->data['koridor'] = $data;
        return view('koridor.edit', $this->data);
    }

    public function new()
    {
        return view('koridor.new', $this->data);
    }

    public function json()
    {
        $data = Koridor::select('*')
            ->get();
        foreach($data as $row)
        {
            $row->halte_count = Halte::select('*')->where('koridor','=',$row->id)->count();
            $row->bus_count = Bus::select('*')->where('koridor_id','=',$row->id)->get()->count();
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
    public function update(Request $request, $id)
    {
        $rows = Koridor::find($id);
        $rows->update([
            'kode' => $request->kode,
            'nama' => $request->nama
        ]);

        return redirect(route('admin.koridor'));
    }
    
    public function store(Request $request)
    {
        DB::table('koridor')->insert([
            'kode' => $request->kode,
            'nama' => $request->nama
        ]);

        return redirect(route('admin.koridor'));
    }
    
    public function destroy($id)
    {
        $rows = Koridor::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.koridor'));
    }
}

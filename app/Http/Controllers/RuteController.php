<?php

namespace App\Http\Controllers;

use App\Models\Cordinat;
use App\Models\Graf;
use App\Models\Halte;
use App\Models\Node;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class RuteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data['title'] = 'Data Rute';
        $this->middleware('auth');
        $this->data['add_url'] = url('admin/rute/new');
        $this->data['back_url'] = url('admin/rute');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('rute.index', $this->data);
    }

    public function getjson($id)
    {
        $data = Cordinat::select('*')
            ->where('halte_id', '=', $id)->get();
        foreach($data as $row)
        {
            $row->latitude = substr($row->latitude,0,8);
            $row->longitude = substr($row->longitude,0,8);
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
    public function destroy($id)
    {
        $rows = Cordinat::findOrFail($id);
        $rows->delete();
    }
    
    public function get_mark($id)
    {
        $data = Cordinat::select('*')
            ->where('halte_id', '=', $id)->get();

        return json_encode($data);
    }

    public function findGraf($id)
    {
        $out = array();
        $data = Graf::select('*')
            ->where('end', '=', $id)->get();
        foreach ($data as $row) {
            $out[] = Node::find($row->start);
        }


        return json_encode($out);
    }

    public function store(Request $request)
    {
        $node = Cordinat::select('*')
            ->where('latitude', '=', $request->latitude)
            ->where('longitude', '=', $request->longitude)
            ->where('halte_id', '=', $request->halte_data)
            ->first();
        if (empty($node->id_cords)) {
            DB::table('cordinat')->insert([
                'halte_id' => $request->halte_data,
                'keterangan' => $request->keterangan,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);
        }
    }
}

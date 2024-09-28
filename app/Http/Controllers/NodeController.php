<?php

namespace App\Http\Controllers;

use App\Models\Node;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class NodeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data['title'] = 'Data Node';
        $this->middleware('auth');
        $this->data['add_url'] = url('node/new');
        $this->data['back_url'] = url('node');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        $this->middleware('auth');
        return view('rute.index', $this->data);
    }

    public function json()
    {
        $data = DB::table('node')
            ->get();


        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function json_map()
    {
        $data = Node::select('node.id', 'halte.nama as halte_id', 'node.latitude', 'node.longitude')
            ->leftJoin('halte', function ($join) {
                $join->on('halte.node_id', '=', 'node.id');
            })
            ->where('halte.node_id', '=', null)
            ->get();
        /*
        $data = Node::select('node.id', 'halte.nama as halte_id', 'node.latitude', 'node.longitude')
            ->leftJoin('halte', function ($join) {
                $join->on('halte.node_id', '=', 'node.id');
            })
            ->get();
        */
        return json_encode($data);
    }
    public function store(Request $request)
    {
        $node = Node::select('*')
            ->where('latitude', '=', $request->lat)
            ->where('longitude', '=', $request->lng)
            ->first();
        if (empty($node->id)) {
            DB::table('node')->insert([
                'latitude' => $request->lat,
                'longitude' => $request->lng
            ]);
        }
    }

    public function destroy($id)
    {
        $rows = Node::findOrFail($id);
        $rows->delete();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Halte;
use App\Models\Koridor;
use App\Models\Node;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class HalteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data['title'] = 'Data Halte';
        $this->middleware('auth');
        $this->data['add_url'] = url('admin/halte/new');
        $this->data['back_url'] = url('admin/halte');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('halte.index', $this->data);
    }

    public function update(Request $request, $id)
    {
        $node = Node::select('*')
            ->where('latitude', '=', $request->latitude)
            ->where('longitude', '=', $request->longitude)
            ->first();

        if (empty($node->id)) {
            DB::table('node')->insert([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);
        }

        $node = Node::select('*')
            ->where('latitude', '=', $request->latitude)
            ->where('longitude', '=', $request->longitude)
            ->first();

        $rows = Halte::find($id);
        $rows->update([
            'koridor' => $request->koridor,
            'kode' => $request->kode,
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'node_id' => $node->id
        ]);

        return redirect(route('admin.halte'));
    }

    public function edit($id)
    {
        $data = Koridor::select('*')->get();
        $data2 = Halte::select('*')
            ->where('id', '=', $id)
            ->first();

        $ket = (array(array('value' => 'Kecil'), array('value' => 'Sedang'), array('value' => 'Besar')));
        $this->data['halte_id'] = $id;
        $this->data['halte'] = $data2;
        $this->data['node_latitude'] = $data2->Node->latitude;
        $this->data['node_longitude'] = $data2->Node->longitude;
        $this->data['koridor_load'] = $data;
        $this->data['ket_load'] = $ket;
        return view('halte.edit', $this->data);
    }

    public function new()
    {
        $data = Koridor::select('*')->get();
        $this->data['halte_id'] = 0;
        $this->data['koridor_load'] = $data;
        $ket = (array(array('value' => 'Kecil'), array('value' => 'Sedang'), array('value' => 'Besar')));
        $this->data['ket_load'] = $ket;

        return view('halte.new', $this->data);
    }

    public function json()
    {
        $data = Halte::select('*')
            ->get();
        foreach ($data as $row) {
            $row->koridor_nama = $row->Koridor->nama . $row->Koridor->kode;
            $row->lat = $row->Node->latitude;
            $row->lng = $row->Node->longitude;
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function getjson($id)
    {
        $data = Halte::select('*')
            ->where('id', '=', $id)
            ->get();
        foreach ($data as $row) {
            $row->latitude = $row->Node->latitude;
            $row->longitude = $row->Node->longitude;
            unset($row->Node);
        }

        return json_encode($data);
    }

    public function store(Request $request)
    {
        $node = Node::select('*')
            ->where('latitude', '=', $request->latitude)
            ->where('longitude', '=', $request->longitude)
            ->first();
        if (empty($node->id)) {
            DB::table('node')->insert([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);
        }
        $node = Node::select('*')
            ->where('latitude', '=', $request->latitude)
            ->where('longitude', '=', $request->longitude)
            ->first();

        DB::table('halte')->insert([
            'koridor' => $request->koridor,
            'kode' => $request->kode,
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'node_id' => $node->id
        ]);

        return redirect(route('admin.halte'));
    }

    public function destroy($id)
    {
        $rows = Halte::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.halte'));
    }

    public function json_map()
    {
        $data = Halte::select('*')
            ->get();
        foreach ($data as $row) {
            $row->latitude = $row->Node->latitude;
            $row->longitude = $row->Node->longitude;
            $row->halte_id = $row->nama;
        }

        return json_encode($data);
    }
}

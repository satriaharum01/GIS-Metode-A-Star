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


class GrafController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data['title'] = 'Data Graf';
        $this->middleware('auth');
        $this->data['add_url'] = url('graf/new');
        $this->data['back_url'] = url('graf');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('graf.index', $this->data);
    }

    public function json()
    {
        $data = DB::table('graf')
            ->get();

        foreach ($data as $row) {
            $row->end_nama = Halte::where('node_id', '=', $row->end)->max('nama');
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function store(Request $request)
    {
        $rute = json_encode($request->rute);
        DB::table('graf')->insert([
            'start' => $request->start,
            'end' => $request->end,
            'rute' => $rute
        ]);
    }

    public function destroy($id)
    {
        $rows = Graf::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.graf'));
    }

    public function detail_rute($id)
    {
        $out = array();
        $data = Graf::select('*')->where('id', '=', $id)->first();
        if (isset($data->rute)) {
            $count = count(json_decode($data->rute));
            $rute = json_decode($data->rute);
            $j = $count - 1;
            for ($i = 0; $i < $count; $i++) {
                $off[]['identity'] = $rute[$i];
                if ($i == 0) {
                    $s1 = 'Node ' . $data->start;
                    $s2 = Cordinat::select('keterangan')->where('id_cords', '=', $rute[$i])->first();
                    $out[$i]['nama'] = $s1 . '->' . $s2->keterangan;
                    $out[$i]['cords_id'] = $rute[$i];
                } elseif ($i == $j) {
                    $s1 = Cordinat::select('keterangan')->where('id_cords', '=', $rute[$i])->first();
                    $s2 = Halte::select('*')->where('node_id', '=', $data->end)->first();
                    $out[$i]['nama'] = $s1->keterangan . '->' . $s2->nama;
                    $out[$i]['cords_id'] = $rute[$i];
                } else {
                    $s1 = Cordinat::select('keterangan')->where('id_cords', '=', $rute[$i])->first();
                    $s2 = Cordinat::select('keterangan')->where('id_cords', '=', $rute[$i + 1])->first();
                    $out[$i]['nama'] = $s1->keterangan . '->' . $s2->keterangan;
                    $out[$i]['cords_id'] = $rute[$i];
                }
            }

            $result = array('data' => $out);
            return Datatables::of($out)
                ->addIndexColumn()
                ->make(true);
        } else {
            $data = array();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function get_halte($id)
    {
        $data = Graf::select('*')
            ->where('end', '=', $id)
            ->get();

        foreach ($data as $row) {
            $new = array();
            $row->end_nama = Halte::where('node_id', '=', $row->end)->max('nama');
            $row->start_nama = 'Node ' . $row->start;
            foreach (json_decode($row->rute) as $temp) {
                $new[] = Cordinat::find($temp);
            }
            $row->rute_list = '';
            foreach ($new as $n) {

                if (!next($new)) {
                    if (!isset($n['keterangan'])) {
                        $row->rute_list .= 'Tidak Ditemukan';
                    } else {
                        $row->rute_list .= $n['keterangan'];
                    }
                } else {
                    if (!isset($n['keterangan'])) {
                        $row->rute_list .= 'Tidak Ditemukan' . ', ';
                    } else {
                        $row->rute_list .= $n['keterangan'] . ', ';
                    }
                }
            }
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}

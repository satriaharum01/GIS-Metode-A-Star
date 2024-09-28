<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Halte;
use App\Models\Koridor;
use App\Models\Node;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class BusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data['title'] = 'Data Bus';
        $this->middleware('auth');
        $this->data['add_url'] = url('admin/bus/new');
        $this->data['back_url'] = url('admin/bus');
        //$this->middleware('is_admin');
    }

    /*
     * Dashboad Function
    */
    public function index()
    {
        return view('bus.index', $this->data);
    }

    public function edit($id)
    {
        $data = Bus::select('*')
            ->where('id', '=', $id)
            ->first();
        $data->jam_start = str_replace('.', ':', substr($data->jam_operasional, 0, 5));
        $data->jam_end = str_replace('.', ':', substr($data->jam_operasional, -5));
        $data2 = Koridor::select('*')->get();
        $this->data['bus'] = $data;
        $this->data['koridor_load'] = $data2;
        return view('bus.edit', $this->data);
    }

    public function new()
    {
        $data = Koridor::select('*')->get();
        $this->data['koridor_load'] = $data;
        return view('bus.new', $this->data);
    }

    public function json()
    {
        $data = Bus::select('*')
            ->get();
        foreach ($data as $row) {
            $row->koridor_nama = $row->Koridor->nama . $row->Koridor->kode;
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $file = $request->file('foto');
        if (isset($file)) {
            $name = preg_replace('/\s+/', '_', $request->tipe);
            $ext = '.' . $file->getClientOriginalExtension();
            $filename = $name . '-' . $request->lambung . '-' . $ext;
            $this->foto_destroy($filename);
            $file->storeAs('', $filename, ['disk' => 'public_uploads']);
        } else {
            $filename = $request->filename_old;
        }

        $jam_opt = str_replace(':', '.', $request->jam_start) . ' - ' . str_replace(':', '.', $request->jam_end);

        $rows = Bus::find($id);
        $rows->update([
            'tipe' => $request->tipe,
            'lambung' => $request->lambung,
            'sumber_energi' => $request->sumber_energi,
            'muatan' => $request->muatan,
            'jam_operasional' => $jam_opt,
            'foto' => $filename,
            'koridor_id' => $request->koridor
        ]);

        return redirect(route('admin.bus'));
    }

    public function store(Request $request)
    {
        $name = preg_replace('/\s+/', '_', $request->tipe);
        $file = $request->file('foto');
        $ext = '.' . $file->getClientOriginalExtension();
        $filename = $name . '-' . $request->lambung . '-' . $ext;
        $this->foto_destroy($filename);
        $file->storeAs('', $filename, ['disk' => 'public_uploads']);
        $jam_opt = str_replace(':', '.', $request->jam_start) . ' - ' . str_replace(':', '.', $request->jam_end);

        DB::table('bus')->insert([
            'tipe' => $request->tipe,
            'lambung' => $request->lambung,
            'sumber_energi' => $request->sumber_energi,
            'muatan' => $request->muatan,
            'jam_operasional' => $jam_opt,
            'foto' => $filename,
            'koridor_id' => $request->koridor
        ]);

        return redirect(route('admin.bus'));
    }

    public function destroy($id)
    {
        $rows = Bus::findOrFail($id);
        $rows->delete();

        return redirect(route('admin.bus'));
    }

    public function foto_destroy($filename)
    {
        if (File::exists(public_path('img/' . $filename . ''))) {
            File::delete(public_path('img/' . $filename . ''));
        }
    }
}

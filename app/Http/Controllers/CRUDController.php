<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Algorithm;

use App\Models\Reseller;
use App\Models\Kurir;
use App\Models\Detail;
use App\Models\Barang;
use App\Models\Graf;
use App\Models\Transaksi;
use PhpParser\Builder\Trait_;

use function PHPUnit\Framework\isEmpty;

class CRUDController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //GRAF
    public function store_graf(Request $request)
    {
        DB::table('graf')->insert([
            'rute' => $request->rute,
            'lat' => $request->lat,
            'long' => $request->long,
            'jarak' => $request->jarak,
            'id_reseller' => $request->reseller
        ]);

        return redirect('/graf');
    }

    public function update_graf(Request $request, $id)
    {
        $rows = Graf::find($id);
        $rows->update([
            'rute' => $request->rute,
            'lat' => $request->lat,
            'long' => $request->long,
            'jarak' => $request->jarak,
            'id_reseller' => $request->reseller
        ]);

        return redirect('/graf');
    }

    public function destroy_graf($id)
    {
        $rows = Graf::findOrFail($id);
        $rows->delete();

        return redirect('/graf');
    }

    public function getjson_graf($id)
    {
        $data = Graf::find($id);

        return json_encode(array('data' => $data));
    }

    public function getreseller()
    {
        $data = Reseller::select('*')
            ->orderby('id_reseller', 'ASC')
            ->get();

        return json_encode(array('data' => $data));
    }

    public function getkurir()
    {
        $data = Kurir::select('*')
            ->orderby('id_kurir', 'ASC')
            ->get();

        return json_encode(array('data' => $data));
    }

    public function getparfum()
    {
        $data = Barang::select('*')
            ->orderby('id_barang', 'ASC')
            ->get();

        return json_encode(array('data' => $data));
    }
    //Reseller
    public function store_reseller(Request $request)
    {
        DB::table('reseller')->insert([
            'nama_reseller' => $request->reseller,
            'hp' => $request->hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'gabung' => $request->tahun,
            'latitude' => $request->lat,
            'longitude' => $request->long
        ]);

        return redirect('/reseller');
    }

    public function update_reseller(Request $request, $id)
    {
        $rows = Reseller::find($id);
        $rows->update([
            'nama_reseller' => $request->reseller,
            'hp' => $request->hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'gabung' => $request->tahun,
            'latitude' => $request->lat,
            'longitude' => $request->long
        ]);

        return redirect('/reseller');
    }

    public function destroy_reseller($id)
    {
        $rows = Reseller::findOrFail($id);
        $rows->delete();

        return redirect('/reseller');
    }

    public function getjson_reseller($id)
    {
        $data = Reseller::find($id);

        return json_encode(array('data' => $data));
    }

    //Parfum
    public function store_parfum(Request $request)
    {
        DB::table('barang')->insert([
            'nama_barang' => $request->nama
        ]);

        return redirect('/parfum');
    }

    public function update_parfum(Request $request, $id)
    {
        $rows = Barang::find($id);
        $rows->update([
            'nama_barang' => $request->nama
        ]);

        return redirect('/parfum');
    }

    public function destroy_parfum($id)
    {
        $rows = Barang::findOrFail($id);
        $rows->delete();

        return redirect('/parfum');
    }

    public function getjson_parfum($id)
    {
        $data = Barang::find($id);

        return json_encode($data);
    }

    //Kurir
    public function store_kurir(Request $request)
    {
        DB::table('kurir')->insert([
            'nama_kurir' => $request->kurir
        ]);

        return redirect('/kurir');
    }

    public function update_kurir(Request $request, $id)
    {
        $rows = Kurir::find($id);
        $rows->update([
            'nama_reseller' => $request->kurir
        ]);

        return redirect('/kurir');
    }

    public function destroy_kurir($id)
    {
        $rows = Kurir::findOrFail($id);
        $rows->delete();

        return redirect('/kurir');
    }

    public function getjson_kurir($id)
    {
        $data = Kurir::find($id);

        return json_encode(array('data' => $data));
    }

    //Transaksi
    public function store_transaksi(Request $request)
    {
        $query = Transaksi::max('id_transaksi');
        $id = $query + 1;

        DB::table('transaksi')->insert([
            'id_transaksi' => $id,
            'tanggal' => $request->Tanggal,
            'harga' => $request->Total,
            'pembayaran' => $request->Pembayaran,
            'id_reseller' => $request->Reseller,
            'id_kurir' => $request->Kurir
        ]);


        $detail = $request->Cart;
        //unset($detail[0]);
        $clear = array_filter($detail);
        foreach ($clear as $cart) {
            DB::table('transaksi_detail')->insert([
                'id_barang' => $cart['id_barang'],
                'qty' => $cart['qty'],
                'id_transaksi' => $id
            ]);
        }

        return response()->json(
            [
                'success' => true,
                'message' => json_encode($clear)
            ]
        );
    }

    public function update_transaksi(Request $request, $id)
    {
        $rows = Transaksi::find($id);
        $rows->update([
            'tanggal' => $request->tanggal,
            'pembayaran' => $request->pembayaran,
            'id_reseller' => $request->reseller,
            'id_kurir' => $request->kurir

        ]);

        return redirect('/transaksi');
    }

    public function update_detail(Request $request, $id)
    {
        $rows = Detail::find($id);
        $rows->update([
            'qty' => $request->qty
        ]);
        $newrows = Detail::select('qty')
            ->where('id_transaksi', '=', $rows->id_transaksi)
            ->sum('qty');
        $harga = $newrows * 65000;

        $patch = Transaksi::find($rows->id_transaksi);
        $patch->update([
            'harga' => $harga
        ]);

        return redirect('/transaksi');
    }

    public function destroy_transaksi($id)
    {
        $rows = Detail::select('*')
            ->where('id_transaksi', '=', $id)
            ->delete();

        $rows = Transaksi::findOrFail($id);
        $rows->delete();

        return redirect('/transaksi');
    }

    public function getjson_transaksi($id)
    {
        $data = Transaksi::find($id);

        return json_encode(array('data' => $data));
    }

    public function getjson_detail($id)
    {
        $data = Detail::find($id);

        return json_encode(array('data' => $data));
    }
}

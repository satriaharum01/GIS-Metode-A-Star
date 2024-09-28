<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DataTables;

use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $push['no'] = 1;
        $push['data'] = User::
        orderby('id', 'ASC')
        ->orderby('level', 'ASC')
        ->get();

        return view('home', $push);
    }

    public function destroy($id)
    {
        $rows = User::findOrFail($id);
        $rows->delete();
        return redirect('/users');
    
    }

    public function update(Request $request, $id)
    {
        $rows = User::find($id);
        if($request->password == true){
            $rows->update([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => $request->level,
                'update_at' => now()
             ]);
        }else{
            $rows->update([
                'name' => $request->nama,
                'email' => $request->email,
                'level' => $request->level,
                'update_at' => now()
             ]);
        }

        return redirect('/users');
    
    }

    public function store(Request $request)
    {
        DB::table('users')->insert([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level  
        ]);

        return redirect('/users');
    
    }
}

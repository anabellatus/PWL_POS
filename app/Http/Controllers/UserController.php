<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('user.index');
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        UserModel::create([
            'nama' => $request->nama,
            'level_id' => $request->levelId,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/user');
    }

    public function edit($id)
    {
        $user = UserModel::find($id);
        $levels = LevelModel::all();
        return view('user.edit', compact('user', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $user = UserModel::find($id);

        $user-> nama = $request->nama;
        $user-> level_id = $request->levelId;
        $user-> username = $request->username;
        $user-> password = Hash::make($request->password);
        $user->save();

        return redirect('/user')->with('success', 'User berhasil diupdate');
    }

    public function delete($id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            abort(404);
        }

        $user->delete();

        return redirect('/user')->with('success', 'User berhasil dihapus');
    }

    public function getLevel(){
        $levels = LevelModel::all();
        return view('user.create', ['levels' => $levels]);
    }

}

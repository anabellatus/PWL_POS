<?php

namespace App\Http\Controllers;

use App\DataTables\LevelDataTable;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index(LevelDataTable $dataTable)
    {
        return $dataTable->render('level.index');
    }

    public function create()
    {
        return view('level.create');
    }

    public function store(Request $request)
    {
        LevelModel::create([
            'level_kode' => $request->levelKode,
            'level_nama' => $request->levelNama,
        ]);

        return redirect('/level');
    }

    public function edit($id)
    {
        $level = LevelModel::find($id);
        return view('level.edit', compact('level'));
    }

    public function update(Request $request, $id)
    {
        $level = LevelModel::find($id);

        $level->level_kode = $request->levelKode;
        $level->level_nama = $request->levelNama;
        $level->save();

        return redirect('/level')->with('success', 'Level berhasil diupdate');
    }

    public function delete($id)
    {
        $level = LevelModel::find($id);
        if (!$level) {
            abort(404);
        }

        DB::table('m_user')->where('level_id', $id)->update(['level_id' => null]);
        $level->delete();

        return redirect('/level')->with('success', 'Level berhasil dihapus');
    }
}

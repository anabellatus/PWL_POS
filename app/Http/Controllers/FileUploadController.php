<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload()
    {
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request)
    {
        $request->validate([
            'berkas' => 'required|file|image|max:500',
            'nama_berkas' => 'required|string',
        ]);
        $extfile = $request->berkas->getClientOriginalExtension();
        // $namaFile = 'web-'.time().".".$extfile;
        $namaFile = $request->nama_berkas.'.'.$extfile;

        $path = $request->berkas->move('gambar', $namaFile);
        $path = str_replace("\\", "/", $path);
        echo "Variabel path berisi: $path <br>";

        // $pathBaru = asset('gambar/'.$namaFile);
        $pathBaru = asset('gambar/'.$request->nama_berkas);
        echo "Proses upload berhasil, file berada di " . $path;
        echo "<br>";
        // echo "Tampilkan link:<a href='$pathBaru'>$pathBaru</a>";
        echo "<img src='$pathBaru'>";
    }
}

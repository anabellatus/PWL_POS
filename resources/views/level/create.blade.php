@extends('layouts.app')

@section('subtitle', 'Create Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Create')

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Buat Level baru</h3>
            </div>

            <form method="post" action="../level">
                <div class="card-body">
                    <div class="form-group">
                        <label for="levelKode">Kode Level</label>
                        <input type="text" class="form-control" id="levelKode" name="levelKode" placeholder=" Kode Level">
                    </div>

                    <div class="form-group">
                        <label for="levelNama">Nama Level</label>
                        <input type="text" class="form-control" id="levelNama" name="levelNama"
                            placeholder=" Nama Level">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection


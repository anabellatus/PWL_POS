@extends('layouts.app')

@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Edit')

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Level</h3>
            </div>

            <form method="post" action="{{ route('level.update', $level->level_id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="levelKode">Kode Level</label>
                        <input type="text" class="form-control" id="levelKode" name="levelKode" value="{{ $level->level_kode }}">
                    </div>

                    <div class="form-group">
                        <label for="levelNama">Nama Level</label>
                        <input type="text" class="form-control" id="levelNama" name="levelNama"
                            value="{{ $level->level_nama }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection


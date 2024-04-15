@extends('layouts.app')

@section('subtitle', 'User')
@section('content_header_title', 'User')
@section('content_header_subtitle', 'Edit')

@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit User</h3>
            </div>

            <form method="post" action="{{ route('user.update', $user->user_id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="namaKategori">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->nama }}">
                    </div>

                    <div class="form-group">
                        <label for="namaKategori">Level Id</label>
                        <select class="form-control" id="levelId" name="levelId">
                            @foreach ($levels as $level)
                                <option value="{{ $level->level_id }}" @if($user->level_id == $level->level_id) selected @endif>{{ $level->level_nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kodeKategori">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" value="{{ $user->password }}">
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection


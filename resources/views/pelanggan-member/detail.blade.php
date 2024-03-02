@extends('layouts.main')

@section('content')
    <div class="flex flex-col">
        <div class="flex gap-2 items-center">
            <h6>Nama Panggilan:</h6><span>{{ $model->pelanggan->nama_panggilan }}</span>
        </div>
        <div class="flex gap-2 items-center">
            <h6>Nama Lengkap:</h6><span>{{ $model->pelanggan->nama_lengkap }}</span>
        </div>
        <div class="flex gap-2 items-center">
            <h6>No Telepon:</h6><span>{{ $model->pelanggan->no_telepon }}</span>
        </div>
        <div class="flex gap-2 items-center">
            <h6>No Telepon:</h6><span>{{ $model->poin }}</span>
        </div>
    </div>
@endsection

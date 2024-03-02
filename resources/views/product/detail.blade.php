@extends('layouts.main')

@section('content')
    <div class="flex flex-col pb-10">
        @include('product.form')
        <div class="flex justify-end mt-4 gap-2">
            <a href="{{ route('produk') }}" class="btn btn-primary bg-secondary px-4 border-none">Kembali</a>
        </div>
    </div>
@endsection

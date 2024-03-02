@extends('layouts.main')

@section('content')
    <x-Form method="POST" action="{{ route('produk.update', $model->id) }}" class="flex flex-col pb-11">
        <x-ValidationError></x-ValidationError>
        @include('product.form')
        <div class="flex justify-end mt-4 gap-2">
            <a href="{{ route('produk') }}" class="btn btn-primary bg-secondary px-4 border-none">Batal</a>
            <button type="submit" class="btn btn-primary bg-primary border-none">Update</button>
        </div>
    </x-Form>
@endsection

@push('page_script')
@include('product.form-script')
@endpush

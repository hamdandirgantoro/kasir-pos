@extends('layouts.main')
@push('page_library')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush
@push('page_style')

@endpush
@section('content')
<div class="p-3 mb-10">
<div class="border border-gray-200 rounded p-3 grid grid-cols-3 gap-5">
    <a href="{{ route('produk') }}" title="Produk" class="hover:scale-105 transition-all flex flex-col border-2 border-gray-300 rounded text-center drop-shadow">
        <div class="pb-4 text-xl bg-primary rounded-t">
            <div class="text-start pl-1"><i class="las la-box"></i></div>
            {{ count(App\Models\Produk::all()) }}
        </div>
        <div class="border-t border-gray-200 py-2 text-lg font-bold">
            Total Produk
        </div>
    </a>
    <a href="{{ route('kategori') }}" title="Kategori" class="hover:scale-105 transition-all flex flex-col border-2 border-gray-300 rounded text-center drop-shadow">
        <div class="pb-4 text-xl bg-primary rounded-t">
            <div class="text-start pl-1"><i class="las la-apple-alt"></i></div>
            {{ count(App\Models\Kategori::all()) }}
        </div>
        <div class="border-t border-gray-200 py-2 text-lg font-bold">
            Total Kategori
        </div>
    </a>
    <a href="{{ route('pelanggan') }}" title="Pelanggan" class="hover:scale-105 transition-all flex flex-col border-2 border-gray-300 rounded text-center">
        <div class="pb-4 text-xl bg-primary rounded-t">
            <div class="text-start pl-1"><i class="las la-users"></i></div>
            {{ count(App\Models\Pelanggan::all()) }}
        </div>
        <div class="border-t border-gray-200 py-2 text-lg font-bold">
            Total Pelanggan
        </div>
    </a>
</div>
</div>
@endsection
@push('page_script')
@endpush

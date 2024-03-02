@php
    $namaRoute = Request::route()->getName();
    $disabled = $namaRoute == 'produk.detail' ? 'disabled' : '';
    $routeDetail = $namaRoute == 'produk.detail';
@endphp
<div class="border border-gray-200 rounded-lg p-3">
<div class="grid grid-cols-2 gap-2">
    <label for="nama_produk">
      <div class="label">
        <span class="label-text">Nama Produk</span>
      </div>
      <input name="nama" class="input input-bordered w-full" id="nama_produk" type="text" value="{{ isset($model) ? $model->nama : '' }}" autocomplete="false" {{ $disabled }}>
    </label>
    <label for="id_kategori">
        <div class="label">
            <span class="label-text">Kategori</span>
        </div>
        <select name="id_kategori" class="select select-bordered w-full" id="id_kategori" type="select" {{ $disabled }}>
            @foreach (App\Models\Kategori::all()->pluck('nama', 'id') as $key => $value)
            <option value="{{$key}}" {{ isset($model) && $model->id_kategori == $key ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
    </label>
</div>
<div class="grid grid-cols-2 gap-2">
    <label for="harga">
        <div class="label">
            <span class="label-text">Harga</span>
        </div>
        <input name="harga" class="input input-bordered w-full" id="harga" type="number" value="{{ isset($model) ? $model->harga : '' }}" autocomplete="false" {{ $disabled }}>
    </label>
    <label for="stok">
        <div class="label">
            <span class="label-text">Stok</span>
        </div>
        <input name="stok" class="input input-bordered w-full" id="stok" type="number" value="{{ isset($model) ? $model->stok : '' }}" autocomplete="false" {{ $disabled }}>
    </label>
</div>
<label for="deskripsi" class="w-full ">
        <div class="label">
            <span class="label-text">Deskripsi</span>
        </div>
    <textarea name="deskripsi" class="textarea textarea-bordered w-full" id="deskripsi" autocomplete="false" {{ $disabled }}>{{ isset($model) ? $model->deskripsi : '' }}</textarea>
</label>
<div class="form-control mt-2">
    <label for="satuan_beli">
        <div class="label">
            <span class="label-text">Satuan Beli</span>
        </div>
    @if (!$routeDetail)
    <div class="flex justify-end pb-2">
        <button type="button" onclick="tambahRow()" class="btn btn-primary border-none bg-primary btn-sm"><i class="las la-plus"></i></button>
    </div>
    @endif
    <div class="border-gray-400 border rounded">
        <table class="w-full">
            <thead>
                <td class="border-r border-gray-200 p-2 text-center">Nama Satuan</td>
                <td class="border-r border-gray-200 p-2 text-center" width="20">Konversi</td>
                @if (!$routeDetail)
                <td class="p-2 text-center" width="60"><li class="las la-wrench"></li></td>
                @endif
            </thead>
            <tbody id="tbody">
                @isset($model)
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($model->satuan_beli as  $satuan_beli)
                    <tr id="row-{{$i}}">
                        <td class="p-2 border-r border-t border-gray-200"><input class="w-full bg-gray-200 outline-gray-300 focus:bg-white focus:outline-gray-100 transition-all p-2 rounded" name="satuan_beli[{{ $i }}][nama]" type="text" value="{{ $satuan_beli->nama }}" {{ $disabled }}></td>
                        <td class="p-2 border-r border-t border-gray-200"><input class="w-full bg-gray-200 outline-gray-300 focus:bg-white focus:outline-gray-100 transition-all p-2 rounded" name="satuan_beli[{{ $i }}][konversi]" type="text" value="{{ $satuan_beli->konversi }}" {{ $disabled }}></td>
                        @if (!$routeDetail)
                        <td class="p-2 border-r border-t border-gray-200 flex justify-center"><button type="button" class="btn btn-primary bg-danger btn-sm border-none" onclick="hapusRow('#row-{{ $i }}')"><i class="las la-trash"></i></button></td>
                        @endif
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                @endisset
            </tbody>
        </table>
    </div>
    </label>
</div>

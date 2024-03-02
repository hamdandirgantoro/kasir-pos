<x-Form method="POST" action="{{ route('produk.update', $model->id) }}" class="flex flex-col pb-11" id="formEdit">
    <input placeholder="Promo" name="diskon" type="number" value="{{ $model->diskon ? $model->diskon->diskon  : '' }}" class="input input-bordered">
    <input name="masa_berlaku" type="date" value="{{ $model->diskon ? $model->diskon->masa_berlaku  : '' }}" class="input input-bordered">
    <select name="type" class="select select-bordered" id="id_kategori" type="select">
        <option value="rupiah" {{ $model->diskon && ($model->diskon->type == 'rupiah') ? 'selected' : '' }}>Rupiah</option>
        <option value="persen" {{ $model->diskon && ($model->diskon->type == 'persen') ? 'selected' : '' }}>Persen</option>
    </select>
</x-Form>

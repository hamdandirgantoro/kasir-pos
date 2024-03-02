<x-Form method="POST" action="{{ route('kategori.update') }}" class="flex flex-col" id="formEdit">
    <input type="text" name="nama" placeholder="Nama" value="{{ $model->nama }}" class="input input-bordered">
</x-Form>

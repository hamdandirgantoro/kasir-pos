<div class="flex flex-col justify-start items-start">
    <div class="flex">
        <label for="nama" class="pr-1">nama:</label>
        <div id="nama">{{ $model->nama }}</div>
    </div>
    <div class="mt-2 w-full">
        <label for="list-produk" class="w-full text-start mb-1">list produk:</label>
        <div id="list-produk" class="flex flex-col border border-gray-200 rounded text-start p-2">
            @foreach ($model->produk as $key => $produk)
            <div class="flex">
                <span class="mr-1">{{ $key+1 }}.</span><div>{{ $produk->nama }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

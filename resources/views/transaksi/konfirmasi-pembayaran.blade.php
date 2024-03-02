<div class="flex justify-between flex-wrap">
    <div class="flex items-center">
        <span class="whitespace-nowrap">Total:</span>
        <span id="total-konfirmasi" class="ml-1 flex whitespace-nowrap">Rp <div class="ml-1" id="nominal-konfirmasi">{{$total}}</div></span>
        @if ($model)
            <span class="whitespace-nowrap ml-2">poin_pelanggan:</span>
            <span id="total-poin-pelanggan">{{ $model->poin }}</span>
            <input type="hidden" name="poin-pelanggan" id="poin-pelanggan" value="{{$model->poin}}" disabled>
        @endif
    </div>
    <div class="flex flex-col justify-start">
        <input type="number" placeholder="Nominal Pembayaran" class="input input-bordered">
        @if ($model)
        <div class="form-control w-fit gap-2 mt-2 flex flex-row">
            <input type="checkbox" class="checkbox checkbox-primary" onchange="sumHargaPoin()">
            <span class="whitespace-nowrap">Gunakan Poin</span>
        </div>
        @endif
    </div>
</div>

<div class="flex flex-col justify-start items-start">
    <div class="flex mt-2">
        <label for="diskon" class="pr-1">Diskon:</label>
        <div id="diskon">{{ $model->diskon }}</div>
    </div>
    <div class="flex mt-2">
        <label for="perolehan_poin" class="pr-1">Perolehan Poin:</label>
        <div id="perolehan_poin">{{ $model->perolehan_poin }}</div>
    </div>
    <div class="flex mt-2">
        <label for="status" class="pr-1">Status:</label>
        @if ($model->active)
        <label id="status" class="badge badge-success">Aktif</label>
        @else
        <label id="status" class="badge badge-neutral">Nonaktif</label>
        @endif
    </div>
</div>

<div class="gap-2 flex flex-col">
    <div class="flex gap-2 items-center">
        <h6>Nama Panggilan:</h6><span>{{ $model->nama_panggilan }}</span>
    </div>
    <div class="flex gap-2 items-center">
        <h6>Nama Lengkap:</h6><span>{{ $model->nama_lengkap }}</span>
    </div>
    <div class="flex gap-2 items-center">
        <h6>Alamat:</h6><span>{{ $model->alamat }}</span>
    </div>
    <div class="flex gap-2 items-center">
        <h6>Tempat Lahir:</h6><span>{{ $model->tempat_lahir }}</span>
    </div>
    <div class="flex gap-2 items-center">
        <h6>Tanggal Lahir:</h6><span>{{ $model->tanggal_lahir }}</span>
    </div>
    <div class="flex gap-2 items-center">
        <h6>No Telepon:</h6><span>{{ $model->no_telepon }}</span>
    </div>
    <div class="flex gap-2 items-center">
        <h6>Status:</h6>
        <span>
            @if ($model->active)
            <label class="badge badge-primary">Active</label>
            @else
            <label class="badge badge-neutral">Nonaktif</label>
            @endif
        </span>
    </div>
</div>

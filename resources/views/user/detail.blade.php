<div class="flex flex-col justify-start items-start">
    <div class="flex">
        <label for="nama" class="pr-1">nama:</label>
        <div id="nama">{{ $model->name }}</div>
    </div>
    <div class="flex mt-2">
        <label for="nama" class="pr-1">Email:</label>
        <div id="nama">{{ $model->email }}</div>
    </div>
    <div class="flex mt-2">
        <label for="nama" class="pr-1">Diregistrasi Pada:</label>
        <div id="nama">{{ $model->registrated_at }}</div>
    </div>
    <div class="flex mt-2">
        <label for="nama" class="pr-1">Role:</label>
        <label for="roles" class="badge badge-primary">{{$model->role->nama}}</label>
    </div>
</div>

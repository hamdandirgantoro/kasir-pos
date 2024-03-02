<div class="grid grid-cols-2 gap-4">
    <label for="nama_panggilan">
        <div class="label">
            <span class="label-text">Nama Panggilan</span>
        </div>
        <input name="nama_panggilan" class="input input-bordered w-full" id="nama_panggilan" type="text" autocomplete="false" value="{{ isset($model) ? $model->nama_panggilan : '' }}">
    </label>
    <label for="nama_lengkap">
        <div class="label">
            <span class="label-text">Nama Lengkap</span>
        </div>
        <input name="nama_lengkap" class="input input-bordered w-full" id="nama_lengkap" type="text" autocomplete="false" value="{{ isset($model) ? $model->nama_lengkap : '' }}">
    </label>
    <label for="alamat">
        <div class="label">
            <span class="label-text">Alamat</span>
        </div>
        <input name="alamat" class="input input-bordered w-full" id="alamat" type="text" autocomplete="false" value="{{ isset($model) ? $model->alamat : '' }}">
    </label>
    <label for="tanggal_lahir">
        <div class="label">
            <span class="label-text">Tanggal Lahir</span>
        </div>
        <input name="tanggal_lahir" class="input input-bordered w-full" id="tanggal_lahir" type="date" autocomplete="false" value="{{ isset($model) ? $model->tanggal_lahir : '' }}">
    </label>
    <label for="tempat_lahir">
        <div class="label">
            <span class="label-text">Tempat Lahir</span>
        </div>
        <input name="tempat_lahir" class="input input-bordered w-full" id="tempat_lahir" type="text" autocomplete="false" value="{{ isset($model) ? $model->tempat_lahir : '' }}">
    </label>
    <label for="no_telepon">
        <div class="label">
            <span class="label-text">No Telepon</span>
        </div>
        <input name="no_telepon" class="input input-bordered w-full" id="no_telepon" type="text" autocomplete="false" value="{{ isset($model) ? $model->no_telepon : '' }}">
    </label>
</div>
<div>
<div class="form-control w-fit mt-4">
  <label class="label cursor-pointer gap-2">
    <span class="label-text">Active</span>
    <input name="active" type="checkbox" class="checkbox checkbox-primary" value="1" {{ isset($model) ? $model->active ? 'checked' : '' : 'checked' }}/>
  </label>
</div>
</div>

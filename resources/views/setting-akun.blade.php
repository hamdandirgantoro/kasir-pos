@extends('layouts.main')

@section('content')
    <x-Form action="{{ route('akun.setting.save') }}" class="form-control flex flex-col items-center justify-center mb-14" id="formSetting">
        <div class="my-4">
            <i class="las la-user text-8xl rounded-full border-primary border drop-shadow"></i>
        </div>
        <div class="w-5/12 flex justify-around my-4 hidden">
            <button type="button" class="btn btn-outline btn-accent btn-sm" onclick="ganti_foto()">
                Ganti Foto
            </button>
            <button type="button" class="btn btn-outline btn-danger btn-sm" onclick="hapus_foto()">
                Hapus Foto
            </button>
        </div>
        <div class="w-5/12">
            <label class="w-full">
                <div class="label">
                    <span class="label-text">Nama</span>
                </div>
                <input name="name" type="text" class="input input-bordered w-full" value="{{ $model->name }}"/>
            </label>
            <label class="w-full">
                <div class="label">
                    <span class="label-text">Email</span>
                </div>
                <input name="Email" type="email" class="input input-bordered w-full" value="{{ $model->email }}"/>
            </label>
            <label class="w-full">
                <div class="label">
                    <span class="label-text">Password</span>
                </div>
                <input name="password" type="password" class="input input-bordered w-full"/>
            </label>
        </div>
        <button type="button" class="btn btn-outline btn-primary my-4" onclick="simpan()">Simpan</button>
    </x-Form>
@endsection

@push('page_script')
    <script>
        function simpan() {
            swal.fire({
                title: 'Apakah Anda Yakin?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                customClass: {
                  cancelButton: 'order-1',
                  confirmButton: 'order-2',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#formSetting').submit()
                }
            })
        }

        function ganti_foto() {
            swal.fire('yakin ?')
        }

        function hapus_foto() {
            swal.fire('yakin ?')
        }
    </script>
@endpush

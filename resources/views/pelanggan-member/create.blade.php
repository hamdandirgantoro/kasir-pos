@extends('layouts.main')

@section('content')
<x-Form method="POST" action="{{ route('pelanggan_membership.store') }}" class="flex flex-col w-full form-control" id="formCreate">
    @include('pelanggan-member.form')
    <div class="w-full flex justify-end my-4 gap-2">
        <a href="{{ route('pelanggan_membership') }}" class="btn btn-outline btn-neutral">Batal</a>
        <button type="button" title="Simpan" onclick="simpan()" class="btn btn-outline btn-primary">Simpan</button>
    </div>
</x-Form>
@endsection

@push('page_script')
    <script>
        function simpan() {
            swal.fire({
                title: "yakin ?",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                customClass: {
                  cancelButton: 'order-1',
                  confirmButton: 'order-2',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#formCreate').submit()
                }
            })
        }
    </script>
@endpush

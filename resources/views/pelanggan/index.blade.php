@extends('layouts.main')

@push('page_style')

@endpush

@section('content')
<div class="flex justify-end">
    <a title="Tambah" href="{{ route('pelanggan.create') }}" class="btn btn-primary btn-sm mb-4">Tambah</a>
</div>
<table id="table">
    <thead>
        <td>Nama Panggilan</td>
        <td>Nama Lengkap</td>
        <td>Alamat</td>
        <td>Tempat Lahir</td>
        <td>Tanggal Lahir</td>
        <td>No Telepon</td>
        <td>Status</td>
        <td width="150" class="text-center"><i id="tab" class="las la-wrench modal"></i></td>
    </thead>
    <tbody></tbody>
</table>
@endsection

@push('page_script')
    <script>
        let datatable;
        $(document).ready( function () {
            datatable = $('#table').DataTable({
                'processing': true,
                'serverSide': true,
                'ajax': {
                    'url': '',
                    'type': 'GET'
                },
                'columns':[
                    {'data': 'nama_panggilan'},
                    {'data': 'nama_lengkap'},
                    {'data': 'alamat'},
                    {'data': 'tempat_lahir'},
                    {'data': 'tanggal_lahir'},
                    {'data': 'no_telepon'},
                    {'data': 'active'},
                    {'data': '_', 'orderable': false, 'searchable': false},
                ]
            });

        } );

        function detail(id){
            $.ajax({
                url: `{{ route("pelanggan.detail") }}/${id}`,
                success: (response) => {
                    swal.fire({
                        title : 'Detail Pelanggan',
                        html : response
                    })
                }
            })
        }

        function create(id) {
            $.ajax({
                url: '{{ route("pelanggan.create") }}',
                success: (response) => {
                    swal.fire({
                        title : 'Tambah Pelanggan',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Simpan',
                        html : response
                    }).then((result) => {
                        if (result.isConfirmed) {
                            store();
                        }
                    })
                }
            })
        }

        function store() {
            $.ajax({
                url: '{{ route("pelanggan.store") }}',
                type: 'POST',
                dataType: 'JSON',
                data: $('#formCreate').serialize(),
                success: function(response) {
                    if (response.success) {
                        datatable.ajax.reload();
                    }
                    swal.closeModal();
                },
                error: function(error) {
                    // $('#formCreate').unblock();
                    // var response = JSON.parse(error.responseText);
                    // $('#formCreate').prepend(validation(response))
                }
            }).done(function() {
                // $('#formCreate').unblock();
            });
        }

        function update(id) {
            $.ajax({
                url: `{{ route("pelanggan.update") }}/${id}`,
                type: 'POST',
                dataType: 'JSON',
                data: $('#formEdit').serialize(),
                success: function(response) {
                    if (response.success) {
                        datatable.ajax.reload();
                    }
                    swal.closeModal();
                },
                error: function(error) {
                    // $('#formCreate').unblock();
                    // var response = JSON.parse(error.responseText);
                    // $('#formCreate').prepend(validation(response))
                }
            }).done(function() {
                // $('#formCreate').unblock();
            });
        }

        function active(id){
            swal.fire({
                title : 'Aktifkan Pelanggan ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("pelanggan.active") }}/${id}`,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        data: {active : 1 },
                        type: 'post',
                        success: (response) => {
                            if (response.success){
                                datatable.ajax.reload()
                            } else {
                                datatable.ajax.reload()
                            }
                        }
                    })
                }  else {
                    $(`#active-btn-${id}`).prop('checked', false);
                }
            })
        }

        function nonActive(id){
            swal.fire({
                title : 'Nonaktifkan Pelanggan ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("pelanggan.active") }}/${id}`,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        data: {active : 0 },
                        type: 'post',
                        success: (response) => {
                            if (response.success){
                                datatable.ajax.reload()
                            } else {
                                datatable.ajax.reload()
                            }
                        }
                    })
                } else {
                    $(`#active-btn-${id}`).prop('checked', true);
                }
            })
        }

        function deletePelanggan(id) {
            swal.fire({
                title : 'Hapus Pelanggan ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("pelanggan.delete") }}/${id}`,
                        success: (response) => {
                            if (response.success){
                                datatable.ajax.reload()
                            } else {
                                datatable.ajax.reload()
                            }
                        }
                    })
                }
            })
        }
    </script>
@endpush

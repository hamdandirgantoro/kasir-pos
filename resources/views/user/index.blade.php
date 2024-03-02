@extends('layouts.main')

@push('page_style')

@endpush

@section('content')
<div class="flex justify-end">
    <button onclick="create()" class="btn btn-primary btn-sm mb-4">Tambah</button>
</div>
<table id="table">
    <thead>
        <td>Nama</td>
        <td>Email</td>
        <td>Diregistrasi Pada</td>
        <td>Role</td>
        <td width="175" class="text-center"><i id="tab" class="las la-wrench modal"></i></td>
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
                    {'data': 'name'},
                    {'data': 'email'},
                    {'data': 'created_at'},
                    {'data': 'role'},
                    {'data': '_', 'orderable': false, 'searchable': false},
                ]
            });

        } );

        function detail(id){
            $.ajax({
                url: `{{ route("user.detail") }}/${id}`,
                success: (response) => {
                    swal.fire({
                        title : 'Detail User',
                        html : response
                    })
                }
            })
        }

        function create(id) {
            $.ajax({
                url: '{{ route("user.create") }}',
                success: (response) => {
                    swal.fire({
                        title : 'Tambah User',
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

        function edit(id) {
            $.ajax({
                url: `{{ route("user.edit") }}/${id}`,
                success: (response) => {
                    swal.fire({
                        title : 'Edit User',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Update',
                        html : response
                    }).then((result) => {
                        if (result.isConfirmed) {
                            update(id);
                        }
                    })
                }
            })
        }

        function store() {
            $.ajax({
                url: '{{ route("user.store") }}',
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
                url: `{{ route("user.update") }}/${id}`,
                type: 'POST',
                dataType: 'JSON',
                data: $('#formEdit').serialize(),
                success: function(response) {
                    console.log(response)
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

        function deleteUser(id) {
            swal.fire({
                title : 'Hapus User ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("user.delete") }}/${id}`,
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

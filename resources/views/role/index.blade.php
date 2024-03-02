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
                    {'data': 'nama'},
                    {'data': '_', 'orderable': false, 'searchable': false},
                ]
            });

        } );

        function detail(id){
            $.ajax({
                url: `{{ route("role.detail") }}/${id}`,
                success: (response) => {
                    swal.fire({
                        title : 'Detail Role',
                        html : response
                    })
                }
            })
        }

        function create(id) {
            $.ajax({
                url: '{{ route("role.create") }}',
                success: (response) => {
                    swal.fire({
                        title : 'Tambah Role',
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
                url: `{{ route("role.edit") }}/${id}`,
                success: (response) => {
                    swal.fire({
                        title : 'Edit Role',
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
                url: '{{ route("role.store") }}',
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
                url: `{{ route("role.update") }}/${id}`,
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

        function deleteRole(id) {
            swal.fire({
                title : 'Hapus Role ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("role.delete") }}/${id}`,
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

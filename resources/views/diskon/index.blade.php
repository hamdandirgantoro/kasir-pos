@extends('layouts.main')

@push('page_style')

@endpush

@section('content')
<div class="pt-14">
    <table id="table" >
        <thead>
            <td>Name Produk</td>
            <td>Promo</td>
            <td>Masa Berlaku</td>
            <td>Active</td>
            <td width="50"></td>
        </thead>
    <tbody></tbody>
</table>
</div>
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
                    {'data': 'diskon'},
                    {'data': 'masa_berlaku'},
                    {'data': 'active', 'orderable': false, 'searchable': false},
                    {'data': '_', 'orderable': false, 'searchable': false},
                ]
            });

        } );

        function active(id, nama_produk){
            swal.fire({
                title : `Akitfkan diskon ${nama_produk} ?`,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("diskon.active") }}/${id}`,
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

        function nonActive(id, nama_produk){
            swal.fire({
                title : `Nonakitfkan diskon ${nama_produk} ?`,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("diskon.active") }}/${id}`,
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

        function edit(id, nama_produk) {
            $.ajax({
                url: `{{ route("diskon.edit") }}/${id}`,
                success: (response) => {
                    swal.fire({
                        title : `Edit Diskon ${nama_produk}`,
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

        function update(id) {
            $.ajax({
                url: `{{ route("diskon.update") }}/${id}`,
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
    </script>
@endpush

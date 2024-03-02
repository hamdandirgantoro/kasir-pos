@extends('layouts.main')

@push('page_style')

@endpush

@section('content')
<div class="flex justify-end">
    <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm mb-4">Tambah</a>
</div>
<table id="table">
    <thead>
        <td>Name</td>
        <td>Harga</td>
        <td>Satuan</td>
        <td>Stok</td>
        <td>Active</td>
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
                    {'data': 'nama'},
                    {'data': 'harga'},
                    {'data': 'nama_satuan', 'orderable': false},
                    {'data': 'stok'},
                    {'data': 'active', 'orderable': false, 'searchable': false},
                    {'data': '_', 'orderable': false, 'searchable': false},
                ]
            });

        } );

        function detail(id){
            $.ajax({
                url: `{{ route("produk.detail") }}/${id}`,
                success: (response) => {
                    swal.fire({
                        title : 'detail Produk',
                        html : response
                    })
                }
            })
        }

        function active(id){
            swal.fire({
                title : 'Aktifkan Produk ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("produk.active") }}/${id}`,
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
                title : 'Nonaktifkan Produk ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("produk.active") }}/${id}`,
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

        function deleteProduk(id) {
            swal.fire({
                title : 'Hapus Produk ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("produk.delete") }}/${id}`,
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

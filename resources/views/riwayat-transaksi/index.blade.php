@extends('layouts.main')

@push('page_style')

@endpush

@section('content')
<div class="flex justify-between">
    <div>
        <input type="date" class="input input-bordered input-sm" id="filter-dari" name="filter-dari" value="{{ date('Y-m-01') }}">
        S.D.
        <input type="date" class="input input-bordered input-sm" id="filter-sampai" name="filter-sampai" value="{{ date('Y-m-d') }}">
        <button class="btn btn-sm btn-info ml-2" title="Filter" onclick="applyFilter()">Filter</button>
    </div>
    <a href="{{ route('transaksi') }}" class="btn btn-primary btn-sm mb-4" title="Buat Transaksi">Buat Transaksi</a>
</div>
<table id="table">
    <thead>
        <td>Code</td>
        <td>Nama Pelanggan</td>
        <td>Total</td>
        <td>Type</td>
        <td width="100" class="text-center"><i id="tab" class="las la-wrench"></i></td>
    </thead>
    <tbody></tbody>
</table>
<div class="mb-10"></div>
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
                    {'data': 'code'},
                    {'data': 'nama_pelanggan'},
                    {'data': 'total'},
                    {'data': 'type'},
                    {'data': '_', 'orderable': false, 'searchable': false},
                ]
            });

        });

        function nota(id) {
            $.ajax({
                url: `{{ route('riwayat_transaksi.nota') }}/${id}`, // Assuming the endpoint is '/nota/{id}'
                method: 'GET',
                success: function (response) {
                    // On success, print the HTML response
                    console.log(response); // or use $('body').append(responseHtml); to append to the body
                    var printWindow = window.open('', '_blank');
                    printWindow.document.write(response);
                    printWindow.document.body.style.zoom = '180%';
                    printWindow.document.close();
                    printWindow.print();
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.error('Request failed with status:', status);
                }
            });
        }
        function applyFilter() {
            var fromDate = $('#filter-dari').val();
            var toDate = $('#filter-sampai').val();
            $('#table').DataTable().ajax.url(`{{ route("riwayat_transaksi") }}?filter-dari=${fromDate}&filter-sampai=${toDate}`).load()
        }
    </script>
@endpush

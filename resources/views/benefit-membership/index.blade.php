@extends('layouts.main')

@section('content')
@if ($benefitAktif)
<div class="form-control mb-4 flex flex-col border drop-shadow" id="info-benefit-membership-aktif">
    <button onclick="nonActive('{{ $benefitAktif->id }}')" class="bg-red-600 bg-rounded w-fit h-fit rounded px-2 absolute right-5 top-3"><i class="las la-times text-2xl"></i></button>
    <p class="text-lg w-full text-center py-2 bg-accent rounded text-accent-content">Benefit Aktif</p>
    <div class="flex gap-2 mt-2">
        <span>Perolehan Poin:</span>{{ $benefitAktif->perolehan_poin }}
    </div>
    <div class="flex gap-2">
        <span>Diskon:</span>{{ $benefitAktif->diskon }}
    </div>
</div>
@else
<div id="info-benefit-membership-aktif"></div>
@endif
<div class="flex justify-end">
    <button onclick="create()" class="btn btn-primary btn-sm mb-4">Tambah</button>
</div>
<table id="table">
    <thead>
        <td>Diskon</td>
        <td>Perolehan Poin</td>
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
                    {'data': 'diskon'},
                    {'data': 'perolehan_poin'},
                    {'data': 'active'},
                    {'data': '_', 'orderable': false, 'searchable': false},
                ]
            });

        } );

        function detail(id){
            $.ajax({
                url: `{{ route("benefit_membership.detail") }}/${id}`,
                success: (response) => {
                    swal.fire({
                        title : 'Detail benefit_membership',
                        html : response
                    })
                }
            })
        }

        function active(id){
            swal.fire({
                title : 'Aktifkan Benefit Membership ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("benefit_membership.active") }}/${id}`,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        data: {active : 1 },
                        type: 'post',
                        success: (response) => {
                            if (response.success){
                                datatable.ajax.reload()
                                $('#info-benefit-membership-aktif').addClass('form-control mb-4 flex flex-col border drop-shadow');
                                $('#info-benefit-membership-aktif').append(`
                                    <button onclick="nonActive(${response.data.id})" class="bg-red-600 bg-rounded w-fit h-fit rounded px-2 absolute right-5 top-3"><i class="las la-times text-2xl"></i></button>
                                    <p class="text-lg w-full text-center py-2 bg-accent rounded text-accent-content">Benefit Aktif</p>
                                    <div class="flex gap-2 mt-2">
                                        <span>Perolehan Poin:</span>${response.data.perolehan_poin}
                                    </div>
                                    <div class="flex gap-2">
                                        <span>Diskon:</span>${response.data.diskon}
                                    </div>
                                `)
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
                title : 'Nonaktifkan Benefit Membership ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("benefit_membership.active") }}/${id}`,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                        data: {active : 0 },
                        type: 'post',
                        success: (response) => {
                            if (response.success){
                                $('#info-benefit-membership-aktif').removeClass('form-control mb-4 flex flex-col border drop-shadow');
                                $('#info-benefit-membership-aktif').empty();
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

        function edit(id) {
            $.ajax({
                url: `{{ route("benefit_membership.edit") }}/${id}`,
                success: (response) => {
                    swal.fire({
                        title : 'Edit benefit_membership',
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
                url: '{{ route("benefit_membership.store") }}',
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

        function create(id) {
            $.ajax({
                url: '{{ route("benefit_membership.create") }}',
                success: (response) => {
                    swal.fire({
                        title : 'Tambah Benefit Membership',
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

        function update(id) {
            $.ajax({
                url: `{{ route("benefit_membership.update") }}/${id}`,
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

        function deleteBenefitMembership(id) {
            swal.fire({
                title : 'Hapus Benefit Membership ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("benefit_membership.delete") }}/${id}`,
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

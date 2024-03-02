@extends('layouts.main')

@push('page_style')

@endpush

@section('content')
<div class="flex justify-end gap-2">
    <a title="Tambah Dari Pelanggan Lama" href="{{ route('pelanggan_membership.create') }}" class="btn btn-info btn-sm mb-4">Tambah Dari Pelanggan Baru</a>
    <button title="Tambah Dari Pelanggan Baru" onclick="create()" class="btn btn-primary btn-sm mb-4">Tambah Dari Pelanggan Lama</button>
</div>
<table id="table">
    <thead>
        <td>Nama Panggilan</td>
        <td>Nama Lengkap</td>
        <td>No Telepon</td>
        <td>Poin</td>
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
                    {'data': 'no_telepon'},
                    {'data': 'poin'},
                    {'data': '_', 'orderable': false, 'searchable': false},
                ]
            });

        } );

        function create(id) {
            $.ajax({
                url: '{{ route("pelanggan_membership.create") }}',
                success: (response) => {
                    swal.fire({
                        title : 'Tambah Pelanggan Membership',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Simpan',
                        customClass: 'w-6/12',
                        allowOutsideClick: false,
                        html : response
                    }).then((result) => {
                        if (result.isConfirmed) {
                            store();
                        }
                    })

                    const dropdownButton = document.getElementById('dropdown-button');
                    const dropdownMenu = document.getElementById('dropdown-menu');
                    const searchInput = document.getElementById('search-input');
                    let isOpen = true;

                    function toggleDropdown() {
                      isOpen = !isOpen;
                      dropdownMenu.classList.toggle('hidden', !isOpen);
                    }

                    toggleDropdown();

                    dropdownButton.addEventListener('click', () => {
                      toggleDropdown();
                    });

                    searchInput.addEventListener('input', () => {
                      const searchTerm = searchInput.value.toLowerCase();
                      const items = dropdownMenu.querySelectorAll('a');

                      items.forEach((item) => {
                        const text = item.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                          item.style.display = 'block';
                        } else {
                          item.style.display = 'none';
                        }
                      });
                    });

                    dropdownMenu.addEventListener('click', (event) => {
                        if (event.target && event.target.nodeName === 'BUTTON') {
                            setPelanggan(event.target);
                        }
                    });

                    function setPelanggan(button) {
                        let buttonText = $(button).text();
                        let idPelanggan = button.getAttribute('data-id');
                        $.ajax({
                            url: `{{ route("pelanggan.find_json") }}/${idPelanggan}`,
                            type: 'GET',
                            dataType: 'JSON',
                            data: $('#formCreate').serialize(),
                            success: function(response) {
                                if (response.success) {
                                    $('#input_id_pelanggan').val(response.data.id)
                                    $('#nama_panggilan').val(response.data.nama_panggilan)
                                    $('#nama_lengkap').val(response.data.nama_lengkap)
                                    $('#no_telepon').val(response.data.no_telepon)
                                }
                            },
                            error: function(error) {
                                // $('#formCreate').unblock();
                                // var response = JSON.parse(error.responseText);
                                // $('#formCreate').prepend(validation(response))
                            }
                        })
                        $('#select-text').text(buttonText);
                        toggleDropdown();
                    }
                }
            })
        }

        function store() {
            $.ajax({
                url: '{{ route("pelanggan_membership.store") }}',
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

        function deletePelangganMember(id) {
            swal.fire({
                title : 'Hapus Member ?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Iya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ route("pelanggan_membership.delete") }}/${id}`,
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

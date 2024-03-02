@extends('layouts.main')
@push('page_style')

@endpush

@section('content')
@if(session('success_message'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session("success_message") }}',
        });
    </script>
@endif
<div class="form-control p-4 mb-20 h-full">
    <x-Form action="{{ route('transaksi.store') }}" method="POST" id="form-transaksi">
        <input type="hidden" name="pelanggan_member" id="pelanggan-member">
        <input type="hidden" name="id_pelanggan" id="id-pelanggan">
        <input type="hidden" name="diskon_member" id="input-diskon-member">
        <input type="hidden" name="perolehan_poin" id="input-perolehan-poin">
        <input type="hidden" name="total_before" id="input-total-before" value="0">
        <div class="flex justify-end pb-2 mt-4">
            <button type="button" onclick="tambahRow()" class="btn btn-primary border-none bg-primary btn-sm"><i class="las la-plus"></i></button>
        </div>
        <div class="border-gray-400 border rounded">
            <table class="w-full">
                <thead>
                    <td class="border-r border-gray-200 p-2 text-center">Produk</td>
                    <td class="border-r border-gray-200 p-2 text-center" width="180">Satuan Beli</td>
                    <td class="border-r border-gray-200 p-2 text-center" width="70">Jumlah</td>
                    <td class="border-r border-gray-200 p-2 text-center" width="180">Diskon</td>
                    <td class="border-r border-gray-200 p-2 text-center" width="180">Harga</td>
                    <td class="border-r border-gray-200 p-2 text-center" width="180">Subtotal</td>
                    <td class="p-2 text-center" width="60"><li class="las la-wrench"></li></td>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
        <div class="flex p-3 mt-5 justify-between">
        <div class="flex items-center justify-center">
          <div class="relative group">
            <div id="info-pelanggan-member"></div>
            <button type="button" id="dropdown-button" class="inline-flex justify-between w-52 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500 overflow-hidden">
              <span class="mr-2 text-start" id="select-text">Pilih Pelanggan</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
            <div id="dropdown-menu" class="hidden absolute right-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 space-y-1">
              <!-- Search input -->
              <input id="search-input" class="block w-full px-4 py-2 text-gray-800 border rounded-md  border-gray-300 focus:outline-none" type="text" placeholder="Search items" autocomplete="off">
              <!-- Dropdown content goes here -->
              @foreach (App\Models\Pelanggan::all()->pluck('nama_lengkap', 'id') as $key => $nama_pelanggan )
                <button data-id="{{ $key }}" type="button" onclick="setPelanggan(this)" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md w-full text-start">{{ $nama_pelanggan }}</button>
              @endforeach
            </div>
          </div>
        </div>
            <div class="h-20 w-52 flex flex-col justify-between">
                <div class="text-lg flex flex-col mb-4">
                    <div id="benefit-member" class="flex flex-col"></div>
                    <div class="flex justify-between">
                        <div>Total</div>
                        <input type="hidden" name="total" id="grand-total" value="0">
                        <div class="font-bold flex">Rp <div id="sum-harga" class="pl-1">0</div></div>
                    </div>
                    <div class="border border-gray-400"></div>
                </div>
                <button class="btn btn-outline btn-primary btn" type="button" onclick="konfirmasiPembayaran()">Konfirmasi Pembayaran</button>
            </div>
        </div>
    </x-Form>
</div>

@endsection

@push('page_script')
    <script>
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
          const items = dropdownMenu.querySelectorAll('button');
          items.forEach((item) => {
            const text = item.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
              item.style.display = 'block';
            } else {
              item.style.display = 'none';
            }
          });
        });
        let rowDataTotal = $('#tbody').children('tr').length;
        function tambahRow(element) {
            $('#tbody').append(`<tr id="row-${rowDataTotal}">
                                    <td class="p-2 border-r border-t border-gray-200">
                                        <input name="produk_beli[${rowDataTotal}][id_produk]" type="hidden" id="input-produk-${rowDataTotal}-id_produk">
                                        <button type="button" class="w-full border border-gray-200 outline-gray-300 focus:bg-white focus:outline-gray-100 transition-all p-2 rounded h-10" onclick="browse('input-produk-${rowDataTotal}')" id="input-produk-${rowDataTotal}"></button>
                                    </td>
                                    <td class="p-2 border-r border-t border-gray-200">
                                        <input type="hidden" name="produk_beli[${rowDataTotal}][satuan_beli]" id="input-produk-${rowDataTotal}-satuan-beli-hidden">
                                        <select onchange="sumHargaKonversi('#input-produk-${rowDataTotal}')" name="produk_beli[${rowDataTotal}][konversi_satuan_beli]" class="w-full border outline-gray-200 transition-all p-2 rounded h-10 bg-white" id="input-produk-${rowDataTotal}-satuan-beli" type="select">
                                        </select>
                                    </td>
                                    <td class="p-2 border-r border-t border-gray-200">
                                        <input readonly id='input-produk-${rowDataTotal}-jumlah' oninput="sumHargaKonversi('#input-produk-${rowDataTotal}')" name="produk_beli[${rowDataTotal}][jumlah]" class="input input-bordered input-sm w-20" type="number" >
                                    </td>
                                    <td class="p-2 border-r border-t border-gray-200">
                                        <input name="produk_beli[${rowDataTotal}][tipe_diskon]" type="hidden" id="input-produk-${rowDataTotal}-tipe-diskon">
                                        <input name="produk_beli[${rowDataTotal}][diskon]" type="hidden" id="input-produk-${rowDataTotal}-diskon-hidden">
                                        <input class="w-full border border-gray-200 outline-gray-300 focus:bg-white focus:outline-gray-100 transition-all p-2 rounded" type="text" value="" id="input-produk-${rowDataTotal}-diskon" disabled>
                                    </td>
                                    <td class="p-2 border-r border-t border-gray-200">
                                        <input type="hidden" value="" id="input-produk-${rowDataTotal}-harga-dasar" disabled>
                                        <input name="produk_beli[${rowDataTotal}][harga]" type="hidden" value="" id="input-produk-${rowDataTotal}-harga-hidden">
                                        <input class="w-full border border-gray-200 outline-gray-300 focus:bg-white focus:outline-gray-100 transition-all p-2 rounded" type="text" value="" id="input-produk-${rowDataTotal}-harga" disabled>
                                    </td>
                                    <td class="p-2 border-r border-t border-gray-200">
                                        <input name="produk_beli[${rowDataTotal}][subtotal]" type="hidden" value="" id="input-produk-${rowDataTotal}-subtotal-hidden" data-row="subtotal">
                                        <input class="w-full border border-gray-200 outline-gray-300 focus:bg-white focus:outline-gray-100 transition-all p-2 rounded" type="text" value="" id="input-produk-${rowDataTotal}-subtotal" disabled>
                                    </td>
                                    <td class="p-2 border-r border-t border-gray-200 flex justify-center">
                                        <button type="button" class="btn btn-primary bg-danger btn-sm border-none" onclick="hapusRow('#row-${rowDataTotal}','#input-produk-${rowDataTotal}-subtotal-hidden')">
                                            <i class="las la-trash"></i>
                                        </button>
                                    </td>
                                </tr>`);
            rowDataTotal++;
        }

        function hapusRow(element, elemenHargaProduk) {
            sumHarga -= $(elemenHargaProduk).val();
            let total_before = parseFloat($('#input-total-before').val())
            console.log(total_before)
            total_before -= parseFloat($(elemenHargaProduk).val())
            if (total_before < 0) {
                total_before = 0
            }
            console.log(total_before)
            $('#input-total-before').val(total_before)
            if (sumHarga < 0) {
                sumHarga = 0;
            }

            $(element).remove();
            $('#sum-harga').text(sumHarga);
            rowDataTotal--;
        }

        function konfirmasiPembayaran() {
            let grandTotal = $('#grand-total').val();
            $.ajax({
                url: `{{ route("transaksi.konfirmasi_pembayaran") }}?total=${grandTotal}&id_pelanggan=${idPelanggan}`,
                success:(response) => {
                    swal.fire({
                        title: 'Konfirmasi Pembayaran',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Bayar',
                        customClass: {
                          cancelButton: 'order-1',
                          confirmButton: 'order-2',
                        },
                        animation: false,
                        html: response.html
                    }).then(function (result){
                        useHargaPoin = 0;
                        if (result.isConfirmed) {
                            $('#grand-total').val(response.total_konfirmasi);
                            $('#form-transaksi').submit()
                        }
                    })
                }
            })
        }

        let sumHarga = 0;
        function browse(id_input) {
            $.ajax({
                url: `{{ route("transaksi.browse") }}/${id_input}?type=html`,
                success: (response) => {
                    swal.fire({
                        title : 'Browse Produk',
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: 'Tutup',
                        customClass: 'w-10/12',
                        animation: false,
                        html : response
                    })
                    let tableProduk = $('#produk-table').DataTable({
                        'processing': true,
                        'serverSide': true,
                        'ajax': {
                            'url': `{{route('transaksi.browse')}}/${id_input}?type=json`,
                            'type': 'GET'
                        },
                        'columns':[
                            {'data': 'nama'},
                            {'data': 'harga'},
                            {'data': 'diskon'},
                            {'data': 'tipe_diskon'},
                            {'data': 'diskon_num'},
                            {'data': 'harga_num'},
                            {'data': 'tipe_diskon'},
                            {'data': 'select_satuan_beli'},
                            {'data': 'id'},
                            {'data': 'stok'},
                        ],
                        columnDefs: [
                            {
                                target: 2,
                                visible: false,
                                searchable: false
                            },
                            {
                                target: 3,
                                visible: false,
                                searchable: false,
                            },
                            {
                                target: 4,
                                visible: false,
                                searchable: false
                            },
                            {
                                target: 5,
                                visible: false,
                                searchable: false
                            },
                            {
                                target: 6,
                                visible: false,
                                searchable: false
                            },
                            {
                                target: 7,
                                visible: false,
                                searchable: false
                            },
                            {
                                target: 8,
                                visible: false,
                                searchable: false
                            },
                        ]
                    });
                    $('#produk-table tbody').on('click', 'tr', function () {
                        let data = tableProduk.row(this).data();
                        let namaProduk = data['nama'];
                        let idProduk = data['id'];
                        let selectSatuanBeli = data['select_satuan_beli'];
                        let hargaProdukNum = data['harga_num'];
                        let hargaProduk = data['harga'];
                        let tipeDiskon = data['tipe_diskon'];
                        let diskonProduk = data['diskon'] !== '' ? data['diskon'] : 0 ;
                        let diskonProdukHidden = data['diskon_num'] !== '' ? data['diskon_num'] : 0;
                        let subtotalHidden = 0;
                        let subtotal = 0;
                        if (tipeDiskon == 'persen') {
                            subtotalHidden = data['harga_num'] - (data['diskon_num'] / 100) * data['harga_num'];
                            subtotal = `Rp ${data['harga_num'] - (data['diskon_num'] / 100) * data['harga_num']}`;
                        } else {
                            subtotalHidden = data['harga_num'] - data['diskon_num'];
                            subtotal = `Rp ${data['harga_num'] - data['diskon_num']}`;
                        }
                        $(`#${id_input}`).text(namaProduk);
                        $(`#${id_input}-jumlah`).val(1);
                        $(`#${id_input}-id_produk`).val(idProduk);
                        $(`#${id_input}-satuan-beli`).empty().append(selectSatuanBeli);
                        $(`#${id_input}-satuan-beli-hidden`).val('');
                        let total_before = parseFloat($('#input-total-before').val())
                        $('#input-total-before').val(total_before+subtotalHidden)
                        $(`#${id_input}-harga-hidden`).val(hargaProdukNum);
                        $(`#${id_input}-harga-dasar`).val(hargaProdukNum);
                        $(`#${id_input}-harga`).val(hargaProduk);
                        $(`#${id_input}-diskon-hidden`).val(diskonProdukHidden);
                        $(`#${id_input}-diskon`).val(diskonProduk);
                        $(`#${id_input}-tipe-diskon`).val(tipeDiskon);
                        $(`#${id_input}-subtotal-hidden`).val(subtotalHidden);
                        $(`#${id_input}-subtotal`).val(subtotal);
                        sumHarga += subtotalHidden;
                        $('#grand-total').val(sumHarga);
                        let jumlahPerolehanPoin = Math.round((perolehanPoin / 100) * $('#grand-total').val());
                        $('#input-perolehan-poin').val(jumlahPerolehanPoin);
                        $('#perolehan-poin').text(jumlahPerolehanPoin);
                        $('#sum-harga').text(sumHarga);
                        swal.closeModal();
                    });
                }
            })
        }

        function sumHargaKonversi(id_input) {
            $(`${id_input}-jumlah`).removeAttr('readonly');
            let jumlah = parseFloat($(`${id_input}-jumlah`).val());
            if (jumlah < 0) {
                jumlah = 0;
                $(`${id_input}-jumlah`).val(jumlah);
            }
            let hargaProduk = parseFloat($(`${id_input}-harga-dasar`).val());
            let total_before = parseFloat($('#input-total-before').val())
            $('#input-total-before').val(total_before - parseFloat($(`${id_input}-subtotal-hidden`).val())) //
            let selectedValue = parseFloat($(`${id_input}-satuan-beli`).val()); //
            let selectedText = $(`${id_input}-satuan-beli option:selected`).text();
            $(`${id_input}-satuan-beli-hidden`).val(selectedText);
            let tipeDiskon = $(`${id_input}-tipe-diskon`).val();
            let diskon = parseFloat($(`${id_input}-diskon-hidden`).val());

            let sumHargaProduk = hargaProduk * selectedValue;
            sumHargaProduk = sumHargaProduk * jumlah;
            if (tipeDiskon === 'persen') {
                diskon = (diskon / 100) * sumHargaProduk;
            }
            let subtotal = sumHargaProduk - diskon;

            if (subtotal < 0) {
                subtotal = 0;
            }
            if (sumHargaProduk < 0) {
                sumHargaProduk = 0;
            }

            $(`${id_input}-harga`).val(`Rp ${sumHargaProduk}`);
            let total_before_update = parseFloat($('#input-total-before').val()) //
            $('#input-total-before').val(total_before_update + subtotal) //
            $(`${id_input}-subtotal-hidden`).val(subtotal);
            $(`${id_input}-subtotal`).val(`Rp ${subtotal}`);

            let totalSum = 0;
            $('[data-row="subtotal"]').each(function () {
                if ($(this).val()) {
                    totalSum += parseFloat($(this).val());
                }
            });
            totalSum = totalSum - ((persenDiskonBenefit / 100) * totalSum);
            if (totalSum < 0) {
                totalSum = 0;
            }

            $('#grand-total').val(totalSum);
            let jumlahPerolehanPoin = Math.round((perolehanPoin / 100) * totalSum);
            $('#perolehan-poin').text(jumlahPerolehanPoin);
            $('#sum-harga').text(totalSum);
        }

        let persenDiskonBenefit = 0;
        let diskonBenefit = 0;
        let perolehanPoin = 0;
        let isPelangganMember = 0;
        let idPelanggan = null;
        function setPelanggan(button) {
            idPelanggan = $(button).attr('data-id');
            $('#id-pelanggan').val(idPelanggan);
            $.ajax({
                url: `{{ route('benefit_membership.get_benefit_json') }}/${idPelanggan}`,
                success: (response) => {
                    if (response.success) {
                        $('#info-pelanggan-member').empty().append(`
                            <label class="badge badge-success flex mb-2">
                                <i class="las la-star"></i><span>Pelanggan Ini Terdaftar Membership</span>
                            </label>
                        `);
                        $('#benefit-member').empty().append(`
                            <div class="flex justify-between">
                                <div>Diskon</div>
                                <div class="font-bold flex" id="diskon-benefit">${response.data.diskon}%</div>
                            </div>
                            <div class="border border-gray-400"></div>
                            <div class="flex justify-between">
                                <div>Perolehan Poin</div>
                                <div class="font-bold flex" id="perolehan-poin">${Math.round((response.data.perolehan_poin / 100) * $('#grand-total').val())}</div>
                            </div>
                            <div class="border border-gray-400"></div>
                        `)
                        $('#input-perolehan-poin').val(Math.round((response.data.perolehan_poin / 100) * $('#grand-total').val()))
                        $('#input-diskon-member').val(response.data.diskon);
                        perolehanPoin = response.data.perolehan_poin
                        let potonganHargaBenefit = (response.data.diskon / 100) * $('#grand-total').val()
                        persenDiskonBenefit = response.data.diskon;
                        diskonBenefit = potonganHargaBenefit;
                        let harga = $('#grand-total').val() - potonganHargaBenefit;
                        $('#grand-total').val(harga)
                        $('#sum-harga').text(harga)
                        isPelangganMember = 1;
                        $('#pelanggan-member').val(isPelangganMember);
                    } else {
                        isPelangganMember = 0;
                        $('#pelanggan-member').val(isPelangganMember);
                        let harga = $('#grand-total').val()
                        $('#grand-total').val(parseInt(harga)+parseInt(diskonBenefit))
                        $('#sum-harga').text('').text(parseInt(harga)+parseInt(diskonBenefit))
                        $('#info-pelanggan-member').empty();
                        $('#benefit-member').empty();
                    }
                }
            })
            let buttonText = $(button).text();
            $('#select-text').text(buttonText);
            toggleDropdown();
        }

        let useHargaPoin = 0;
        let poinPelanggan = 0;

        function sumHargaPoin() {
            poinPelanggan = parseInt($('#poin-pelanggan').val());
            let nominalKonfirmasi = parseInt($('#nominal-konfirmasi').text());

            if (!useHargaPoin) {
                $('#total-poin-pelanggan').text(0)
                $('#nominal-konfirmasi').text(nominalKonfirmasi - poinPelanggan);
            } else {
                $('#total-poin-pelanggan').text(poinPelanggan)
                $('#nominal-konfirmasi').text(nominalKonfirmasi + poinPelanggan);
            }
            useHargaPoin = useHargaPoin ? 0 : 1;
        }
    </script>
@endpush

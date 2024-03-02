<script>
    let rowDataTotal = $('#tbody').children('tr').length;
    function tambahRow(element) {
        $('#tbody').append(`<tr id="row-${rowDataTotal}">
                                <td class="p-2 border-r border-t border-gray-200"><input class="w-full bg-gray-200 outline-gray-300 focus:bg-white focus:outline-gray-100 transition-all p-2 rounded" name="satuan_beli[${rowDataTotal}][nama]" type="text" value=""></td>
                                <td class="p-2 border-r border-t border-gray-200"><input class="w-full bg-gray-200 outline-gray-300 focus:bg-white focus:outline-gray-100 transition-all p-2 rounded" name="satuan_beli[${rowDataTotal}][konversi]" type="number" value=""></td>
                                <td class="p-2 border-r border-t border-gray-200 flex justify-center"><button type="button" class="btn btn-primary bg-danger btn-sm border-none" onclick="hapusRow('#row-${rowDataTotal}')"><i class="las la-trash"></i></button></td>
                            </tr>`);
        rowDataTotal++;
    }

    function hapusRow(element) {
        $(element).remove();
        rowDataTotal--;
    }
</script>

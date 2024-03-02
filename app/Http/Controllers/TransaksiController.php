<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\PelangganMember;
use App\Models\Produk;
use App\Models\RiwayatProdukTransaksi;
use App\Models\RiwayatTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('transaksi.index');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $produkBeli = $data['produk_beli'];
        $code = $this->generateKodeTransaksi();
        $transaksi = Transaksi::create([
            'code' => $code,
            'id_pelanggan' => $data['id_pelanggan'],
            'total' => $data['total'],
            'total_before' => $data['total_before'],
            'terbayar' => '1'
        ]);
        $riwayatTransaksi = RiwayatTransaksi::create([
            'code' => $code,
            'id_pelanggan' => $data['id_pelanggan'],
            'id_transaksi' => $transaksi->id,
            'nama_pelanggan' => Pelanggan::find($data['id_pelanggan'])->nama_lengkap,
            'pelanggan_member' => $data['pelanggan_member'],
            'total' => $data['total'],
            'total_before' => $data['total_before'],
            'type' => 'pemasukan'
        ]);

        foreach ($produkBeli as $produk) {
            RiwayatProdukTransaksi::create([
                'id_produk' => $produk['id_produk'],
                'nama_produk' => Produk::find($produk['id_produk'])->nama,
                'satuan_beli' => $produk['satuan_beli'],
                'jumlah' => $produk['jumlah'],
                'diskon' => $produk['tipe_diskon'] == 'persen' ? $produk['diskon'].'%' : 'Rp '.$produk['diskon'],
                'harga' => 'Rp '.$produk['harga'],
                'subtotal' => 'Rp '.$produk['subtotal'],
                'id_riwayat_transaksi' => $riwayatTransaksi->id
            ]);
            Produk::find($produk['id_produk'])->decrement('stok', $produk['jumlah']);
        }

        if ($data['pelanggan_member']) {
            PelangganMember::where('id_pelanggan', $data['id_pelanggan'])->increment('poin', $data['perolehan_poin']);
        }
        return redirect()->route('transaksi')->with('success_message', 'berhasil melakukan transaksi');
    }

    public function konfirmasiPembayaran()
    {
        $total = request()->input('total');
        $id_pelanggan = request()->input('id_pelanggan');
        $model = PelangganMember::where('id_pelanggan', $id_pelanggan)->first();
        return response()->json(['html' => view('transaksi.konfirmasi-pembayaran', compact('total', 'model'))->render(),
                                'success' => 1,
                                'total_konfirmasi' => $model ? ($total - $model->poin) : $total
                                ]);
    }

    public function browse($id_input)
    {
        if (request()->input('type') == 'json') {
            return DataTables::of(Produk::with(['diskon', 'satuan_beli'])->get())
            ->editColumn('harga', function ($data) {
                return 'Rp '.$data->harga;
            })
            ->addColumn('select_satuan_beli', function ($data) {
                $html = '<option value="1" >Pilih</option>';
                foreach ($data->satuan_beli as $satuan_beli) {
                    $html .= '<option value="'.$satuan_beli->konversi.'"  onclick="sumHarga('.$satuan_beli->konversi.')">'.$satuan_beli->nama.'</option>';
                }
                return $html;
            })
            ->addColumn('harga_num', function ($data) {
                return $data->harga;
            })
            ->editColumn('diskon', function ($data) {
                if ($data->diskon) {
                    $html = $data->diskon->type == 'rupiah' ? ('Rp '.$data->diskon->diskon) : ($data->diskon->diskon.'%') ;
                } else {
                    $html = '';
                }
                return $html;
            })
            ->editColumn('tipe_diskon', function ($data) {
                if ($data->diskon) {
                    $html = $data->diskon->type;
                } else {
                    $html = '';
                }
                return $html;
            })
            ->editColumn('diskon_num', function ($data) {
                if ($data->diskon) {
                    $html = $data->diskon->diskon;
                } else {
                    $html = '';
                }
                return $html;
            })
            ->rawColumns(['select_satuan_beli'])
            ->make(true);
        }
        return view('transaksi.browse-produk', compact('id_input'));
    }

    private function generateKodeTransaksi()
    {
        $randomNumber = mt_rand(100000, 999999);
        $timestamp = time();
        $transactionCode = 'KSR-' . $timestamp . $randomNumber;
        $transactionCode = substr($transactionCode, 0, 16);
        return $transactionCode;
    }
}

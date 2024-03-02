<?php

namespace App\Http\Controllers;

use App\Models\RiwayatTransaksi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RiwayatTransaksiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            if (request()->has('filter-dari')) {
                $filterDari = request()->input('filter-dari');
                $filterSampai = request()->input('filter-sampai');
                return DataTables::of(RiwayatTransaksi::whereBetween('created_at', [$filterDari, $filterSampai])->get())
                ->addColumn('_', function($data) {
                    $html = '<a title="Detail" class="btn btn-info mr-1 btn-sm" href="'.route('riwayat_transaksi.detail', $data->id).'"><i class="las la-list"></i></a>';
                    $html .= '<button title="Nota" class="btn btn-primary mr-1 btn-sm" onclick="nota('.$data->id.')"><i class="las la-file-invoice"></i></button>';
                    // $html .= '<button title="Hapus" class="btn bg-danger btn-sm" onclick="deleteProduk('.$data->id.')"><i class="las la-trash"></i></button>';
                    return $html;
                    return '';
                })
                ->editColumn('total', function($data) {
                    return 'Rp '.$data->total;
                })
                ->rawColumns(['_'])
                ->make(true);
            }
            return DataTables::of(RiwayatTransaksi::all())
            ->addColumn('_', function($data) {
                $html = '<a title="Detail" class="btn btn-info mr-1 btn-sm" href="'.route('riwayat_transaksi.detail', $data->id).'"><i class="las la-list"></i></a>';
                $html .= '<button title="Nota" class="btn btn-primary mr-1 btn-sm" onclick="nota('.$data->id.')"><i class="las la-file-invoice"></i></button>';
                // $html .= '<button title="Hapus" class="btn bg-danger btn-sm" onclick="deleteProduk('.$data->id.')"><i class="las la-trash"></i></button>';
                return $html;
            })
            ->editColumn('total', function($data) {
                return 'Rp '.$data->total;
            })
            ->rawColumns(['_'])
            ->make(true);
        }
        return view('riwayat-transaksi.index');
    }

    public function detail($id)
    {

    }

    public function nota($id)
    {
        $model = RiwayatTransaksi::find($id);
        return view('riwayat-transaksi.nota', compact('model'));
    }
}

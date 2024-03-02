<?php

namespace App\Http\Controllers;

use App\Helpers\Pesan;
use App\Models\Diskon;
use App\Models\Produk;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DiskonController extends Controller
{
    private $pesan;

    public function __construct()
    {
        $this->pesan = new Pesan('produk');
    }

    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(Produk::with(['diskon'])->get())
                ->addColumn('diskon', function ($data) {
                    if ($data->diskon) {
                        $html = $data->diskon->type == 'rupiah' ? ('Rp '.$data->diskon->diskon) : ($data->diskon->diskon.'%') ;
                    } else {
                        $html = 'N/A';
                    }
                    return $html;
                })
                ->addColumn('masa_berlaku', function ($data) {
                    if ($data->diskon) {
                        $html = 'S.d. '.$data->diskon->masa_berlaku;
                    } else {
                        $html = 'N/A';
                    }
                    return $html;
                })
                ->addColumn('active', function ($data) {
                    if ($data->diskon) {
                        $checked = $data->diskon->active ? 'checked' : '';
                        $jsFunction = $data->diskon->active ? 'nonActive('.$data->id.',\''.$data->nama.'\')' : 'active('.$data->id.',\''.$data->nama.'\')';
                        $html = '<button onclick="'.$jsFunction.'"><input id="active-btn-'.$data->id.'" type="checkbox" class="toggle toggle-info" '.$checked.' /></button>';
                    } else {
                        $html = 'N/A';
                    }
                    return $html;
                })
                ->addColumn('_', function ($data) {
                    return '<button title="Edit" class="btn btn-warning mr-1 btn-sm" onclick="edit('.$data->id.',\''.$data->nama.'\')"><i class="lar la-edit"></i></button>';
                })
                ->rawColumns(['active', '_'])
                ->make(true);
        }
        return view('diskon.index');
    }

    public function edit($id)
    {
        $model = Produk::with(['diskon'])->find($id);
        return view('diskon.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $produk = Produk::with(['diskon'])->find($id);
        if ($produk->diskon) {
            Diskon::where('id_produk', $produk->id)->update($data);
        } else {
            $data['active'] = '1';
            $data['id_produk'] = $produk->id;
            Diskon::create($data);
        }
        return response()->json([
            'success' => 1
        ]);
    }

    public function active($id)
    {
        $id_produk = Produk::select('id')->where('id', $id)->first()->id;
        $Diskon = Diskon::where('id_produk', $id_produk)->update(request()->all());
        return response()->json([
            'success' => $Diskon
            ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\Pesan;
use App\Models\Produk;
use App\Models\SatuanBeli;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    private $pesan;

    public function __construct()
    {
        $this->pesan = new Pesan('produk');
    }

    public function index() {
        if (request()->ajax()) {
            return DataTables::of(Produk::with(['kategori', 'satuan_beli'])->get())
                ->addColumn('harga', function($data) {
                    return 'Rp'.$data->harga;
                })
                ->addColumn('nama_satuan', function($data) {
                    $html = [];
                    foreach ($data->satuan_beli as $satuan_beli) {
                        $color = $satuan_beli->default ? 'primary' : 'secondary';
                        $html[] = '<label class="bg-'.$color.' rounded p-0.5 text-white text-sm">'.$satuan_beli->nama.'</label>';
                    }
                    return implode('', $html);
                })
                ->addColumn('active', function($data) {
                    $html = '';
                    $checked = $data->active ? 'checked' : '';
                    $jsFunction = $data->active ? 'nonActive('.$data->id.')' : 'active('.$data->id.')';
                    $html = '<button onclick="'.$jsFunction.'"><input id="active-btn-'.$data->id.'" type="checkbox" class="toggle toggle-info" '.$checked.' /></button>';
                    return $html;
                })
                ->addColumn('_', function($data) {
                    $html = '<a title="Detail" class="btn btn-info mr-1 btn-sm" href="'.route('produk.detail', $data->id).'"><i class="las la-list"></i></a>';
                    $html .= '<a title="Edit" class="btn btn-warning mr-1 btn-sm" href="'.route('produk.edit', $data->id).'"><i class="lar la-edit"></i></a>';
                    $html .= '<button title="Hapus" class="btn bg-danger btn-sm" onclick="deleteProduk('.$data->id.')"><i class="las la-trash"></i></button>';
                    return $html;
                })
                ->rawColumns(['nama_satuan', 'active', '_'])
                ->make(true);
        }
        return view('product.index');
    }

    public function detail($id)
    {
        $model = Produk::find($id);
        $model->satuan_beli = SatuanBeli::all()->where('id_produk', $model->id);
        return view('product.detail', compact('model'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function edit($id)
    {
        $model = Produk::find($id);
        $model->satuan_beli = SatuanBeli::all()->where('id_produk', $model->id);
        return view('product.edit', compact('model'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = '1';
        $produk = Produk::create($data);
        foreach($data['satuan_beli'] as $key => $satuan_beli) {
            if ($key == 0 || $key == 1) {
                $satuan_beli['default'] = 1;
            } else {
                $satuan_beli['default'] = 0;
            }
            $satuan_beli['aktif'] = 1;
            $satuan_beli['id_produk'] = $produk->id;
            SatuanBeli::create($satuan_beli);
        }
        return redirect()->route('produk');
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $data['active'] = '1';
        Produk::find($id)->update($data);
        SatuanBeli::where('id_produk', $id)->delete();
        foreach($data['satuan_beli'] as $key => $satuan_beli) {
            if ($key == 0) {
                $satuan_beli['default'] = 1;
            } else {
                $satuan_beli['default'] = 0;
            }
            $satuan_beli['aktif'] = 1;
            $satuan_beli['id_produk'] = $id;
            SatuanBeli::create($satuan_beli);
        }
        return redirect()->route('produk');
    }

    public function active($id)
    {
        if(Produk::find($id)->update(request()->all())) {
            return response()->json([
                'success' => 1,
                'message' => $this->pesan->berhasilAktivasiData
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'message' => $this->pesan->gagalAktivasiData
            ]);
        }
    }

    public function delete($id)
    {
        $produk = Produk::find($id);
        $satuanBeli = SatuanBeli::where('id_produk', $produk->id);
        if($produk->delete() && $satuanBeli->delete()) {
            return response()->json([
                'success' => 1,
                'message' => $this->pesan->berhasilHapusData
            ]);
        } else {
            return response()->json([
                'success' => 0,
                'message' => $this->pesan->gagalHapusData
            ]);
        }
    }
}

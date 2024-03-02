<?php

namespace App\Http\Controllers;

use App\Helpers\Pesan;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    private $pesan;

    public function __construct()
    {
        $this->pesan = new Pesan('produk');
    }

    public function index()
    {
        if(request()->ajax()) {
            return DataTables::of(Kategori::all())
            ->addColumn('_', function($data) {
                $html = '<button title="Detail" class="btn btn-info mr-1 btn-sm" onclick="detail('.$data->id.')"><i class="las la-list"></i></button>';
                $html .= '<button title="Edit" class="btn btn-warning mr-1 btn-sm" onclick="edit('.$data->id.')"><i class="lar la-edit"></i></button>';
                $html .= '<button title="Hapus" class="btn bg-danger btn-sm" onclick="deleteKategori('.$data->id.')"><i class="las la-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['_'])
            ->make(true);
        }
        return view('kategori.index');
    }

    public function detail($id)
    {
        $model = Kategori::find($id);
        $model->produk = Produk::select('nama')->where('id_kategori', $model->id)->get();
        return view('kategori.detail', compact('model'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Kategori::create($data);
        return response()->json([
            'success' => 1
        ]);
    }

    public function edit($id)
    {
        $model = Kategori::find($id);
        return view('kategori.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        Kategori::find($id)->update($data);
        return response()->json([
            'success' => 1
        ]);
    }

    public function delete($id)
    {
        Kategori::find($id)->delete();
        return response()->json([
            'success' => 1
        ]);
    }
}

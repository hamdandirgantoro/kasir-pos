<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PelangganController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(Pelanggan::all())
            ->addColumn('active', function ($data) {
                $checked = $data->active ? 'checked' : '';
                $jsFunction = $data->active ? 'nonActive('.$data->id.',\''.$data->nama.'\')' : 'active('.$data->id.',\''.$data->nama.'\')';
                $html = '<button onclick="'.$jsFunction.'"><input id="active-btn-'.$data->id.'" type="checkbox" class="toggle toggle-info" '.$checked.' /></button>';
                return $html;
            })
            ->addColumn('_', function($data) {
                $html = '<button title="Detail" class="btn btn-info mr-1 btn-sm" onclick="detail('.$data->id.')"><i class="las la-list"></i></button>';
                $html .= '<a title="Edit" class="btn btn-warning mr-1 btn-sm" href="'.route('pelanggan.edit', $data->id).'"><i class="lar la-edit"></i></a>';
                $html .= '<button title="Hapus" class="btn bg-danger btn-sm" onclick="deletePelanggan('.$data->id.')"><i class="las la-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['active', '_'])
            ->make(true);
        }
        return view('pelanggan.index');
    }

    public function detail($id)
    {
        $model = Pelanggan::find($id);

        return view('pelanggan.detail', compact('model'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function edit($id)
    {
        $model = Pelanggan::find($id);
        return view('pelanggan.edit', compact('model'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = isset($data['active']) ? $data['active'] : '0';
        Pelanggan::create($data);
        return redirect()->route('pelanggan');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['active'] = isset($data['active']) ? $data['active'] : '0';
        Pelanggan::find($id)->update($data);
        return redirect()->route('pelanggan');
    }

    public function active($id)
    {
        $data = request()->all();
        Pelanggan::find($id)->update($data);
        return response()->json([
            'success' => 1
        ]);
    }

    public function delete($id)
    {
        Pelanggan::find($id)->delete();

        return response()->json([
            'success' => 1
        ]);
    }

    public function findJson($id)
    {
        $pelanggan = Pelanggan::find($id);
        return response()->json([
            'success' => 1,
            'data' => $pelanggan
        ]);
    }
}

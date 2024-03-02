<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\PelangganMember;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PelangganMemberController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(PelangganMember::with('pelanggan')->get())
            ->addColumn('nama_panggilan', function($data) {
                return $data->pelanggan->nama_panggilan;
            })
            ->addColumn('nama_lengkap', function($data) {
                return $data->pelanggan->nama_lengkap;
            })
            ->addColumn('no_telepon', function($data) {
                return $data->pelanggan->no_telepon;
            })
            ->addColumn('_', function($data) {
                $html = '<button title="Hapus" class="btn bg-danger btn-sm" onclick="deletePelangganMember('.$data->id.')"><i class="las la-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['_'])
            ->make(true);
        }

        return view('pelanggan-member.index');
    }

    public function detail($id)
    {
        $model = PelangganMember::with('pelanggan')->get();
        return view('pelanggan-member.detail', compact('model'));
    }

    public function create()
    {
        if (request()->ajax()) {
            return view('pelanggan-member.create-member-lama');
        }
        return view('pelanggan-member.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if (request()->ajax()) {
            $data['poin'] = 0;
            PelangganMember::create($data);
            return response()->json(['success' => 1]);
        }
        $pelanggan = Pelanggan::create($data);
        PelangganMember::create(['id_pelanggan' => $pelanggan->id, 'poin' => 0]);
        return redirect()->route('pelanggan_membership');
    }

    public function delete($id)
    {
        PelangganMember::find($id)->delete();
        return response()->json(['success' => 1]);
    }
}

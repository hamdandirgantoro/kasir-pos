<?php

namespace App\Http\Controllers;

use App\Models\BenefitMembership;
use App\Models\Pelanggan;
use App\Models\PelangganMember;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BenefitMembershipController extends Controller
{
    public function index()
    {
        $benefitAktif = BenefitMembership::where('active', '1')->first();
        if (request()->ajax()) {
            return DataTables::of(BenefitMembership::all())
            ->addColumn('active', function($data) {
                if ($data->active) {
                    $html = '<label id="status" class="badge badge-success">Aktif</label>';
                } else {
                    $html = '<label id="status" class="badge badge-neutral">Nonaktif</label>';
                }
                return $html;
            })
            ->addColumn('_', function($data) use($benefitAktif) {
                if (!$benefitAktif) {
                    $html = '<button title="Aktivasi" class="btn btn-info mr-1 btn-sm" onclick="active('.$data->id.')"><i class="las la-check"></i></button>';
                } else {
                    $html = '';
                }
                $html .= '<button title="Detail" class="btn btn-info mr-1 btn-sm" onclick="detail('.$data->id.')"><i class="las la-list"></i></button>';
                $html .= '<button title="Edit" class="btn btn-warning mr-1 btn-sm" onclick="edit('.$data->id.')"><i class="lar la-edit"></i></button>';
                $html .= '<button title="Hapus" class="btn bg-danger btn-sm" onclick="deleteBenefitMembership('.$data->id.')"><i class="las la-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['active', '_'])
            ->make(true);
        }

        return view('benefit-membership.index', compact('benefitAktif'));
    }

    public function detail($id)
    {
        $model = BenefitMembership::find($id);
        return view('benefit-membership.detail', compact('model'));
    }

    public function create()
    {
        return view('benefit-membership.create');
    }

    public function edit($id)
    {
        $model = BenefitMembership::find($id);
        return view('benefit-membership.edit', compact('model'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = '0';
        BenefitMembership::create($data);
        return response()->json(['success' => 1]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        BenefitMembership::find($id)->update($data);
        return response()->json(['success' => 1]);
    }

    public function active($id)
    {
        $data = request()->all();
        $benefitMembership = BenefitMembership::find($id);
        $model = $benefitMembership;
        $benefitMembership->update($data);
        return response()->json(['success' => 1, 'data' => $model]);
    }

    public function delete($id)
    {
        BenefitMembership::find($id)->delete();
        return response()->json(['success' => 1]);
    }

    public function pelangganBenefitMembershipJson($id)
    {
        $pelanggan = Pelanggan::find($id);
        if (PelangganMember::where('id_pelanggan', $pelanggan->id)->first()) {
            $dataBenefit = BenefitMembership::where('active', '1')->first();
            return response()->json(['success' => 1, 'data' => $dataBenefit]);
        }
        return response()->json(['success' => 0]);
    }
}

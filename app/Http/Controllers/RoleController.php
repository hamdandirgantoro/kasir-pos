<?php

namespace App\Http\Controllers;

use App\Helpers\Pesan;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    private $pesan;

    public function __construct()
    {
        $this->pesan = new Pesan('role');
    }

    public function index()
    {
        if(request()->ajax()) {
            return DataTables::of(Role::all())
            ->addColumn('_', function($data) {
                $html = '<button title="Detail" class="btn btn-info mr-1 btn-sm" onclick="detail('.$data->id.')"><i class="las la-list"></i></button>';
                $html .= '<button title="Edit" class="btn btn-warning mr-1 btn-sm" onclick="edit('.$data->id.')"><i class="lar la-edit"></i></button>';
                $html .= '<a title="Permission" class="btn btn-primary mr-1 btn-sm" href="'.route('role.permission', $data->id).'"><i class="la la-key"></i></a>';
                $html .= '<button title="Hapus" class="btn bg-danger btn-sm" onclick="deleteRole('.$data->id.')"><i class="las la-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['_'])
            ->make(true);
        }
        return view('role.index');
    }

    public function detail($id)
    {
        $model = Role::find($id);
        return view('role.detail', compact('model'));
    }

    public function create()
    {
        return view('role.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Role::create($data);
        return response()->json([
            'success' => 1
        ]);
    }

    public function edit($id)
    {
        $model = Role::find($id);
        return view('role.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        Role::find($id)->update($data);
        return response()->json([
            'success' => 1
        ]);
    }

    public function permission($id)
    {
        $model = Role::with(['permission'])->find($id);
        // dd($model->permission);
        return view('role.permission', compact('model'));
    }

    public function savePermission(Request $request, $id)
    {
        Permission::where('id_role', $id)->delete();
        foreach ($request->input('nama_route') as $nama_route) {
            $data['id_role'] = $id;
            $data['nama_route'] = $nama_route;
            $data['izin'] = '1';
            Permission::create($data);
        }
        return redirect()->route('role');
    }

    public function delete($id)
    {
        $role = Role::find($id);
        Permission::where('id_role', $role->id)->delete();
        $role->delete();
        return response()->json([
            'success' => 1
        ]);
    }
}

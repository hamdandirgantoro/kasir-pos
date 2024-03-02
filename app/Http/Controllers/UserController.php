<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return DataTables::of(User::with(['role'])->get())
            ->editColumn('role', function($data) {
                $html = '';
                if ($data->role) {
                    $html .= '<label class="badge badge-primary">'.$data->role->nama.'</label>';
                }
                return $html;
            })
            ->editColumn('created_at', function($data) {
                return date('Y-m-d', strtotime($data->created_at));
            })
            ->addColumn('_', function($data) {
                $html = '<button title="Detail" class="btn btn-info mr-1 btn-sm" onclick="detail('.$data->id.')"><i class="las la-list"></i></button>';
                $html .= '<button title="Edit" class="btn btn-warning mr-1 btn-sm" onclick="edit('.$data->id.')"><i class="lar la-edit"></i></button>';
                $html .= '<button title="Hapus" class="btn bg-danger btn-sm" onclick="deleteUser('.$data->id.')"><i class="las la-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['role', '_'])
            ->make(true);
        }
         return view('user.index');
    }

    public function detail($id)
    {
        $model = User::with(['role'])->find($id);
        $model->registrated_at = date('Y-m-d', strtotime($model->created_at));
        return view('user.detail', compact('model'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function edit($id)
    {
        $model = User::with(['role'])->find($id);
        return view('user.edit', compact('model'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return response()->json(['success' => 1]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['password'] = hash::make($data['password']);
        User::find($id)->update($data);
        return response()->json(['success' => 1]);
    }

    public function delete($id)
    {
        return User::find($id)->delete();
    }
}

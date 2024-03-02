@php
    $permissions = App\Models\User::with(['role.permission'])->find(auth()->user()->id)->role->permission;
    $allowedRoutes = [];
    foreach ($permissions as $permission) {
        $allowedRoutes[] = $permission->nama_route;
    }
@endphp
<div class="bg-secondary text-white w-60 overflow-y-auto h-screen pt-16">
    <a href="{{route('dashboard')}}">
        <div class="hover:bg-slate-600 h-12 flex items-center pl-2 @if(Request::route()->getName() === 'dashboard') bg-slate-600 @endif">
            <i class="la la-home mr-1"></i>Dashboard
        </div>
    </a>
    @foreach (App\Models\MenuSidebar::all() as $list)
        @if (in_array($list->nama_route, $allowedRoutes))
            <a href="{{route($list->nama_route)}}" >
                <div class="hover:bg-slate-600 h-12 flex items-center pl-2 @if(strtolower(str_replace(' ', '_', explode('.', Request::route()->getName())[0])) === strtolower(str_replace(' ', '_', $list->nama)) ) bg-slate-600 @endif">
                    <i class="{{ $list->icon }} mr-1"></i>{{ $list->nama }}
                </div>
            </a>
        @endif
    @endforeach
</div>

@extends('layouts.main')

@push('page_library')

@endpush
@push('page_style')

@endpush

@section('content')
<x-Form action="{{ route('role.permission.save', $model->id) }}" method="POST" id="form-permission">
<div class="mb-5 form-control">
@php
    $currentPrefix = '';
@endphp
    @foreach (Route::getRoutes() as $route)
        @if (!in_array($route->getName(), ['sanctum.csrf-cookie',
                                           'ignition.healthCheck',
                                           'ignition.executeSolution',
                                           'ignition.updateConfig',
                                           'access_denied',
                                           'login',
                                           'register',
                                           'logout']))
            @php
            $arrayNamaRoute = explode('.', $route->getName());
            $prefix = $arrayNamaRoute[0];
            $childRoute = implode('.', array_slice($arrayNamaRoute, 1));
            $arrayChildRoute = explode('.', $childRoute);
            @endphp

            @if ($prefix !== $currentPrefix)
                @if ($currentPrefix !== '')
                    </div>
                @endif
                <div class="form-control my-2">
                <div><strong>{{ $prefix }}</strong></div>
                <label class="label cursor-pointer w-fit gap-4">
                  <span class="label-text">Index</span>
                  <input type="checkbox" class="checkbox checkbox-sm checkbox-primary" name="nama_route[]" value="{{ $prefix }}"
                  @foreach ($model->permission as $permission)
                  {{ ($permission->nama_route === $prefix  && $permission->izin) ? "checked" : '' }}
                  @endforeach
                  />
                </label>
            @endif

            @if ($childRoute !== '')
            <label class="label cursor-pointer w-fit gap-4">
                <span class="label-text">{{ $childRoute }}</span>
                <input type="checkbox" class="checkbox checkbox-sm checkbox-primary" name="nama_route[]" value="{{ $prefix.'.'.$childRoute }}"
                @foreach ($model->permission as $permission)
                {{ ($permission->nama_route === $prefix.'.'.$childRoute  && $permission->izin) ? "checked" : '' }}
                @endforeach
                />
            </label>
            @endif

            @php
                $currentPrefix = $prefix;
            @endphp
        @endif
    @endforeach
</div>
<button type="button" class="btn btn-primary btn-outline fixed bottom-10 right-16" onclick="simpan()">Simpan</button>
</x-Form>
@endsection

@push('page_script')
<script>
    function simpan() {
        swal.fire('yakin ?').then((result) => {
            if (result.isConfirmed) {
                $('#form-permission').submit()
            }
        })
    }
</script>
@endpush

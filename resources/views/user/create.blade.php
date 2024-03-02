<x-Form method="POST" action="{{ route('user.store') }}" class="flex flex-col" id="formCreate">
    <input type="text" name="name" placeholder="Username" id="nama" class="input input-bordered" autocomplete="FALSE">
    <input type="email" name="email" placeholder="Email" id="email" class="input input-bordered" autocomplete="FALSE">
    <input type="password" name="password" placeholder="Password" id="password" class="input input-bordered" autocomplete="FALSE">
    <select name="id_role" id="id_role" class="select select-bordered">
        @foreach (App\Models\Role::all()->pluck('nama', 'id') as $key => $value)
        <option value="{{$key}}">{{ $value }}</option>
        @endforeach
    </select>
</x-Form>

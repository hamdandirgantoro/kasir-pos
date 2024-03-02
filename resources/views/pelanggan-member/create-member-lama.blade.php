<x-Form class="grid grid-cols-2 place-items-start" id="formCreate">
    <input type="hidden" name="id_pelanggan" id="input_id_pelanggan">
<!-- component -->
    <div class="flex flex-col items-center justify-center">
        <label class="text-start w-full mb-1 text-sm">Pelanggan</label>
      <div class="relative group">
        <button type="button" id="dropdown-button" class="inline-flex justify-between w-52 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
          <span class="mr-2 text-start" id="select-text">Pilih Pelanggan</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </button>
        <div id="dropdown-menu" class="hidden absolute right-0 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 p-1 space-y-1">
          <!-- Search input -->
          <input id="search-input" class="block w-full px-4 py-2 text-gray-800 border rounded-md  border-gray-300 focus:outline-none" type="text" placeholder="Search items" autocomplete="off">
          <!-- Dropdown content goes here -->
          @foreach (App\Models\Pelanggan::all()->pluck('nama_lengkap', 'id') as $key => $nama_pelanggan )
            <button type="button" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md w-full text-start" data-id="{{ $key }}">{{ $nama_pelanggan }}</button>
          @endforeach
        </div>
      </div>
    </div>
    <div class="flex flex-col gap-2">
        <label for="nama_panggilan">
            <div class="label">
                <span class="label-text">Nama Panggilan</span>
            </div>
            <input disabled name="nama_panggilan" class="input input-bordered w-full" id="nama_panggilan" type="text" autocomplete="false" value="{{ isset($model) ? $model->nama_panggilan : '' }}">
        </label>
        <label for="nama_lengkap">
            <div class="label">
                <span class="label-text">Nama Lengkap</span>
            </div>
            <input disabled name="nama_lengkap" class="input input-bordered w-full" id="nama_lengkap" type="text" autocomplete="false" value="{{ isset($model) ? $model->nama_lengkap : '' }}">
        </label>
        <label for="no_telepon">
            <div class="label">
                <span class="label-text">No Telepon</span>
            </div>
            <input disabled name="no_telepon" class="input input-bordered w-full" id="no_telepon" type="text" autocomplete="false" value="{{ isset($model) ? $model->no_telepon : '' }}">
        </label>
    </div>
</x-Form>

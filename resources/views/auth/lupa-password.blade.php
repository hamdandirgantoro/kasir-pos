<x-Form action="route('lupa-password.handle')" method="POST" class="p-2" id="lupaPasswordForm">
<label class="input input-bordered flex items-center gap-2">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" /></svg>
  <input type="text" class="grow" placeholder="Nama" name="name" oninput="setValue('#input-name')" id="input-name"/>
</label>
<label class="w-full mt-2">
  <div class="label">
    <span class="label-text">Kapan Akun Itu Dibuat?</span>
  </div>
  <input type="date" class="input input-bordered w-full" name="created_at" oninput="setValue('#input-created-at')" id="input-created-at"/>
</label>
</x-Form>

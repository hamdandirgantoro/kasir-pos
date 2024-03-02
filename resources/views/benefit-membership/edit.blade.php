<x-Form action="{{ route('benefit_membership.store') }}" method="POST" class="flex flex-col form-control p-4" id="formCreate">
<div class="flex flex-col justify-end items-start">
    <label class="w-full">
      <div class="label">
        <span class="label-text">Diskon</span>
      </div>
      <input type="text" class="input input-bordered w-full" name="diskon" value="{{ $model->diskon }}"/>
    </label>
    <label class="w-full">
      <div class="label">
        <span class="label-text">Perolehan Poin</span>
      </div>
      <input type="text" class="input input-bordered w-full" name="perolehan_poin" value="{{ $model->perolehan_poin }}"/>
    </label>
</div>
</x-Form>

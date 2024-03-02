@extends('layouts.main')
@push('page_script')

@endpush

@section('content')
<div class="h-screen w-full flex justify-center items-center">
    <x-Form method="POST" action="{{route(Request::route()->getName() == 'login' ? 'login' : 'register')}}" class="bg-white rounded h-fit w-1/3 border border-gray-500 drop-shadow flex flex-col p-3 gap-2" id="formAuth">
        <x-ValidationError></x-ValidationError>
        @if (Request::route()->getName() == 'register')
            <input type="hidden" name="type" value="register">
        @endif
        <input type="hidden" name="">
        <label for="username" class="input input-bordered flex items-center gap-2 mt-2">
            <i class="la la-user text-2xl"></i>
            <input placeholder="Nama User" class="grow" name="name" id="username" type="text" name="username" value="{{isset($model) ? $model->username : ''}}" autocomplete="false">
        </label>
        <label for="email" class="input input-bordered flex items-center gap-2">
            <i class="la la-envelope text-2xl"></i>
            <input placeholder="Email" class="grow" name="email" id="email" type="email" name="email" value="{{isset($model) ? $model->username : ''}}" autocomplete="false">
        </label>
        <label for="password" class="input input-bordered flex items-center gap-2">
            <i class="la la-key text-lg mr-1"></i>
            <input placeholder="Password" class="grow" name="password" class="mb-2 bg-gray-200 outline-gray-300 focus:bg-white focus:outline-gray-100 transition-all p-2 rounded" id="password" type="password" name="password" value="{{isset($model) ? $model->username : ''}}" autocomplete="false">
        </label>
        <button onclick="lupaPassword()" type="button">Lupa Password</button>
        <button type="submit" class="mt-4 btn btn-primary btn-outline">{{Request::route()->getName() == 'login' ? 'Login' : 'Register'}}</button>
    </x-Form>
    <input type="hidden" name="name" id="input-name-hidden">
    <input type="hidden" name="created_at" id="input-created-at-hidden">
</div>
@endsection

@push('page_script')
<script>
    function lupaPassword() {
        $.ajax({
                url: `{{ route("lupa-password") }}`,
                success: (response) => {
                    swal.fire({
                        title: 'Lupa Password',
                        showCancelButton: true,
                        // showConfirmButton: false,
                        html: response
                    }).then((result) => {
                        if(result.isConfirmed){
                            $.ajax({
                                data: {
                                    created_at: $('#input-created-at-hidden').val(),
                                    name: $('#input-name-hidden').val()
                                },
                                url: `{{ route("lupa-password.handle") }}`,
                                success: (response) => {
                                    if (response.success) {
                                            swal.fire({
                                            title: 'Ganti Password',
                                            showCancelButton: true,
                                            // showConfirmButton: false,
                                            html: response.html
                                        }).then((result) => {
                                            if(result.isConfirmed){
                                                update(response.id_user)
                                            } else {

                                            }
                                        })
                                    }
                                }
                            })
                        } else {

                        }
                    })
                }
            })
    }

    function update(id) {
        $.ajax({
            url: `{{ route("lupa-password.handle.update") }}/${id}`,
            type: 'POST',
            dataType: 'JSON',
            data: $('#formEditPassword').serialize(),
            success: function(response) {
                if (response.success) {
                    swal.closeModal();
                } else {
                    swal.closeModal();
                }
            },
            error: function(error) {
                // $('#formCreate').unblock();
                // var response = JSON.parse(error.responseText);
                // $('#formCreate').prepend(validation(response))
            }
        }).done(function() {
            // $('#formCreate').unblock();
        });
    }

    function setValue(id_element) {
        let inputVal = $(id_element).val()
        $(`${id_element}-hidden`).val(inputVal)
        console.log('wkwkw')
    }
</script>
@endpush

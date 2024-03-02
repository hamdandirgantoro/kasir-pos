@if ($errors->any())
    <div role="alert" class="alert alert-warning" id="validation-warning">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        <div class="flex flex-col">
            @foreach ($errors->all() as $error)
            <span>{{ $error }}</span>
            @endforeach
        </div>
        <button type="button" onclick="dismiss()"><i class="text-2xl las la-times-circle"></i></button>
    </div>

    <script>
        function dismiss() {
            $('#validation-warning').remove();
        }
    </script>
@endif

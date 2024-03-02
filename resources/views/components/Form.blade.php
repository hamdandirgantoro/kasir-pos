<form action="{{$attributes->get('action')}}" method="{{$attributes->get('method')}}" class="{{$attributes->get('class')}}" id="{{$attributes->get('id')}}">
    @csrf
    {{ $slot }}
</form>

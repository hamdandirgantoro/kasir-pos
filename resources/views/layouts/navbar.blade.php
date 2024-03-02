<nav id="navbar" class="p-2 h-14 !w-screen bg-snow drop-shadow grid grid-cols-3 bg-slate-50 ">
    <div id="left-nav" class="flex justify-start items-center">
        <button class="hover:hover:bg-slate-200 px-1 rounded lg:hidden">
            <i class="las la-bars text-3xl"></i>
        </button>
    </div>
    <div id="middle-nav" class=" flex justify-center items-center">
        <div id="clock" class="bg-gray-300 flex rounded-l p-1 px-2">
            <div id="hour" class="">00</div>
            <div>:</div>
            <div id="minute" class="">00</div>
            <div>:</div>
            <div id="second" class="">00</div>
        </div>
        <div class="bg-gray-400 flex rounded-r p-1 px-2 text-nowrap" id="date"></div>
    </div>
    <div id="right-nav" class=" flex justify-end items-center overflow-hidden">
        <button onclick="toggleFullScreen()"><i class="las la-compress text-2xl mr-2" id="icon-fullscreen"></i></button>
        <div id="account" class="bg-gray-300 hover:bg-gray-400 transition-colors ease-in duration-75 rounded-md flex items-center cursor-pointer">
            <h4 class="px-2">{{auth()->user()->name}}</h4>
            <i class="las la-user-circle text-3xl bg-gray-400 rounded-r-md p-1"></i>
        </div>
        <div class="bg-white drop-shadow rounded absolute top-12 mt-1 right-2 w-fit hidden" id="accountDropdown">
            <div class="border-b border-gray-200 p-1 hover:bg-gray-200">
                <a href="{{ route('akun.setting') }}">
                    Pengaturan
                </a>
            </div>
            <div class="p-1 hover:bg-gray-200">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

@php
    $route = Route::currentRouteName();
    
@endphp


<div class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
    <ul class="list-reset flex flex-row md:flex-col pt-3 md:py-3 px-1 md:px-2 text-center md:text-left">

        <li class="mr-3 flex-1">
            <a href="{{ route('home') }}"
                class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{ $route == 'home' ? 'border-blue-600' : 'border-gray-800' }} hover:border-blue-600">
                <i class="fas fa-chart-area pr-0 md:pr-3 text-blue-600"></i><span
                    class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">Customers</span>
            </a>
        </li>
        <li class="mr-3 flex-1">
            <a href="{{ route('transaction') }}"
                class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2  {{ $route == 'transaction' ? 'border-pink-600' : 'border-gray-800' }} hover:border-pink-500">
                <i class="fas fa-tasks pr-0 md:pr-3"></i><span
                    class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Transaction</span>
            </a>
        </li>
        <li class="mr-3 flex-1">
            <a href="#"
                class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">
                <i class="fa fa-envelope pr-0 md:pr-3"></i><span
                    class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Messages</span>
            </a>
        </li>

        <li class="mr-3 flex-1">
            <a href="#"
                class="block py-1 md:py-3 pl-0 md:pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-red-500">
                <i class="fa fa-wallet pr-0 md:pr-3"></i><span
                    class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Payments</span>
            </a>
        </li>
    </ul>
</div>

<div>
    @if ($carts->count() > 0)
        <a href="{{ route('page.cart') }}"
            class="relative inline-flex items-center p-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">
            <x-feathericon-shopping-cart class="h-6 w-6 text-gray-100" />
            <span class="sr-only">
                {{ __('Cart') }}
            </span>
            <div
                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2 dark:border-gray-900">
                {{ $carts->count() }}
            </div>
        </a>
    @endif
</div>

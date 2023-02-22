<div class="p-2 bg-gray-50 dark:bg-gray-900">
    <x-list>
        @slot('search')
        @endslot

        @slot('options')
        @endslot

        @slot('table')
            <x-table>
                @slot('header')
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Photo') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Name') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Description') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Action') }}
                        </th>
                    </tr>
                @endslot

                @slot('body')
                    @foreach ($carts as $cart)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">
                                <img class="rounded-lg w-36 h-28" src="{{ Storage::url($cart->product->photo) }}"
                                alt="" />
                            </td>

                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $cart->product->name }}
                            </th>

                            <td class="px-6 py-4">
                                {{ $cart->product->description }}
                            </td>

                            <td class="px-6 py-4">
                                <a wire:click='modalBuy({{ $cart->id }})'
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">{{ __('Buy') }}</a>
                                <a wire:click='modalDelete({{ $cart->id }})'
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline cursor-pointer">{{ __('Delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                @endslot
            </x-table>

            @slot('paginate')
                {{ $carts->links('vendor.livewire.custom') }}
            @endslot
        @endslot
    </x-list>

    <x-dialog wire:model="deleteModal">
        <x-slot name="title">
            <div class="flex col-span-6 sm:col-span-4 items-center">
                <x-feathericon-alert-triangle class="h-10 w-10 text-red-500 mr-2" />
                {{ __('Delete') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="flex col-span-6 sm:col-span-4 items-center gap-2">
                <x-feathericon-trash class="h-20 w-20 text-red-500 mr-2" />
                <p>
                    {{ __('Once deleted, the record cannot be recovered.') }}
                </p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-btn-red wire:click="$set('deleteModal', false)" wire:loading.attr="disabled">
                @slot('content')
                    {{ __('Cancel') }}
                @endslot
            </x-btn-red>
            <x-btn-blue class="ml-2" wire:click='delete' wire:loading.attr="disabled">
                @slot('content')
                    {{ __('Accept') }}
                @endslot
            </x-btn-blue>
        </x-slot>
    </x-dialog>

    <x-dialog wire:model="buyModal">
        <x-slot name="title">
            <div class="flex col-span-6 sm:col-span-4 items-center">
                <x-feathericon-shopping-cart class="h-10 w-10 text-green-500 mr-2" />
                {{ __('Buy') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="flex col-span-6 sm:col-span-4 items-center gap-2">
                @if ($buyModal == true)
                    <img class="rounded-lg w-36 h-36" src="{{ Storage::url($selected->photo) }}" alt="" />
                    <div class="w-full">
                        <h1 class="text-2xl text-center text-gray-900 dark:text-gray-100">
                            {{ $selected->name }}
                        </h1>

                        <p class="text-lg text-justify text-gray-900 dark:text-gray-100">
                            {{ $selected->description }}
                        </p>
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-btn-red wire:click="$set('buyModal', false)" wire:loading.attr="disabled">
                @slot('content')
                    {{ __('Cancel') }}
                @endslot
            </x-btn-red>
            <x-btn-blue class="ml-2" wire:click='buy' wire:loading.attr="disabled">
                @slot('content')
                    {{ __('Accept') }}
                @endslot
            </x-btn-blue>
        </x-slot>
    </x-dialog>
</div>
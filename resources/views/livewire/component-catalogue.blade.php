<div class="p-2 bg-gray-50 dark:bg-gray-900">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-2">
        <div class="col-span-1 md:col-span-3">
            @livewire('component-menu')
        </div>

        <div class="col-span-1 md:col-span-9">
            @if ($categories->count() > 0)
                <x-carousel>
                    @slot('body')
                        @foreach ($categories as $category)
                            <x-item-carousel src="{{ Storage::url($category->photo) }}">
                            </x-item-carousel>
                        @endforeach
                    @endslot
                </x-carousel>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="col-span-1 md:col-span-12 px-3 py-4 rounded bg-gray-50 dark:bg-gray-800 mt-4">
                    <h1 class="text-4xl text-center text-gray-900 dark:text-gray-100">
                        {{ __('The most sold') }}
                    </h1>
                </div>

                @foreach ($products as $product)
                    <x-card-product>
                        @slot('photo')
                            <img class="rounded-t-lg w-full h-52" src="{{ Storage::url($product->photo) }}"
                                alt="" />
                        @endslot

                        @slot('name')
                            {{ $product->name }}
                        @endslot

                        @slot('description')
                            {{ $product->description }}
                        @endslot

                        @slot('price')
                            {{ $product->price }} Bs
                        @endslot

                        @slot('button')
                            <x-btn-blue wire:click='modalAdd({{ $product->id }})' class="text-center">
                                @slot('content')
                                    {{ __('Add') }}
                                @endslot
                            </x-btn-blue>
                        @endslot
                    </x-card-product>
                @endforeach
            </div>

            <div class="mt-2">
                {{ $products->links('vendor.livewire.custom') }}
            </div>
        </div>
    </div>

    <x-dialog wire:model="addModal">
        <x-slot name="title">
            <div class="flex col-span-6 sm:col-span-4 items-center">
                <x-feathericon-shopping-cart class="h-10 w-10 text-green-500 mr-2" />
                {{ __('Add') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="flex col-span-6 sm:col-span-4 items-center gap-2">
                @if ($addModal == true)
                    <img class="rounded-lg w-36 h-36" src="{{ Storage::url($selected->photo) }}" alt="" />
                    <div class="w-full">
                        <h1 class="text-2xl text-center text-gray-900 dark:text-gray-100">
                            {{ $selected->name }}
                        </h1>

                        <p class="text-lg text-justify text-gray-900 dark:text-gray-100">
                            {{ $selected->description }}
                        </p>

                        <div class="flex justify-between items-center mt-2 gap-4">
                            <x-label>
                                @slot('content')
                                    {{ __('Amount') }}
                                @endslot
                            </x-label>

                            <x-input-numeric min="1" wire:model='amount' />
                        </div>

                        <x-input-error for="amount" />
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-btn-red wire:click="$set('addModal', false)" wire:loading.attr="disabled">
                @slot('content')
                    {{ __('Cancel') }}
                @endslot
            </x-btn-red>
            <x-btn-blue class="ml-2" wire:click='addProduct' wire:loading.attr="disabled">
                @slot('content')
                    {{ __('Accept') }}
                @endslot
            </x-btn-blue>
        </x-slot>
    </x-dialog>
</div>

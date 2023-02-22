<div class="p-2 bg-gray-50 dark:bg-gray-900">
    <x-form>
        @slot('form')
            <div class="col-span-1 md:col-span-12">
                <x-label>
                    @slot('content')
                        {{ __('Name') }}
                    @endslot
                </x-label>

                <x-input-text wire:model='name' />

                <x-input-error for="name" />
            </div>

            <div class="col-span-1 md:col-span-12">
                <x-label>
                    @slot('content')
                        {{ __('Description') }}
                    @endslot
                </x-label>

                <x-input-textarea wire:model='description' />

                <x-input-error for="description" />
            </div>

            <div class="col-span-1 md:col-span-6">
                <x-label>
                    @slot('content')
                        {{ __('Image') }}
                    @endslot
                </x-label>

                <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <!-- File Input -->
                    <x-input-file id="upload{{ $iteration }}" wire:model='photo' />

                    <!-- Progress Bar -->
                    <div x-show="isUploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                </div>

                <x-input-error for="photo" />
            </div>

            <div class="relative col-span-1 md:col-span-6">
                <x-label>
                    @slot('content')
                        {{ __('Category') }}
                    @endslot
                </x-label>

                <x-select wire:model="category_id">
                    @slot('content')
                        <option value="null">{{ __('Select an option') }}</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @endslot
                </x-select>

                <x-input-text class="mt-2" wire:model='inputSearchCategory' placeholder="{{ __('Search') }} {{ __('Category') }}" />

                @if ($inputSearchCategory != null)
                    <ul
                        class="absolute z-50 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @foreach ($searchCategories as $searchCategory)
                            <li wire:click='selectCategory({{ $searchCategory->id }})' class="w-full px-4 py-2 border-b border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-500 cursor-pointer">
                                {{ $searchCategory->name }}</li>
                        @endforeach
                    </ul>
                @endif

                <x-input-error for="category_id" />
            </div>

            <div class="col-span-1 md:col-span-6">
                <x-label>
                    @slot('content')
                        {{ __('Price') }}
                    @endslot
                </x-label>

                <x-input-numeric step="0.01" wire:model='price' />

                <x-input-error for="price" />
            </div>
        @endslot

        @slot('photo')
            @if ($activity == 'create')
                <div class="text-center">
                    @if ($photo)
                        <x-label>
                            @slot('content')
                                {{ __('Preview') }}
                            @endslot
                        </x-label>
                        <img src="{{ $photo->temporaryUrl() }}" class="rounded-2xl h-36 w-36 object-cover">
                    @endif
                </div>
            @endif

            @if ($activity == 'edit')
                <div class="text-center">
                    <x-label>
                        @slot('content')
                            {{ __('Previous image') }}
                        @endslot
                    </x-label>

                    <img src="{{ Storage::url($photoBefore) }}" class="rounded-2xl h-36 w-36 object-cover">
                </div>

                <div class="text-center">
                    @if ($photo)
                        <x-label>
                            @slot('content')
                                {{ __('New image') }}
                            @endslot
                        </x-label>
                        <img src="{{ $photo->temporaryUrl() }}" class="rounded-2xl h-36 w-36 object-cover">
                    @endif
                </div>
            @endif
        @endslot

        @slot('buttons')
            @if ($activity == 'create')
                <x-btn-blue wire:click='store' wire:loading.attr="disabled" wire:target="store, image">
                    @slot('content')
                        {{ __('Save') }}
                    @endslot
                </x-btn-blue>
            @endif

            @if ($activity == 'edit')
                <x-btn-green wire:click='update'>
                    @slot('content')
                        {{ __('Update') }}
                    @endslot
                </x-btn-green>

                <x-btn-red wire:click='clear'>
                    @slot('content')
                        {{ __('Cancel') }}
                    @endslot
                </x-btn-red>
            @endif
        @endslot
    </x-form>

    <x-list>
        @slot('search')
            <div class="col-span-1 md:col-span-12">
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model="search"
                        class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @if ($search != null)
                        <a wire:click='resetSearch'
                            class="text-white absolute right-2.5 bottom-2.5 bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 cursor-pointer">
                            X
                        </a>
                    @endif
                </div>
            </div>
        @endslot

        @slot('options')
        @endslot

        @slot('table')
            <x-table>
                @slot('header')
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Category') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Name') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Description') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Price') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Status') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Action') }}
                        </th>
                    </tr>
                @endslot

                @slot('body')
                    @foreach ($products as $product)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $product->category->name }}
                            </th>

                            <td class="px-6 py-4">
                                {{ $product->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $product->description }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $product->price }} Bs
                            </td>

                            <td class="px-6 py-4">
                                @if ($product->status == 1)
                                    <div class="flex p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
                                        role="alert">
                                        <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">info</span>
                                        <div>
                                            <span class="font-medium">{{ __('Active') }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($product->status == 3)
                                    <div class="flex p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                                        role="alert">
                                        <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">info</span>
                                        <div>
                                            <span class="font-medium">{{ __('Published') }}</span>
                                        </div>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if ($product->status == 1)
                                    <a wire:click='publish({{ $product->id }})'
                                        class="font-medium text-green-600 dark:text-green-500 hover:underline cursor-pointer">{{ __('Publish') }}</a>
                                @endif

                                <a wire:click='edit({{ $product->id }})'
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">{{ __('Edit') }}</a>
                                <a wire:click='modalDelete({{ $product->id }})'
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline cursor-pointer">{{ __('Delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                @endslot
            </x-table>

            @slot('paginate')
                {{ $products->links('vendor.livewire.custom') }}
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
</div>

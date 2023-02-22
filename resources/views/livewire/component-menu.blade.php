<div>
    <x-menu>
        @slot('body')
            <ul class="space-y-2">
                @foreach ($categories as $category)
                    <li>
                        <x-item-menu href="{{ route('page.show', $category) }}">
                            @slot('content')
                                <x-feathericon-tag
                                    class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                                <span class="ml-3">{{ $category->name }}</span>
                            @endslot
                        </x-item-menu>
                    </li>
                    <ul class="space-y-2 pl-5">
                        @foreach ($category->childrenCategories as $childrenCategories)
                            @include('child-menu', ['childrenCategories' => $childrenCategories])
                        @endforeach
                    </ul>
                @endforeach
            </ul>
        @endslot
    </x-menu>
</div>

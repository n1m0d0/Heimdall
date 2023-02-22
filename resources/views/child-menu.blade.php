<li>
    <x-item-menu href="{{ route('page.show', $childrenCategories) }}">
        @slot('content')
            <x-feathericon-tag
                class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
            <span class="ml-3">{{ $childrenCategories->name }}</span>
        @endslot
    </x-item-menu>
</li>
@if ($childrenCategories->categories)
    <ul class="space-y-2 pl-5">
        @foreach ($childrenCategories->categories as $childrenCategories)
            @include('child-menu', ['childrenCategories' => $childrenCategories])
        @endforeach
    </ul>
@endif

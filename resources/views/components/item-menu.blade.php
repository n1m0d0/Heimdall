<a
    {{ $attributes->merge([
        'class' =>
            'flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer',
    ]) }}>
    {{ $content }}
</a>

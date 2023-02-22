@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'mt-2 text-xs text-red-600 dark:text-red-400']) }}>{{ $message }}</p>
@enderror
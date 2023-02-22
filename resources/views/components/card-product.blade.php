<div
    class="col-span-1 md:col-span-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 h-auto">

    {{ $photo }}

    <div class="pr-5 pl-5 pt-5 h-16">
        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
            {{ $name }}
        </h5>
    </div>
    <div class="pr-5 pl-5 pt-2 h-16">
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
            {{ $description }}
        </p>
    </div>
    <div class="pr-5 pl-5 pb-5 flex justify-between items-center">        
        <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">
            {{ $price }}
        </h5>

        {{ $button }}
    </div>
</div>

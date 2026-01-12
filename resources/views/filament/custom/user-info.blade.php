<div class="flex items-center px-3 py-2 ml-1 border-gray-300 dark:border-gray-700">
    <div class="text-left hidden sm:block">
        <p class="text-sm font-bold text-gray-800 dark:text-white leading-none">
            {{ auth()->user()->name }}
        </p>
        <p class="text-xs uppercase tracking-wider text-gray-500 leading-tight">
            {{ auth()->user()->employee->job_desk ?? 'Administrator' }}
        </p>
    </div>
</div>
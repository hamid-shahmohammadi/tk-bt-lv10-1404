<x-filament-panels::page>
    @if ($alert)
    <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
        role="alert">
        {{ $alert }}
    </div>
@endif
<form wire:submit="updatePass" class="w-full mx-auto">
    <div class="mb-5">
        <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">کلمه عبور
            قبلی</label>
        <input wire:model="current_pass" type="password" id="current_password"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required />
    </div>
    <div class="mb-5">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            کلمه عبور</label>
        <input wire:model="new_pass" type="password" id="password"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required />
            @error('new_pass') <span class="error text-sm text-red-700">{{ $message }}</span> @enderror
    </div>
    <div class="mb-5">
        <label for="password_confirm" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            تکرار کلمه عبور</label>
        <input wire:model="repeat_pass" type="password" id="password"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required />
    </div>

    <button type="submit"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">تغییر کلمه عبور</button>
</form>
</x-filament-panels::page>

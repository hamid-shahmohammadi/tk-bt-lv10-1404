<x-filament-panels::page>
    <div>
        <template x-if="$wire.alert">
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <span class="font-medium" x-text="$wire.alert"></span>
            </div>
        </template>
        <form wire:submit="submit" autocomplete="off">

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-first-name">
                        نام کاربری
                    </label>
                    <input wire:model="username"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="text" placeholder="نام کاربری">
                    <div v-if="form.errors.username" v-text="form.errors.username" class="text-red-500 text-xs mt-1">
                    </div>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-last-name">
                        کلمه عبور
                    </label>
                    <input wire:model="password"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        type="string" placeholder="کلمه عبور">
                    <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-1">
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-first-name">
                        آدرس url
                    </label>
                    <input wire:model="url"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="string" placeholder="url">
                    <div v-if="form.errors.url" v-text="form.errors.url" class="text-red-500 text-xs mt-1"></div>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-last-name">
                        from
                    </label>
                    <input wire:model="from"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        type="text" placeholder="from">
                    <div v-if="form.errors.from" v-text="form.errors.from" class="text-red-500 text-xs mt-1"></div>
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-first-name">
                        پیام سالروز تولد
                    </label>
                    <textarea wire:model="happy_birthday_massage"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        placeholder="پیام تبریک سالروز تولد">
                                </textarea>
                    <div v-if="form.errors.happy_birthday_massage" v-text="form.errors.happy_birthday_massage"
                        class="text-red-500 text-xs mt-1"></div>
                </div>

                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label for="name" class="block mb-2 uppercase font-bold text-xs text-gray-700 mr-2">
                        فعال سازی ارسال پیام تولد
                    </label>

                    <input wire:model="happy_birthday" :checked="$wire.happy_birthday == 1 ? true : false"
                        type="checkbox" class="border border-gray-400 p-2 mr-2">

                </div>
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-gray-600 text-white rounded py-2 px-4 hover:bg-gray-900">
                    ثبت اطلاعات
                </button>
            </div>
        </form>
    </div>

</x-filament-panels::page>

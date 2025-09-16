<x-filament-panels::page>
    <link rel="stylesheet" href="{{ asset('css/jalalidatepicker.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/jalalidatepicker.min.js') }}"></script>
    <form class="w-full " wire:submit.prevent="search">
        <div class="flex justify-center items-center mb-6">
            <div class="px-3 mb-6 md:mb-0">
                <label class="dark:text-white uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                    for="grid-first-name">
                    تاریخ شروع
                </label>
                <input wire:model="start_date" data-jdp autocomplete="off"
                    class="appearance-none w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                    id="grid-first-name" type="text" placeholder="تاریخ شروع">

            </div>
            <div class="px-3">
                <label class="uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-white"
                    for="grid-last-name">
                    تاریخ پایان
                </label>
                <input data-jdp wire:model="end_date" autocomplete="off"
                    class="appearance-none w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    type="text" placeholder="تاریخ پایان">
            </div>
            <div class="px-3">
                <label class="uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-white"
                    for="grid-last-name">
                    کد ملی
                </label>
                <input wire:model="national_code" autocomplete="off"
                    class="appearance-none w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    type="text" placeholder="کدملی">
            </div>

            <div class="mt-5 px-3">
                <button type="submit" class="bg-blue-500 text-white rounded px-4 py-3">جستجو</button>
            </div>

        </div>
    </form>


    <script>
        jalaliDatepicker.startWatch({
            autoShow: false
        });
        var inputList = document.querySelectorAll("input[data-jdp]");
        for (i = 0; i < inputList.length; i++) {
            inputList[i].addEventListener('focus', function() {
                var defaults = {
                    date: true,
                    time: false,
                    dayRendering: null
                };

                jalaliDatepicker.show(this);
            });
        }
    </script>
</x-filament-panels::page>

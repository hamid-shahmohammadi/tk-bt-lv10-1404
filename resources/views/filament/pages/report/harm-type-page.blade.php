<x-filament-panels::page>
    <form wire:submit="report">
        <div class="flex">
            <select wire:model="ht"
                class="block dark:text-black appearance-none w-1/2 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option>لطفا انتخاب فرمایید</option>
                @foreach ($this->getHarmTypes as $harmType)
                    <option value="{{ $harmType->id }}">{{ $harmType->name }}</option>
                @endforeach
            </select>
            <button type="submit"  class="mr-4 bg-blue-500 rounded py-2 px-3 text-white">گزارش</button>
        </div>
    </form>
</x-filament-panels::page>

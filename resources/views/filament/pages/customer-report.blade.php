<x-filament-panels::page>
    <form wire:submit="report">
        <div class="flex">
            <select wire:model="org"
                class="block appearance-none w-1/2 bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option>لطفا انتخاب فرمایید</option>
                @foreach ($this->getOrg as $org)
                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                @endforeach
            </select>
            <button type="submit"  class="mr-4 bg-blue-500 rounded py-2 px-3 text-white">گزارش</button>
        </div>
    </form>
</x-filament-panels::page>

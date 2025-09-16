<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th class="px-6 py-4">
                    <input type="checkbox" wire:model="selectAllCheckbox" wire:click="selectAll" />
                </th>
                <th scope="col" class="px-6 py-3">
                    نام و نام خانوادگی
                </th>
                <th scope="col" class="px-6 py-3">
                    کدملی
                </th>
                <th scope="col" class="px-6 py-3">
                    تعهدات
                </th>
                <th scope="col" class="px-6 py-3">
                    هزینه
                </th>
                <th scope="col" class="px-6 py-3">
                    هزینه تایید شده
                </th>
                <th scope="col" class="px-6 py-3">
                    تاریخ ایجاد
                </th>
                <th scope="col" class="px-6 py-3">
                    تاریخ صورتحساب
                </th>
                <th scope="col" class="px-6 py-3">
                    <x-icons.setting />
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($harms as $harm)
                @if ($harm->cost_submit > 0)
                    <tr class="bg-green-200 border-b dark:bg-green-900">
                    @else
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                @endif
                <td class="px-6 py-4">
                    <input type="checkbox" wire:model="selectedRoles" value="{{ $harm->id }}" id="selectHarm" />
                </td>
                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">
                    @if ($harm->depend)
                        {{ $harm->depend->name . ' ' . $harm->depend->family }}
                    @else
                        {{ $harm->customer->name . ' ' . $harm->customer->family }}
                    @endif
                </th>
                <td class="px-6 py-4">
                    @if ($harm->depend)
                        {{ $harm->depend->national_code }}
                    @else
                        {{ $harm->customer->national_code }}
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{ $harm->harmtype->name }}
                </td>
                <td class="px-6 py-4">
                    {{ $harm->cost }}
                </td>
                <td class="px-6 py-4">
                    {{ $harm->cost_submit }}
                </td>
                <td class="px-6 py-4">
                    {{ \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($harm->created_at)) }}
                </td>
                <td class="px-6 py-4">
                    {{ $harm->billing_date }}
                </td>
                <td class="px-6 py-4 flex">
                    <a class="text-blue-400 hover:text-blue-700"
                        href="{{ route('filament.admin.resources.customers.attach', $harm->id) }}">
                        <x-icons.attach />
                    </a>
                    @if ($harm->doctor_approval)
                        <button type="button" wire:click="approve({{ $harm->id }})"
                            class="text-blue-400 hover:text-blue-700">
                            <x-icons.ok />
                        </button>
                    @else
                        <button type="button" wire:click="approve({{ $harm->id }})"
                            class="text-red-400 hover:text-red-700">
                            <x-icons.notok />
                        </button>
                    @endif
                    @if ($harm->payment_status_id == 1)
                        <span class="text-success-400 hover:text-success-700">
                            <x-icons.check-circle />
                        </span>
                    @endif
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $harms->links() }}
    </div>
</div>


<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    کد رهگیری
                </th>
                <th scope="col" class="px-6 py-3">
                    نام و نام خانوادگی
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
                    <x-icons.setting />
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->get_harms() as $harm)

                @if ($harm->cost_submit > 0)
                    <tr class="bg-green-200 border-b dark:bg-green-900">
                    @else
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                @endif
                <td class="px-6 py-4">
                    {{ $harm->id }}
                </td>
                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">
                    @if ($harm->depend)
                        {{ $harm->depend->name . ' ' . $harm->depend->family }}
                    @else
                        {{ $harm->customer->name . ' ' . $harm->customer->family }}
                    @endif
                </th>
                <td class="px-6 py-4">
                    {{ $harm->harmtype->name }}
                </td>
                <td class="px-6 py-4">
                    {{ $harm->cost }}
                </td>
                <td class="px-6 py-4">
                    {{ $harm->cost_submit }}
                </td>
                <td class="px-6 py-4" >
                    @if ($harm->created_at)

                    {{ \Morilog\Jalali\Jalalian::fromCarbon($harm->created_at)->format('Y/m/d') }}
                    @endif
                </td>
                <td class="px-6 py-4 flex items-center">
                    <x-mary-button class="btn-sm btn-primary px-1" icon="o-pencil-square" @click="$wire.editHarmFunc({{$harm->id}})" />
                    <x-mary-button class="btn-sm btn-error px-1 mr-2 text-white" icon="o-trash" @click="if(confirm('are u sure?')) {$wire.deleteHarmFunc({{$harm->id}})}" />
                    <x-mary-button class="btn-sm btn-warning text-white px-1 mr-2" icon="o-battery-50" @click="$wire.showRemindFunc({{$harm->id}})" />
                    <a class="text-blue-400 hover:text-blue-700 mr-2"
                        href="{{ route('filament.admin.resources.customers.attach', $harm->id) }}">
                        <x-icons.attach />
                    </a>
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $this->get_harms()->links() }}
    </div>

    <x-mary-modal wire:model="editModalHarm" class="backdrop-blur editHarm">
        <x-harm.form-edit :customer="$customer" :message="$message" />
    </x-mary-modal>


    <x-mary-modal wire:model="modalReminder" class="backdrop-blur">

        <ul class="p-2">
            <li>جمع هزینه ها: <span x-text="$wire.cost_sum_type"></span></li>
            <li>تعهد قرارداد: <span x-text="$wire.harm_type_name_remind"></span></li>
            <li>مبلغ تعهد: <span x-text="$wire.cd_cost"></span></li>
            <li>مبلغ باقیمانده: <span x-text="$wire.cd_cost-$wire.cost_sum_type"></span></li>
        </ul>

        <x-mary-button label="بستن" @click="$wire.modalReminder = false" />
    </x-mary-modal>
</div>

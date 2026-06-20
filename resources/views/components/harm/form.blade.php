<link rel="stylesheet" href="{{ asset('css/jalalidatepicker.min.css') }}">
<script type="text/javascript" src="{{ asset('js/jalalidatepicker.min.js') }}"></script>
<form x-data="formHandler" wire:submit.prevent="storeSick">
    @if ($message)
        <div class="my-2 bg-green-600 border border-green-400 text-white px-4 py-3 rounded relative">{{ $message }}
        </div>
    @endif

    <div class="flex">
        <div class="w-full w-1/2 h-14">
            <label class="dark:text-black">نام بیمار:*</label>
            <select wire:model="form.sick"
                class="block appearance-none w-full bg-white dark:text-black border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option>انتخاب فرمایید</option>
                <option value="{{ $customer->id }}">{{ $customer->name . ' ' . $customer->family }}</option>
                @if ($this->customer->depends->count() > 0)
                    @foreach ($this->customer->depends as $depend)
                        <option value="{{ $customer->id . '-' . $depend->id }}">
                            {{ $depend->name . ' ' . $depend->family }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('form.sick')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-full w1/2 h-14 mr-2">
            <label class="dark:text-black">تعهدات قرارداد :*</label>
            <select wire:model="form.harm_type_id"
                class="block dark:text-black appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option>انتخاب فرمایید</option>
                @if ($this->harmTypes->count() > 0)
                    @foreach ($this->harmTypes as $harmType)
                        <option value="{{ $harmType->id }}">{{ $harmType->name }}</option>
                    @endforeach
                @endif
            </select>
            @error('form.harm_type_id')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex mt-8">
        <div class="w-full w-1/2 h-14">
            <label class="dark:text-black">وضعیت پرداخت :*</label>
            <select wire:model="form.payment_status_id"
                class="block dark:text-black appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option>انتخاب فرمایید</option>
                @if ($this->paymentStatus->count() > 0)
                    @foreach ($this->paymentStatus as $ps)
                        <option value="{{ $ps->id }}">{{ $ps->name }}</option>
                    @endforeach
                @endif
            </select>
            @error('form.payment_status_id')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-full w1/2 h-14 mr-2">
            <label class="dark:text-black"> مبلغ هزینه:*</label>
            <input wire:model.live="form.cost" x-ref="cost" @keyup="cost_sep=numberWithCommas($refs.cost.value)"
                class="block dark:text-black appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline" />
            @if ($this->form->cost)
                <span class="text-sm dark:text-black" x-text="cost_sep"></span>
            @endif
            @error('form.cost')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="flex mt-8">       
        <div class="w-full w-1/2 h-14 mr-2">
            <label class="dark:text-black"> مبلغ تایید شده:</label>
            <input wire:model.live="form.cost_submit" x-ref="cost_submit"
                @keyup="cost_submit_sep=numberWithCommas($refs.cost_submit.value)"
                class="block dark:text-black appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-3 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline" />

            <span class="text-sm" x-text="cost_submit_sep"></span>
        </div>

        <div class="w-full w1/2 h-14 mr-2">
            <label class="dark:text-black"> تاریخ صورت حساب:*</label>
            <input wire:model="form.billing_date" data-jdp
                class="block dark:text-black appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-3 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            @error('form.billing_date')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

    </div>
    <div class="flex mt-8">
        
        <div class="w-full w-1/2 h-14 mr-2">
            <label class="dark:text-black"> قرارداد:</label>
            <select wire:model="form.contract_id"
                class="block dark:text-black appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option>انتخاب فرمایید</option>
                @if ($this->contracts->count() > 0)
                    @foreach ($this->contracts as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                @endif
            </select>
            @error('form.contract_id')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-full w-1/2 h-14 mr-2">
            <label class="dark:text-black">علی الحساب:</label>
            <input wire:model="form.prepayment" type="number"
                class="block dark:text-black appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-3 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline" />
        </div>
    </div>
    <div class="flex mt-8">
        
        <div class="w-full  h-14 mr-2">
            <label class="dark:text-black">توضیحات:</label>
            <textarea wire:model="form.description"
                class="block dark:text-black appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-3 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            </textarea>

        </div>
    </div>

    <div class="flex justify-end mt-10">
        <x-mary-button class="btn-primary" type="submit">ثبت اطلاعات</x-mary-button>
        {{-- <button type="submit"
            class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-primary-500 rounded-md dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:bg-primary-700 hover:bg-primary-600 focus:outline-none focus:bg-primary-500 focus:ring focus:ring-primary-300 focus:ring-opacity-50">
            ثبت اطلاعات
        </button> --}}
    </div>
</form>

<script>
    jalaliDatepicker.startWatch();

    function formHandler() {
        return {
            cost_sep: null,
            cost_submit_sep: null,
            numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")

            }
        }
    }
</script>

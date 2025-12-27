<x-filament-panels::page>
    <div class="flex justify-between">
        @if (auth()->user()->can('create_customer'))
            <x-modal.index title="ثبت خسارت">
                <x-harm.form :customer="$customer" :message="$message" />
            </x-modal.index>
        @endif
    </div>
    <x-harm.list :customer="$customer" :message="$message" />
</x-filament-panels::page>

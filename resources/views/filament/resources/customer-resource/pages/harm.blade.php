<x-filament-panels::page>
    <div class="flex justify-between">
    <x-modal.index title="ثبت خسارت">
       <x-harm.form :customer="$customer" :message="$message" />
    </x-modal.index>
    <div class="text-red-500">داروهای مکمل غیر قابل قبول می باشد.</div>
    </div>
    
    <x-harm.list :customer="$customer" :message="$message"  />
</x-filament-panels::page>

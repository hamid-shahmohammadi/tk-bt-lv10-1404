<x-filament-panels::page>
    <div class="flex justify-between">
    <x-modal.index title="ثبت خسارت">
       <x-harm.form :customer="$customer" :message="$message" />
    </x-modal.index>    
    </div>
    
    <x-harm.list :customer="$customer" :message="$message"  />
</x-filament-panels::page>

<x-filament-panels::page>
    <form wire:submit.prevent="save">
        <div class="flex items-center justify-center w-full">
            <label for="dropzone-file"
                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                            upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    @if ($photo)<p>                        
                        <img class="h-40" src="{{ $photo->temporaryUrl() }}">
                    </p>@endif
                </div>
                <input wire:model="photo" id="dropzone-file" type="file" class="hidden" />
            </label>
        </div>
        @error('photo') <div class="bg-red-300 text-sm my-2 text-white p-2 rounded">{{ $message }}</div> @enderror
        <button class="py-2 px-3 bg-blue-500 rounded-md text-white mt-2">آپلود پیوست</button>
    </form>
    <hr/>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                       نام فایل
                    </th>
                    
                    <th scope="col" class="px-6 py-3">
                        <x-icons.setting />
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->get_attaches() as $attach)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            
                                {{ $attach->name }}
                           
                        </th>
                       
                        
                        <td class="px-6 py-4">
                            <a target="blank" href="{{asset('storage/attaches').'/'.$attach->url_path}}" class="text-blue-400 hover:text-blue-700" >
                                <x-icons.attach />
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $this->get_attaches()->links() }}
        </div>
    </div>

</x-filament-panels::page>

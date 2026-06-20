<x-filament-panels::page>
    <div class="container mx-auto shadow-lg rounded-lg">
        
        {{-- <div class="px-5 py-5 flex justify-between items-center bg-white border-b-2">
          <div class="font-semibold text-2xl">گفتگو</div>     
          
        </div> --}}
        
        <div class="flex flex-row justify-between bg-white">
          
          <div class="flex flex-col w-2/5 border-r-2 overflow-y-auto">
            
            <div class="border-b-2 py-4 px-2">
              <input
                wire:model="search"
                
                type="text"
                placeholder="search chatting"
                class="py-2 px-2 border-2 border-gray-200 rounded-2xl w-full"
              />
            </div>
    
            @foreach($this->getCustomers() as $customer)
            <div wire:click="chat({{$customer->id}})"
            class="flex flex-row py-4 px-2 justify-center items-center border-b-2"  >
              <div class="w-1/4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>            
              </div>
              @if($customer->id == $outgoing)
              <div class="w-full text-blue-400">
              @else
              <div class="w-full">
              @endif
                <div class="text-lg font-semibold">{{$customer->name}}</div>
                <span class="text-gray-500">{{$customer->email}}</span>
              </div>          
            </div>
            @endforeach
            
          </div>
          
          <div class="w-full px-5 flex flex-col justify-between">
            <div class="flex flex-col mt-5 bg-gray-100 p-2">
              @if(count($this->getMessages()) > 0)
              @foreach($this->getMessages() as $message)
              @if($message->user_to_customer)
              <div class="flex justify-end mb-4">
                <div class="msg" >
                  {{$message['msg']}}
                </div>
                <div>{{$incoming_name}}</div>
                
              </div>
              @else
              <div class="flex justify-start mb-4">
                <div>{{$outgoing_name}}</div>
                <div
                  class="ml-2 py-3 px-4 bg-gray-400 rounded-bl-3xl rounded-tr-3xl rounded-tl-3xl text-white"
                >
                {{$message['msg']}}
                </div>
              </div>
              @endif
                
              @endforeach
              @endif       
              
             
            </div>
            <div class="py-5">
              <input type="hidden" wire:model="outgoing" />
              <input type="hidden" wire:model="incoming" />
              <input
              wire:keydown.enter="saveMsg"
                wire:model="msg"
                class="w-full bg-gray-300 py-5 px-3 rounded-xl"
                type="text"
                placeholder="type your message here..."
              />
            </div>
          </div>   
          
        </div>
        <div wire:poll="$this->getMessages()">
          
        </div>
    </div>
</x-filament-panels::page>

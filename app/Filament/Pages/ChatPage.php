<?php

namespace App\Filament\Pages;

use App\Models\Message;
use App\Models\Customer;
use Filament\Pages\Page;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class ChatPage extends Page
{
    use HasPageShield;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.chat-page';

    protected static ?string $navigationLabel = 'گفتگو';
    protected static ?string $title = 'گفتگو';
    protected static ?string $navigationGroup = 'گفتگو و پیامک';
    protected static ?int $navigationSort = 27;   

    public $search;
    public $customers;
    public $messages=[];
    public $outgoing=null;
    public $outgoing_name=null;
    public $incoming=null;
    public $incoming_name=null;
    public $msg=null;  

    #[Computed]
    public function getCustomers (){
        return Customer::where('name','like',"%".$this->search."%")        
        ->take(5)->get();
    }

    #[Computed]
    public function getMessages (){
        return Message::where('user_msg_id',Auth::id())
        ->where('customer_msg_id',$this->outgoing)
        ->orderBy('id')->get();
    }

    public function chat($customer_id){
        $this->incoming=Auth::id();
        $this->incoming_name=Auth::user()->name;
        $this->outgoing=$customer_id;
        $this->outgoing_name=Customer::find($customer_id)->name;
        
       
        
    }
    public function saveMsg(){
        Message::create([
            'user_msg_id'=>$this->incoming,
            'customer_msg_id'=>$this->outgoing,
            'msg'=>$this->msg,
            'user_to_customer'=>true
        ]);
        $this->msg=null;       

                 
    }

    
}

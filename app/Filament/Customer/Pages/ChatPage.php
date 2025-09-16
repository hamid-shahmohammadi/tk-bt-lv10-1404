<?php

namespace App\Filament\Customer\Pages;

use App\Models\User;
use App\Models\Message;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class ChatPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.customer.pages.chat-page';
    protected static ?string $navigationLabel = 'گفتگو';
    protected static ?string $title = 'گفتگو';
    protected static ?string $navigationGroup = 'گفتگو';
    protected static ?int $navigationSort = 4;

    public $search;
    public $customers;
    public $messages=[];
    public $outgoing=null;
    public $outgoing_name=null;
    public $incoming=null;
    public $incoming_name=null;
    public $msg=null;

    #[Computed]
    public function getUsers (){
        return User::where('name','like',"%".$this->search."%")
        ->take(5)->get();
    }

    #[Computed]
    public function getMessages (){
        return Message::where('customer_msg_id',Auth::id())
        ->where('user_msg_id',$this->outgoing)
        ->orderBy('id')->get();

    }

    public function chat($user_id){
        $this->incoming=Auth::id();
        $this->incoming_name=Auth::user()->name;
        $this->outgoing=$user_id;
        $this->outgoing_name=User::find($user_id)->name;



    }
    public function saveMsg(){
        Message::create([
            'user_msg_id'=>$this->incoming,
            'customer_msg_id'=>$this->outgoing,
            'msg'=>$this->msg,
            'user_to_customer'=>false
        ]);
        $this->msg=null;


    }
}

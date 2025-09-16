<?php

namespace App\Filament\Customer\Pages;

use Filament\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerChangePassPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.customer.pages.customer-change-pass-page';
    protected static ?string $navigationLabel = 'تغییر کلمه عبور';
    protected static ?string $title = 'تغییر کلمه عبور';
    protected static ?string $navigationGroup = 'تنظیمات';
    protected static ?int $navigationSort = 3;

    public $current_pass;
    public $new_pass;
    public $repeat_pass;
    public $alert;

    protected $rules = [
        'new_pass' => 'required|min:6',
    ];

    protected $messages = [
        'new_pass.required' => 'فیلد کلمه عبور اجباری می باشد',
        'new_pass.min' => 'کلمه عبور حداقل 6 کاراکتر باشد',
    ];

    public function updatePass(Request $request)
    {
        $this->validate();
        $user = Auth::user();
        if (Hash::check($this->current_pass, $user->password)) {

            if($this->new_pass==$this->repeat_pass){
                $user->password = Hash::make($this->new_pass);
                if($user->save()){
                    $this->alert="کلمه عبور با موفقیت آپدیت گردید";
                }
            }else{
                $this->alert="آپدیت کلمه عبور با مشکل مواجه شد";
            }
        }else{
            $this->alert="آپدیت کلمه عبور با مشکل مواجه شد";
        }
    }
}

<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\SmsConfig;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class SmsConfigPage extends Page
{
    use HasPageShield;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.sms-config-page';

    protected static ?string $navigationLabel = 'تنظیمات پیامک';
    protected static ?string $title = 'تنظیمات پیامک';
    protected static ?string $navigationGroup = 'گفتگو و پیامک';
    protected static ?int $navigationSort = 27; 

    public $username;
    public $password;
    public $url;
    public $from;
    public $happy_birthday;
    public $happy_birthday_massage;
    public $alert=null;

    public function mount(){
        $this->alert=null;
        $sms_Conf=SmsConfig::first();

        $this->username=$sms_Conf->username;
        $this->password=$sms_Conf->password;
        $this->url=$sms_Conf->url;
        $this->from=$sms_Conf->from;
        $this->happy_birthday=$sms_Conf->happy_birthday;
        $this->happy_birthday_massage=$sms_Conf->happy_birthday_massage;
    }

    public function submit (){
        $sms_Conf=SmsConfig::first();

        $sms_Conf->username=$this->username;
        $sms_Conf->password=$this->password;
        $sms_Conf->url=$this->url;
        $sms_Conf->from=$this->from;
        $sms_Conf->happy_birthday=$this->happy_birthday;
        $sms_Conf->happy_birthday_massage=$this->happy_birthday_massage;

        if($sms_Conf->save()){
            $this->alert="اطلاعات با موفقیت ثبت شد";
        }else{
            $this->alert="اطلاعات با مشکل مواجه شد";
        }
    }
}

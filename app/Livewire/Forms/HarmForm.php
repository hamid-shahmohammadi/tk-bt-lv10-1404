<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class HarmForm extends Form
{
    public $id;
    
    #[Validate('required',message: 'فیلد بیمار اجباری می باشد')]
    public $sick;

    #[Validate('required',message: 'فیلد صورت حساب اجباری می باشد')]
    public $billing_date;

    public $billing_time;
    public $description;

    #[Validate('required',message: 'فیلد مبلغ هزینه اجباری می باشد')]
    public $cost;
    public $cost_submit;

    #[Validate('required',message: 'فیلد تعهدات قرارداد اجباری می باشد')]
    public $harm_type_id;

    public $user_id;

    #[Validate('required',message: 'فیلد وضعیت پرداخت اجباری می باشد')]
    public $payment_status_id;

    public $customer_id;
    public $depend_id;

    #[Validate('required',message: 'فیلد قراداد اجباری می باشد')]
    public $contract_id;

    public $doctor_approval;
    
    public $franchise;
    public $prepayment;



}

<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\HarmType;
use Livewire\WithPagination;
use App\Models\PaymentStatus;
use App\Models\ContractDetail;
use App\Livewire\Forms\HarmForm;
use App\Models\Harm as HarmModel;
use Livewire\Attributes\Computed;
use Morilog\Jalali\CalendarUtils;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\CustomerResource;

class Harm extends Page
{
    use WithPagination;

    protected static ?string $title = 'خسارات';
    protected static ?string $breadcrumb = 'خسارات';


    protected static string $resource = CustomerResource::class;

    protected static string $view = 'filament.resources.customer-resource.pages.harm';
    public HarmForm $form;
    public $harms;
    public $customer;
    public $customer_id;
    public $depends;
    public $harmTypes;
    public $paymentStatus;
    public $contracts;
    public $message = null;
    public $showDropdown;
    public bool $editModalHarm = false;
    public $cost_sum_type = null;
    public $harm_type_name_remind = null;
    public bool $modalReminder = false;

    public $cd_cost = null;


    #[Computed]
    public function get_harms()
    {
        return HarmModel::where('customer_id', $this->customer_id)->latest()->paginate();
    }

    public function mount($record): void
    {
        static::authorizeResourceAccess();
        $this->customer_id = $record;
        $this->customer = Customer::find($record);
        $this->depends = $this->customer->depends;
        $this->harmTypes = HarmType::all();
        $this->paymentStatus = PaymentStatus::all();
        $contracts = Auth::user()->contracts;
        // dd($contracts);
        // $contracts=array_map('intval', json_decode($contracts, true));
        $this->contracts = Contract::whereIn('id', $contracts)->get();
    }

    public function storeSick()
    {
        $this->validate();
        $sick_arr = explode("-", $this->form->sick);
        if (isset($sick_arr[1])) {
            $depend = $sick_arr[1];
            $customer = $sick_arr[0];
        } else {
            $depend = null;
            $customer = $sick_arr[0];
        }
        $b_date = explode("/", $this->form->billing_date);
        $bd = CalendarUtils::toGregorian($b_date[0], $b_date[1], $b_date[2]);
        $harm = new HarmModel();
        $harm->billing_date = $this->form->billing_date;
        $harm->billing_time = strtotime(implode("-", $bd));
        $harm->customer_id = $customer;
        $harm->depend_id = $depend;
        $harm->description = $this->form->description;
        $harm->cost = $this->form->cost;
        $harm->cost_submit = $this->form->cost_submit;
        $harm->harm_type_id = $this->form->harm_type_id;
        $harm->user_id = Auth::id();
        $harm->payment_status_id = $this->form->payment_status_id;
        $harm->contract_id = $this->form->contract_id;
        $harm->franchise = $this->form->franchise;
        $harm->prepayment = $this->form->prepayment;
        if ($this->checkCostCeiling($harm->contract_id, $harm->harm_type_id, $harm->cost, $harm->customer_id, $harm->depend_id, $this->form->cost_submit)) {
            if ($harm->save()) {
                $this->message = 'خسارت با موفقیت ثبت گردید';
                $this->showDropdown = false;
            }
        } else {
            $this->message = 'سقف هزینه از تعهد بیشتر است';
        }
    }
    public function setFranchise()
    {
        if (isset($this->form->franchise) && !empty($this->form->franchise) && isset($this->form->cost)) {
            $this->form->cost_submit = $this->form->cost - (($this->form->franchise * $this->form->cost) / 100);
        }
    }
    public function checkCostCeiling($contract_id, $ht_id, $harm_cost, $customer_id, $depend_id, $cost_submit_now)
    {
        $cd = ContractDetail::where('contract_id', $contract_id)
            ->where('harm_type_id', $ht_id)->first();
        if ($depend_id) {
            $harm_cost_sum = HarmModel::where('depend_id', $depend_id)->where('harm_type_id', $ht_id)->sum('cost_submit');
            $harm_cost_sum = $harm_cost_sum + $cost_submit_now;
        } else {
            $harm_cost_sum = HarmModel::whereNull('depend_id')->where('customer_id', $customer_id)->where('harm_type_id', $ht_id)->sum('cost_submit');
            $harm_cost_sum = $harm_cost_sum + $cost_submit_now;
        }
        if (isset($cd)) {
            // dd($cd->cost,$harm_cost_sum);
            if ($cd->cost >= (int) $harm_cost_sum) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
    public function resetMessage()
    {
        $this->message = null;
        $this->form->reset();
    }
    public function deleteHarmFunc($harm_id)
    {
        HarmModel::destroy($harm_id);
    }
    public function editHarmFunc($harm_id)
    {
        // dd($harm);
        $harm = HarmModel::find($harm_id)->toArray();
        // dd($harm);
        $this->editModalHarm = true;
        if (isset($harm['depend_id'])) {
            $arr = array($harm['customer_id'], $harm['depend_id']);
            $this->form->sick = implode('-', $arr);
        } else {
            $this->form->sick = $harm['customer_id'];
        }

        $this->form->harm_type_id = $harm['harm_type_id'];
        $this->form->billing_date = $harm['billing_date'];
        $this->form->billing_time = $harm["billing_time"];
        $this->form->description = $harm["description"];
        $this->form->cost = $harm["cost"];
        $this->form->cost_submit = $harm["cost_submit"];
        $this->form->user_id = $harm["user_id"];
        $this->form->payment_status_id = $harm["payment_status_id"];
        $this->form->customer_id = $harm["customer_id"];
        $this->form->depend_id = $harm["depend_id"];
        $this->form->contract_id = $harm["contract_id"];
        $this->form->doctor_approval = $harm["doctor_approval"];
        $this->form->franchise = $harm["franchise"];
        $this->form->prepayment = $harm["prepayment"];
        $this->form->id = $harm["id"];

    }
    public function editHarm()
    {
        $this->validate();
        $harm = HarmModel::find($this->form->id);

        $sick_arr = explode("-", $this->form->sick);
        if (isset($sick_arr[1])) {
            $depend = $sick_arr[1];
            $customer = $sick_arr[0];
        } else {
            $depend = null;
            $customer = $sick_arr[0];
        }
        $b_date = explode("/", $this->form->billing_date);
        $bd = CalendarUtils::toGregorian($b_date[0], $b_date[1], $b_date[2]);
        $harm->billing_date = $this->form->billing_date;
        $harm->billing_time = strtotime(implode("-", $bd));
        $harm->customer_id = $customer;
        $harm->depend_id = $depend;
        $harm->description = $this->form->description;
        $harm->cost = $this->form->cost;
        $harm->cost_submit = $this->form->cost_submit;
        $harm->harm_type_id = $this->form->harm_type_id;
        $harm->user_id = Auth::id();
        $harm->payment_status_id = $this->form->payment_status_id;
        $harm->contract_id = $this->form->contract_id;
        $harm->franchise = $this->form->franchise;
        $harm->prepayment = $this->form->prepayment;
        if ($this->checkCostCeilingEdit($harm->contract_id, $harm->harm_type_id, $harm->cost, $harm->customer_id, $harm->depend_id, $harm->id)) {
            if ($harm->save()) {
                $this->message = 'ویرایش خسارت با موفقیت ثبت گردید';
                $this->editModalHarm = false;
            }
        } else {
            $this->message = 'سقف هزینه از تعهد بیشتر است';
        }
    }
    public function checkCostCeilingEdit($contract_id, $ht_id, $harm_cost, $customer_id, $depend_id, $harm_id)
    {
        $cd = ContractDetail::where('contract_id', $contract_id)
            ->where('harm_type_id', $ht_id)->first();
        if ($depend_id) {
            $harm_cost_sum = HarmModel::where('depend_id', $depend_id)
                ->where('id', '!=', $harm_id)
                ->where('harm_type_id', $ht_id)->sum('cost');
        } else {
            $harm_cost_sum = HarmModel::whereNull('depend_id')
                ->where('id', '!=', $harm_id)
                ->where('customer_id', $customer_id)
                ->where('harm_type_id', $ht_id)->sum('cost');
        }
        if (isset($cd)) {
            if ($cd->cost > (int) $harm_cost_sum) {
                return true;
            }
        } else {
            return true;
        }
    }

    public function showRemindFunc($harm_id)
    {
        // dd($harm_id);
        $this->modalReminder = true;
        $harm = HarmModel::find($harm_id);

        $cd = ContractDetail::where('contract_id', $harm->contract_id)
            ->where('harm_type_id', $harm->harm_type_id)->first();

        $this->harm_type_name_remind = HarmType::find($harm->harm_type_id)->name;

        if ($cd) {
            $this->cd_cost = $cd->cost;
            if ($harm->depend_id) {
                $this->cost_sum_type = HarmModel::where('depend_id', $harm->depend_id)
                    ->where('harm_type_id', $harm->harm_type_id)->sum('cost');
                dd($harm->depend_id, $harm->harm_type_id, $this->cost_sum_type);
            } else {
                $this->cost_sum_type = HarmModel::where('customer_id', $harm->customer_id)
                    ->whereNull('depend_id')
                    ->where('harm_type_id', $harm->harm_type_id)->sum('cost');
            }
        }



    }
}

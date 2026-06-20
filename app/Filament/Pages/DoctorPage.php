<?php

namespace App\Filament\Pages;

use App\Models\Harm;
use Filament\Pages\Page;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Morilog\Jalali\CalendarUtils;
use Illuminate\Support\Facades\DB;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class DoctorPage extends Page
{
    use HasPageShield, WithPagination;
    
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string $view = 'filament.pages.doctor-page';

    protected static ?string $title = 'کارتابل پزشکان';
    protected static ?string $breadcrumb = 'کارتابل پزشکان';
    protected static ?string $navigationGroup = 'اطلاعات بیمه شدگان';
    protected static ?int $navigationSort = 2;

    public $start_date = null;
    public $end_date = null;
    public $notapprove = null;
    public $selectedRoles = [];
    public $selectAllCheckbox = null;
    public $collectHarm = null;


    #[On('search')]
    #[Computed]
    public function harms()
    {
        $query = Harm::query();
        if ($this->notapprove) {
            $query->whereNull('doctor_approval');
        }
        if ($this->start_date && $this->end_date) {
            $sa_date = explode("/", $this->start_date);
            $ea_date = explode("/", $this->end_date);
            $sd = CalendarUtils::toGregorian($sa_date[0], $sa_date[1], $sa_date[2]);
            $sdt = strtotime(implode("-", $sd));
            $ed = CalendarUtils::toGregorian($ea_date[0], $ea_date[1], $ea_date[2]);
            $edt = strtotime(implode("-", $ed));
            $query->with('customer', 'depend', 'harmtype', 'paymentstatus')
                ->where(DB::raw('UNIX_TIMESTAMP(created_at)'), '>=', $sdt - 42800)
                ->where(DB::raw('UNIX_TIMESTAMP(created_at)'), '<=', $edt + 42800);
        } else {
            $query->with('customer', 'depend', 'harmtype', 'paymentstatus');
        }
        $data = $query->paginate();
        $this->collectHarm = collect($data)['data'];
        $this->collectHarm =collect($this->collectHarm)->pluck('id')->unique()->toArray();
        
        return $query->paginate();
    }
    public function search()
    {
        $this->dispatch('search');
    }

    public function approve($harm_id)
    {
        $harm = Harm::find($harm_id);
        if ($harm->doctor_approval) {
            $harm->doctor_approval = null;
        } else {
            $harm->doctor_approval = 1;
        }

        if ($harm->save())
            $this->dispatch('search');
    }

    public function approveSelect()
    {
        dd($this->selectedRoles);
        Harm::whereIn('id', $this->selectedRoles)->update([
            'doctor_approval' => 1
        ]);
    }
    public function selectAll()
    {
        if ($this->selectAllCheckbox) {
            $this->selectedRoles = $this->collectHarm;
        } else {
            $this->selectedRoles = null;
        }
    }
}

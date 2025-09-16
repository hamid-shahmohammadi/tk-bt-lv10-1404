<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Models\Harm;
use App\Models\Attach;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\CustomerResource;

class HarmImage extends Page
{
    use WithFileUploads;
    use WithPagination;
    
    public $photo;
    public $harm;
    public $flash;

    protected static string $resource = CustomerResource::class;

    protected static ?string $title = 'پیوست خسارت';
    protected static ?string $breadcrumb = 'پیوست خسارت';

    protected static string $view = 'filament.resources.customer-resource.pages.harm-image';

    public function mount($record): void
    {
        $this->harm=Harm::find($record);
        static::authorizeResourceAccess();
        
    }
    #[Computed]
    public function get_attaches(){
        return $this->harm->attachs()->paginate();        
    }

    public function save()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ],[
            'photo.max' => 'حجم فایل کمتر از یک مگابایت باشد',
        ]);        
        $name=$this->photo->getClientOriginalName();
        $size=$this->photo->getSize();
        $mime=$this->photo->getClientOriginalExtension();      

        $path=$this->photo->store('public/attaches');
        
        $path=basename($path);
        
        $this->harm->attachs()->create([
            'name'=>$name,
            'url_path'=>$path,
            'size'=>$size,
            'mime'=>$mime,
        ]);
        
        // Attach::create([
        //     'name'=>$name,
        //     'url_path'=>$path,
        //     'size'=>$size,
        //     'mime'=>$mime,
        //     'attachable_type'=>'App\Models\Harm',
        //     'attachable_id'=>$this->harm_id
        // ]);
        $this->flash="آپلود با موفقیت انجام شد";
 
   
    }
}

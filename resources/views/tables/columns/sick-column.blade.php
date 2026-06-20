<div>
    @php
    if($getRecord()->depend_id){
        echo \App\Models\Depend::find($getRecord()->depend_id)->name.' '.\App\Models\Depend::find($getRecord()->depend_id)->family;
    }else{
        echo \App\Models\Customer::find($getRecord()->customer_id)->name.' '.\App\Models\Customer::find($getRecord()->customer_id)->family;
    }

    @endphp

</div>

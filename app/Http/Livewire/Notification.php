<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Notification extends Component
{
    protected  $listeners = ['notificationForm' => 'CheckNotify'];

    public function CheckNotify($data){
        session()->flash('data', $data);
    }

    public function render()
    {
        return view('livewire.notification');
    }
}

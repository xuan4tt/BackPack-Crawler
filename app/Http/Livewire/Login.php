<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Login extends Component
{
    public  $password;
    public  $email;

    protected  function rules()
    {
        return [
            'email' => 'required|min:6',
            'password' => 'required'
        ];
    }

    protected  function messages(){
        return [
            'email.required' => 'Vui lòng điền email',
            'email.min' => 'Tối thiểu 6 ký tự',
            'password.required' => 'Vui lòng điền mật khẩu',
        ];

    }

    public function submit(){
        $this->validate();
        dump($this->email);
        dump($this->password);
    }

    public function render()
    {
        return view('livewire.login');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use Livewire\Component;

class ComponentButtonCart extends Component
{
    public $user_id;

    protected $listeners = ['updateCart' => 'render'];

    public function mount()
    {
        $this->user_id = auth()->user()->id;
    }

    public function render()
    {
        $carts = Cart::where('user_id', $this->user_id)->where('status', Cart::Active)->get();
        return view('livewire.component-button-cart', compact('carts'));
    }
}

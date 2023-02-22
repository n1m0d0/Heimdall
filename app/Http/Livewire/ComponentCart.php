<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentCart extends Component
{
    use WithPagination;
    use WireToast;

    public $user_id;

    public $cart_id;
    public $selected;

    public $deleteModal;
    public $buyModal;

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->user_id = auth()->user()->id;
    }

    public function render()
    {
        $carts = Cart::where('user_id', $this->user_id)->where('status', Cart::Active)->paginate(7);
        return view('livewire.component-cart', compact('carts'));
    }

    public function modalBuy($id)
    {
        $this->cart_id = $id;
        $product_id = Cart::find($id)->product->id;
        $this->selected = Product::find($product_id);
        $this->buyModal = true;
    }

    public function buy()
    {
        $cart = Cart::find($this->cart_id);
        $cart->status = Cart::Finalized;
        $cart->save();

        $this->clear();
        $this->buyModal = false;

        toast()
            ->success('Se compro correctamente')
            ->push();

        $this->emit('updateCart');
    }

    public function modalDelete($id)
    {
        $this->cart_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $cart = Cart::find($this->cart_id);
        $cart->status = Cart::Inactive;
        $cart->save();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();

        $this->emit('updateCart');
    }

    public function clear()
    {
        $this->reset(['cart_id']);
    }
}

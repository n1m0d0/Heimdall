<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentCatalogue extends Component
{
    use WithPagination;
    use WireToast;

    public $categories;

    public $selected;
    public $user_id;
    public $amount;

    public $addModal;

    public function mount()
    {
        $this->categories = Category::where('status', Category::Active)->whereNull('category_id')->get();
        $this->user_id = auth()->user()->id;
        $this->addModal = false;
    }

    public function render()
    {
        $products = Product::where('status', Product::Published)->paginate(12);
        return view('livewire.component-catalogue', compact('products'));
    }

    public function modalAdd($id)
    {
        $this->selected = Product::find($id);
        $this->addModal = true;
    }

    public function addProduct()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $cart = new Cart();
        $cart->user_id = $this->user_id;
        $cart->product_id = $this->selected->id;
        $cart->amount = $this->amount;
        $cart->price = $this->selected->price;
        $cart->save();

        $this->clear();
        $this->addModal = false;

        toast()
            ->success('Se guardo correctamente')
            ->push();

        $this->emit('updateCart');
    }

    public function clear()
    {
        $this->reset(['selected', 'amount']);
    }
}

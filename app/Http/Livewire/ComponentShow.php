<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentShow extends Component
{
    use WithPagination;
    use WireToast;

    public $category;

    public $aux; //auxiliar de productos
    public $selected;
    public $user_id;
    public $amount;

    public $addModal;

    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->addModal = false;
        $this->aux = [];

        $items = Product::where('category_id', $this->category->id)->where('status', Product::Published)->get();

        foreach ($items as $item) {
            $this->aux[] = [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'photo' => $item->photo,
                'price' => $item->price
            ];
        }

        foreach ($this->category->childrenCategories as $childrenCategories) {
            $items = Product::where('category_id', $childrenCategories->id)->where('status', Product::Published)->get();

            foreach ($items as $item) {
                $this->aux[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'photo' => $item->photo,
                    'price' => $item->price
                ];
            }
        }
    }

    public function render()
    {
        $perPage = 12;

        $collection = collect($this->aux);

        $items = $collection->forPage($this->page, $perPage);

        $products = new LengthAwarePaginator($items, $collection->count(), $perPage, $this->page);
        return view('livewire.component-show', compact('products'));
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

<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentProduct extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WireToast;

    public $activity;
    public $iteration;
    public $search;

    public $product_id;
    public $category_id;
    public $name;
    public $description;
    public $photo;
    public $price;
    public $photoBefore;

    public $categories;

    public $deleteModal;

    //input Search
    public $inputSearchCategory;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'category_id' => 'required',
        'name' => 'required|max:200',
        'description' => 'required|max:1000',
        'photo' => 'required|mimes:jpg,bmp,png,pdf|max:5120',
        'price' => 'required|decimal:0,2',
    ];

    public function mount()
    {
        $this->activity = 'create';
        $this->iteration = rand(0, 999);
        $this->search = "";
        $this->product_id = null;
        $this->deleteModal = false;
        $this->categories = Category::where('status', Category::Active)->get();
    }

    public function render()
    {
        $Query = Product::query();

        if ($this->search != null) {
            $this->updatingSearch();
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }

        $QueryCategories = Category::query();
        if($this->inputSearchCategory){
    		$QueryCategories = $QueryCategories->where('name', 'LIKE' , '%'.$this->inputSearchCategory.'%');
    	}

        $searchCategories = $QueryCategories->where('status', Category::Active)->get();
        $products = $Query->where('status', '!=', Product::Inactive)->orderBy('id', 'DESC')->paginate(7);
        return view('livewire.component-product', compact('products', 'searchCategories'));
    }

    public function store()
    {
        $this->validate();

        $product = new Product();
        $product->category_id = $this->category_id;
        $product->name = $this->name;
        $product->description = $this->description;
        $product->photo = $this->photo->store('public');
        $product->price = $this->price;
        $product->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->product_id = $id;

        $product = Product::find($id);

        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->description = $product->description;
        $this->photoBefore = $product->photo;
        $this->price = $product->price;

        $this->activity = "edit";
    }

    public function update()
    {
        $product = Product::find($this->product_id);

        if ($this->photo != null) {
            $this->validate();
            Storage::delete($product->photo);
            $product->category_id = $this->category_id;
            $product->name = $this->name;
            $product->description = $this->description;
            $product->photo = $this->photo->store('public');
            $product->price = $this->price;
            $product->save();
        } else {
            $this->validate([
                'name' => 'required|max:200',
                'description' => 'required|max:1000',
                'price' => 'required|decimal:2',
            ]);
            $product->category_id = $this->category_id;
            $product->name = $this->name;
            $product->description = $this->description;
            $product->price = $this->price;
            $product->save();
        }

        $this->activity = "create";
        $this->clear();

        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->product_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $product = Product::find($this->product_id);
        $product->product_id = null;
        $product->status = Product::Inactive;
        $product->save();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function publish($id)
    {
        $product = Product::find($id);
        $product->status = Product::Published;
        $product->save();

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se publicado correctamente')
            ->push();
    }

    //select Category
    public function selectCategory($id)
    {
        $this->category_id = $id;
        $this->inputSearchCategory = '';
    }

    public function clear()
    {
        $this->reset(['category_id', 'name', 'description', 'photo', 'price', 'product_id']);
        $this->iteration++;
        $this->activity = "create";
    }

    public function resetSearch()
    {
        $this->reset(['search']);
        $this->updatingSearch();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Usernotnull\Toast\Concerns\WireToast;

class ComponentCategory extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WireToast;

    public $activity;
    public $iteration;
    public $search;

    public $category_id;
    public $name;
    public $description;
    public $photo;
    public $photoBefore;
    public $parent_id;

    public $parents;

    public $deleteModal;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'parent_id' => 'nullable',
        'name' => 'required|max:200',
        'description' => 'required|max:1000',
        'photo' => 'required|mimes:jpg,bmp,png,pdf|max:5120',
    ];

    public function mount()
    {
        $this->activity = 'create';
        $this->iteration = rand(0, 999);
        $this->search = "";
        $this->category_id = null;
        $this->parent_id = null;
        $this->deleteModal = false;
    }
    
    public function render()
    {
        $Query = Category::query();

        if ($this->search != null) {
            $this->updatingSearch();            
            $Query = $Query->where('name', 'like', '%' . $this->search . '%');
        }

        $categories = $Query->where('status', Category::Active)->orderBy('id', 'DESC')->paginate(7);
        $this->parents = Category::where('status', Category::Active)->get();
        return view('livewire.component-category', compact('categories'));
    }

    public function store()
    {
        $this->validate();

        $category = new Category();
        $category->category_id = $this->parent_id;
        $category->name = $this->name;
        $category->description = $this->description;
        $category->photo = $this->photo->store('public');
        $category->save();

        $this->clear();

        toast()
            ->success('Se guardo correctamente')
            ->push();
    }

    public function edit($id)
    {
        $this->clear();

        $this->category_id = $id;
        
        $category = Category::find($id);
        
        $this->parent_id = $category->category_id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->photoBefore = $category->photo;

        $this->activity = "edit";
    }

    public function update()
    {
        $category = Category::find($this->category_id);

        if ($this->photo != null) {
            $this->validate();
            Storage::delete($category->photo);
            $category->category_id = $this->parent_id;
            $category->name = $this->name;
            $category->description = $this->description;
            $category->photo = $this->photo->store('public');
            $category->save();
        } else {
            $this->validate([
                'name' => 'required|max:200',
                'description' => 'required|max:1000',
            ]);
            $category->category_id = $this->parent_id;
            $category->name = $this->name;
            $category->description = $this->description;
            $category->save();
        }

        $this->activity = "create";
        $this->clear();

        toast()
            ->success('Se actualizo correctamente')
            ->push();
    }

    public function modalDelete($id)
    {
        $this->category_id = $id;
        $this->deleteModal = true;
    }

    public function delete()
    {
        $category = Category::find($this->category_id);
        $category->category_id = null;
        $category->status = Category::Inactive;
        $category->save();

        $categories = Category::where('category_id', $this->category_id)->get();
        foreach ($categories as $category)
        {
            $category->category_id = null;
            $category->save();
        }

        $this->clear();
        $this->deleteModal = false;

        toast()
            ->success('Se elimino correctamente')
            ->push();
    }

    public function clear()
    {
        $this->reset(['parent_id', 'name', 'description', 'photo', 'category_id']);
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

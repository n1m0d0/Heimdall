<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;

class ComponentMenu extends Component
{
    public $categories;

    public function mount()
    {
        $this->categories = Category::where('status', Category::Active)->whereNull('category_id')
            ->with('childrenCategories')
            ->get();
    }

    public function render()
    {
        return view('livewire.component-menu');
    }

    public function selected($id)
    {
        $category = Category::find($id);
        dd($category);
    }
}

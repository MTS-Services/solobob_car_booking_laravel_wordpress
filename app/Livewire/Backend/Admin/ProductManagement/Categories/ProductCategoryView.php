<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'livewire.backend.admin.product-management.categories.product-category-view',
        'breadcrumb' => 'livewire.backend.admin.product-management.categories.product-category-view',
        'page_slug' => 'livewire.backend.admin.product-management.categories.product-category-view'
    ]
)]
class ProductCategoryView extends Component
{
        public $category;

    public function mount($id)
    {
        $this->category = Category::withTrashed()
            ->with(['createdBy', 'updatedBy', 'deletedBy'])
            ->findOrFail($id);
    }
    public function render()
    {
        return view('livewire.backend.admin.product-management.categories.product-category-view');
    }
}

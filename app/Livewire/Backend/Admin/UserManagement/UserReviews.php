<?php

namespace App\Livewire\Backend\Admin\UserManagement;

use App\Models\Review;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\WithCachedFiles;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'User Reviews',
        'breadcrumb' => 'User Reviews',
        'page_slug' => 'user-reviews',
    ]
)]
class UserReviews extends Component
{
    public $perPage = 10;

    public function render()
    {
        $reviews = Review::query()
            ->with(['user', 'createdBy', 'updatedBy'])
            ->latest()
            ->paginate($this->perPage);

        $columns = [
            ['key' => 'user_id', 'label' => 'User Name', 'width' => '20%'],
            ['key' => 'title', 'label' => 'Title', 'width' => '30%'],
            
            [
                'key' => 'created_by',
                'label' => 'Created By',
                'width' => '15%',
                'format' => function ($review) {
                    return $review->createdBy?->name ?? 'System';
                }
            ]
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'method' => 'openDetailsModal'],
            ['key' => 'id', 'label' => 'Edit', 'method' => 'openEditModal'],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'openForceDeleteModal'],
        ];

        return view('livewire.backend.admin.user-management.user-reviews', [
            'items' => $reviews,
            'columns' => $columns,
            'actions' => $actions,
        ]);
    }
}

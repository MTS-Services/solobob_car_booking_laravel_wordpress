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

/*************  ✨ Windsurf Command ⭐  *************/
/**
 * Renders the user reviews page.
 *
 * @return \Illuminate\View\View
 */
/*******  2a9a13c0-75bb-491a-8449-96f1c597e8af  *******/
    public function render()
    {
        $reviews = Review::query()
            ->with(['user', 'createdBy', 'updatedBy'])
            ->latest()
            ->paginate($this->perPage);

        $columns = [
            ['key' => 'user.name', 'label' => 'User Name', 'width' => '20%'],
            ['key' => 'title', 'label' => 'Title', 'width' => '30%'],
            
            [
           'key' => 'status',
           'label' => 'Status',
           'width' => '15%',
           'format' => function ($review) {
               return '<span class="badge badge-soft ' . $review->status_color . '">' . $review->status_label . '</span>';
           }

        ],

        [
            'key' => 'created_at',
            'label' => 'Created At',
            'width' => '15%',
            'format' => function ($review) {
                return $review->createdBy?->name ?? 'system';
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


  public $selectedReview;

public function openDetailsModal($id)
{
    $this->selectedReview = Review::with('user')->findOrFail($id);
    $this->dispatch('open-modal', name: 'viewReviewModal');
}

    public function openEditModal($id)
    {
        dd("Edit Review ID:{$id}");
    }
    public function openForceDeleteModal($id)
    {
        dd("delete Review ID:{$id}");
    }
}

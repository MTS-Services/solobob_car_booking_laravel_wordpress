<?php

namespace App\Livewire\Backend\Admin\ProductManagement;

use App\Models\Category;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\FileUpload\FileUploadService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout(
    'app',
    [
        'title' => 'vehicle-product',
        'breadcrumb' => 'vehicle-product',
        'page_slug' => 'vehicle-product'
    ]
)]
class Vehicles extends Component
{
    use WithPagination, WithFileUploads;

    protected FileUploadService $fileUploadService;

    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $showDetailsModal = false;
    public $detailsAdmin = null;
    public $editMode = false;

    // Form fields
    public $owner_id;
    public $category_id;
    public $title = '';
    public $slug = '';
    public $year = '';
    public $color = '';
    public $license_plate = '';
    public $vin = '';
    public $seating_capacity = '';
    public $mileage = '';
    public $description = '';
    public $daily_rate = '';
    public $weekly_rate = '';
    public $monthly_rate = '';
    public $security_deposit = '';
    public $minimum_rental_days = '';
    public $maximum_rental_days = '';
    public $instant_booking = false;
    public $delivery_available = false;
    public $delivery_fee = '';
    public $adminId;
    public $status = Vehicle::STATUS_AVAILABLE;
    public $approval_status = Vehicle::APPROVAL_PENDING;
    public $avatar;
    public $existingAvatar = null;

    protected $queryString = ['search'];

    public function boot(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->reset([
            'owner_id',
            'category_id',
            'title', 
            'slug',
            'year',
            'color',
            'license_plate',
            'vin',
            'seating_capacity',
            'mileage',
            'description',
            'daily_rate',
            'weekly_rate',
            'monthly_rate',
            'security_deposit',
            'minimum_rental_days',
            'maximum_rental_days',
            'instant_booking',
            'delivery_available',
            'delivery_fee',
            'approval_status',
            'status',
            'adminId', 
            'editMode',
            'avatar',
            'existingAvatar'
        ]);
        $this->status = Vehicle::STATUS_AVAILABLE;
        $this->approval_status = Vehicle::APPROVAL_PENDING;
        $this->instant_booking = false;
        $this->delivery_available = false;
        $this->resetValidation();
    }

    public function openCreateModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function openDetailsModal($id)
    {
        $this->detailsAdmin = Vehicle::withTrashed()
            ->with(['category', 'owner', 'createdBy', 'updatedBy', 'deletedBy'])
            ->findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->detailsAdmin = null; 
    }

    public function openEditModal($id)
    {
        $this->resetFields();
        $vehicle = Vehicle::findOrFail($id);

        $this->adminId = $vehicle->id;
        $this->owner_id = $vehicle->owner_id;
        $this->category_id = $vehicle->category_id;
        $this->title = $vehicle->title;
        $this->slug = $vehicle->slug;
        $this->year = $vehicle->year;
        $this->color = $vehicle->color;
        $this->license_plate = $vehicle->license_plate;
        $this->vin = $vehicle->vin;
        $this->seating_capacity = $vehicle->seating_capacity;
        $this->mileage = $vehicle->mileage;
        $this->description = $vehicle->description;
        $this->daily_rate = $vehicle->daily_rate;
        $this->weekly_rate = $vehicle->weekly_rate;
        $this->monthly_rate = $vehicle->monthly_rate;
        $this->security_deposit = $vehicle->security_deposit;
        $this->minimum_rental_days = $vehicle->minimum_rental_days;
        $this->maximum_rental_days = $vehicle->maximum_rental_days;
        $this->instant_booking = $vehicle->instant_booking;
        $this->delivery_available = $vehicle->delivery_available;
        $this->delivery_fee = $vehicle->delivery_fee;
        $this->status = $vehicle->status ?? Vehicle::STATUS_AVAILABLE;
        $this->approval_status = $vehicle->approval_status ?? Vehicle::APPROVAL_PENDING;
        $this->existingAvatar = $vehicle->avatar;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function removeAvatar()
    {
        $this->avatar = null;
        $this->existingAvatar = null;
    }

    public function openDeleteModal($id)
    {
        $this->adminId = $id;
        $this->showDeleteModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetFields();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->adminId = null;
    }

    public function save()
    {
        if ($this->editMode) {
            $this->updateVehicle();
        } else {
            $this->createVehicle();
        }
    }

    protected function createVehicle()
    {
        $this->validate([
            'owner_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:vehicles,slug',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255|unique:vehicles,license_plate',
            'vin' => 'required|string|max:255|unique:vehicles,vin',
            'seating_capacity' => 'required|integer|min:1',
            'mileage' => 'required|numeric|min:0',
            'description' => 'required|string',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'nullable|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'security_deposit' => 'required|numeric|min:0',
            'minimum_rental_days' => 'required|integer|min:1',
            'maximum_rental_days' => 'required|integer|min:1',
            'instant_booking' => 'nullable|boolean',
            'delivery_available' => 'nullable|boolean',
            'delivery_fee' => 'nullable|numeric|min:0',
            'status' => 'required|in:' . implode(',', [Vehicle::STATUS_AVAILABLE, Vehicle::STATUS_RENTED, Vehicle::STATUS_MAINTENANCE, Vehicle::STATUS_INACTIVE]),
            'approval_status' => 'required|in:' . implode(',', [Vehicle::APPROVAL_PENDING, Vehicle::APPROVAL_APPROVED, Vehicle::APPROVAL_REJECTED]),
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = [
            'owner_id' => $this->owner_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'year' => $this->year,
            'color' => $this->color,
            'license_plate' => $this->license_plate,
            'vin' => $this->vin,
            'seating_capacity' => $this->seating_capacity,
            'mileage' => $this->mileage,
            'description' => $this->description,
            'daily_rate' => $this->daily_rate,
            'weekly_rate' => $this->weekly_rate,
            'monthly_rate' => $this->monthly_rate,
            'security_deposit' => $this->security_deposit,
            'minimum_rental_days' => $this->minimum_rental_days,
            'maximum_rental_days' => $this->maximum_rental_days,
            'instant_booking' => $this->instant_booking ?? false,
            'delivery_available' => $this->delivery_available ?? false,
            'delivery_fee' => $this->delivery_fee,
            'approval_status' => $this->approval_status,
            'status' => $this->status,
            'created_by' => user()->id,
        ];

        // Handle avatar upload using service
        if ($this->avatar) {
            $data['avatar'] = $this->fileUploadService->uploadImage(
                file: $this->avatar,
                directory: 'vehicles/avatars',
                width: 800,
                height: 600,
                disk: 'public',
                maintainAspectRatio: true
            );
        }

        Vehicle::create($data);

        session()->flash('message', 'Vehicle created successfully.');
        $this->closeModal();
    }

    protected function updateVehicle()
    {
        $this->validate([
            'owner_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:vehicles,slug,' . $this->adminId,
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255|unique:vehicles,license_plate,' . $this->adminId,
            'vin' => 'required|string|max:255|unique:vehicles,vin,' . $this->adminId,
            'seating_capacity' => 'required|integer|min:1',
            'mileage' => 'required|numeric|min:0',
            'description' => 'required|string',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'nullable|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'security_deposit' => 'required|numeric|min:0',
            'minimum_rental_days' => 'required|integer|min:1',
            'maximum_rental_days' => 'required|integer|min:1',
            'instant_booking' => 'nullable|boolean',
            'delivery_available' => 'nullable|boolean',
            'delivery_fee' => 'nullable|numeric|min:0',
            'status' => 'required|in:' . implode(',', [Vehicle::STATUS_AVAILABLE, Vehicle::STATUS_RENTED, Vehicle::STATUS_MAINTENANCE, Vehicle::STATUS_INACTIVE]),
            'approval_status' => 'required|in:' . implode(',', [Vehicle::APPROVAL_PENDING, Vehicle::APPROVAL_APPROVED, Vehicle::APPROVAL_REJECTED]),
            'avatar' => 'nullable|image|max:2048',
        ]);

        $vehicle = Vehicle::findOrFail($this->adminId);
        
        $updateData = [
            'owner_id' => $this->owner_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'year' => $this->year,
            'color' => $this->color,
            'license_plate' => $this->license_plate,
            'vin' => $this->vin,
            'seating_capacity' => $this->seating_capacity,
            'mileage' => $this->mileage,
            'description' => $this->description,
            'daily_rate' => $this->daily_rate,
            'weekly_rate' => $this->weekly_rate,
            'monthly_rate' => $this->monthly_rate,
            'security_deposit' => $this->security_deposit,
            'minimum_rental_days' => $this->minimum_rental_days,
            'maximum_rental_days' => $this->maximum_rental_days,
            'instant_booking' => $this->instant_booking ?? false,
            'delivery_available' => $this->delivery_available ?? false,
            'delivery_fee' => $this->delivery_fee,
            'status' => $this->status,
            'approval_status' => $this->approval_status,
            'updated_by' => user()->id,
        ];

        // Handle avatar update using service
        if ($this->avatar) {
            $updateData['avatar'] = $this->fileUploadService->updateImage(
                file: $this->avatar,
                oldPath: $vehicle->avatar,
                directory: 'vehicles/avatars',
                width: 800,
                height: 600,
                disk: 'public',
                maintainAspectRatio: true
            );
        } elseif ($this->existingAvatar === null && $vehicle->avatar) {
            // If existing avatar was removed
            $this->fileUploadService->delete($vehicle->avatar, 'public');
            $updateData['avatar'] = null;
        }

        $vehicle->update($updateData);

        session()->flash('message', 'Vehicle updated successfully.');
        $this->closeModal();
    }

    public function delete()
    {
        $vehicle = Vehicle::findOrFail($this->adminId);

        // Update deleted_by before soft deleting
        $vehicle->update(['deleted_by' => user()->id]);
        $vehicle->delete();

        session()->flash('message', 'Vehicle deleted successfully.');
        $this->closeDeleteModal();
    }

    public function render()
    {
        $vehicles = Vehicle::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('license_plate', 'like', '%' . $this->search . '%')
                        ->orWhere('vin', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['category', 'owner', 'createdBy', 'updatedBy'])
            ->latest()
            ->paginate(10);

        return view('livewire.backend.admin.product-management.vehicles', [
            'vehicles' => $vehicles,
            'categories' => Category::where('status', Category::STATUS_ACTIVE)->pluck('name', 'id'),
            'owners' => User::pluck('name', 'id'),
            'statuses' => Vehicle::STATUS,
            'approvalStatuses' => Vehicle::APPROVAL_STATUS,
        ]);
    }
}
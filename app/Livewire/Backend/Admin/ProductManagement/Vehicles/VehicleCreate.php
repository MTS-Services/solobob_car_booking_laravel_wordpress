<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Vehicles;

use App\Models\Category;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Services\FileUpload\FileUploadService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout(
    'app',
    [
        'title' => 'vehicle-create',
        'breadcrumb' => 'vehicle-create',
        'page_slug' => 'vehicle-create'
    ]
)]
class VehicleCreate extends Component
{
    use WithFileUploads;

    protected FileUploadService $fileUploadService;

    // Form fields
    public $owner_id;
    public $category_id;
    public $sort_order = 0;
    public $title = '';
    public $slug = '';
    public $year = '';
    public $color = '';
    public $license_plate = '';
    public $seating_capacity = '';
    public $mileage = '';
    public $description = '';
    public $daily_rate = '';
    public $weekly_rate = '';
    public $monthly_rate = '';
    public $security_deposit = '';
    public $transmission_type = Vehicle::TRANSMISSION_AUTOMATIC;
    public $instant_booking = false;
    public $delivery_available = false;
    public $delivery_fee = '';
    public $status = Vehicle::STATUS_AVAILABLE;
    public array $images = [];
    public $avaters = [];

    public function boot(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function removeAvatar()
    {
        $this->images = [];
    }

  
    public function save()
    {
        $validated = $this->validate([
            'owner_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:vehicles,slug',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255|unique:vehicles,license_plate',
            'seating_capacity' => 'required|integer|min:1',
            'mileage' => 'required|numeric|min:0',
            'description' => 'required|string',
            'weekly_rate' => 'nullable|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'security_deposit' => 'nullable|numeric|min:0',
            'transmission_type' => 'required|in:' . Vehicle::TRANSMISSION_AUTOMATIC . ',' . Vehicle::TRANSMISSION_MANUAL,
            'instant_booking' => 'nullable|boolean',
            'delivery_available' => 'nullable|boolean',
            'delivery_fee' => 'nullable|numeric|min:0',
            'status' => 'required|in:' . implode(',', [
                Vehicle::STATUS_AVAILABLE,
                Vehicle::STATUS_RENTED,
                Vehicle::STATUS_MAINTENANCE,
                Vehicle::STATUS_INACTIVE
            ]),
            'images.*' => 'nullable|image',
            'images' => 'nullable|array', 
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['instant_booking'] = $validated['instant_booking'] ?? false;
        $validated['delivery_available'] = $validated['delivery_available'] ?? false;
        $validated['created_by'] = user()->id;

        // Create vehicle record
        $vehicle = Vehicle::create($validated);

        // Handle multiple image uploads
        if (!empty($this->images)) {
            foreach ($this->images as $index => $image) {
                $path = $this->fileUploadService->uploadImage(
                    file: $image,
                    directory: 'vehicles/images',
                    width: 800,
                    height: 600,
                    disk: 'public',
                    maintainAspectRatio: true
                );

                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'image' => $path,
                    'is_primary' => $index === 0, // first image is primary
                ]);
            }

        }

        session()->flash('message', 'Vehicle created with images successfully.');
        return $this->redirectRoute('admin.pm.vehicle-list');
    }


    public function render()
    {
        return view('livewire.backend.admin.product-management.vehicles.vehicle-create', [
            'categories' => Category::active()->pluck('name', 'id'),
            'owners' => User::pluck('name', 'id'),
            'statuses' => Vehicle::STATUS,
            'transmissions' => Vehicle::getTransmission(),
        ]);
    }
}

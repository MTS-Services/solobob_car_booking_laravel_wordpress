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
        'title' => 'vehicle-edit',
        'breadcrumb' => 'vehicle-edit',
        'page_slug' => 'vehicle-edit'
    ]
)]
class VehicleEdit extends Component
{
    use WithFileUploads;

    protected FileUploadService $fileUploadService;

    public $vehicleId;

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
    public $existingImages = [];
    public $imagesToDelete = []; // Track images marked for deletion

    public function boot(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function mount($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $this->vehicleId = $vehicle->id;
        $this->owner_id = $vehicle->owner_id;
        $this->category_id = $vehicle->category_id;
        $this->sort_order = $vehicle->sort_order ?? 0;
        $this->title = $vehicle->title;
        $this->slug = $vehicle->slug;
        $this->year = $vehicle->year;
        $this->color = $vehicle->color;
        $this->license_plate = $vehicle->license_plate;
        $this->seating_capacity = $vehicle->seating_capacity;
        $this->mileage = $vehicle->mileage;
        $this->description = $vehicle->description;
        $this->daily_rate = $vehicle->daily_rate;
        $this->weekly_rate = $vehicle->weekly_rate;
        $this->monthly_rate = $vehicle->monthly_rate;
        $this->security_deposit = $vehicle->security_deposit;
        $this->transmission_type = $vehicle->transmission_type ?? Vehicle::TRANSMISSION_AUTOMATIC;
        $this->instant_booking = $vehicle->instant_booking;
        $this->delivery_available = $vehicle->delivery_available;
        $this->delivery_fee = $vehicle->delivery_fee;
        $this->status = $vehicle->status ?? Vehicle::STATUS_AVAILABLE;
        
        // Load existing images
        $this->existingImages = $vehicle->images()->get()->toArray();
    }

    public function markImageForDeletion($imageId)
    {
        // Just mark the image for deletion, don't actually delete it yet
        if (!in_array($imageId, $this->imagesToDelete)) {
            $this->imagesToDelete[] = $imageId;
        }
        
        // Remove from existingImages array for UI purposes
        $this->existingImages = array_filter($this->existingImages, function($image) use ($imageId) {
            return $image['id'] != $imageId;
        });
        
        // Re-index array
        $this->existingImages = array_values($this->existingImages);
    }

    public function removeNewImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function save()
    {
        $this->validate([
            'owner_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:vehicles,slug,' . $this->vehicleId,
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255|unique:vehicles,license_plate,' . $this->vehicleId,
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
            'status' => 'required|in:' . implode(',', [Vehicle::STATUS_AVAILABLE, Vehicle::STATUS_RENTED, Vehicle::STATUS_MAINTENANCE, Vehicle::STATUS_INACTIVE]),
            'images.*' => 'nullable|image|max:10240',
            'images' => 'nullable|array',
        ]);

        $vehicle = Vehicle::findOrFail($this->vehicleId);

        $updateData = [
            'owner_id' => $this->owner_id,
            'category_id' => $this->category_id,
            'sort_order' => $this->sort_order ?? 0,
            'title' => $this->title,
            'slug' => $this->slug,
            'year' => $this->year,
            'color' => $this->color,
            'license_plate' => $this->license_plate,
            'seating_capacity' => $this->seating_capacity,
            'mileage' => $this->mileage,
            'description' => $this->description,
            'weekly_rate' => $this->weekly_rate,
            'monthly_rate' => $this->monthly_rate,
            'security_deposit' => $this->security_deposit,
            'transmission_type' => $this->transmission_type,
            'instant_booking' => $this->instant_booking ?? false,
            'delivery_available' => $this->delivery_available ?? false,
            'delivery_fee' => $this->delivery_fee,
            'status' => $this->status,
            'updated_by' => user()->id,
        ];

        $vehicle->update($updateData);

        // NOW delete the marked images (only on form submission)
        if (!empty($this->imagesToDelete)) {
            foreach ($this->imagesToDelete as $imageId) {
                $image = VehicleImage::find($imageId);
                if ($image && $image->vehicle_id == $this->vehicleId) {
                    // Delete file from storage
                    $this->fileUploadService->delete($image->image, 'public');
                    // Delete database record
                    $image->delete();
                }
            }
        }

        // Handle new image uploads
        if (!empty($this->images)) {
            $existingImagesCount = $vehicle->images()->count();
            
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
                    'is_primary' => ($existingImagesCount === 0 && $index === 0),
                ]);
            }
        }

        session()->flash('message', 'Vehicle updated successfully.');
        return $this->redirect(route('admin.pm.vehicle-list'), navigate: true);
    }

    public function render()
    {
        return view('livewire.backend.admin.product-management.vehicles.vehicle-edit', [
            'categories' => Category::active()->pluck('name', 'id'),
            'owners' => User::pluck('name', 'id'),
            'statuses' => Vehicle::getStatus(),
            'transmissions' => Vehicle::getTransmission(),
        ]);
    }
}
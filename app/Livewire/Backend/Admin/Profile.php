<?php

namespace App\Livewire\Backend\Admin;

use App\Models\Addresse;
use App\Models\User;
use App\Services\FileUpload\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout(
    'app',
    [
        'title' => 'admin.profile',
        'breadcrumb' => 'admin.profile',
        'page_slug' => 'admin-profile'
    ]
)]
class Profile extends Component
{
    use WithFileUploads;

    public $profile;
    public $newImage;
    public $name;
    public $email;
    public $number;
    public $date_of_birth;
    public $address;
    public $city;
    public $state;
    public $postal_code;
    public $is_default;

    protected $fileUploadService;

    // Inject the service via boot method
    public function boot(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function mount()
    {
        $this->profile = User::findOrFail(user()->id);
        $this->profile->load('addresses');
        $this->name = $this->profile->name;
        $this->email = $this->profile->email;
        $this->number = $this->profile->number;
        $this->date_of_birth = $this->profile->date_of_birth;
        $this->address = $this->profile?->addresses?->first()?->address ?? '';
        $this->city = $this->profile?->addresses?->first()?->city ?? '';
        $this->state = $this->profile?->addresses?->first()?->state ?? '';
        $this->postal_code = $this->profile?->addresses?->first()?->postal_code ?? '';
        $this->is_default = $this->profile?->addresses?->first()?->is_default ?? '';
    }

    /**
     * Remove the current profile image
     */
    public function removeImage()
    {
        if ($this->profile->avatar) {
            $this->deleteOldImage($this->profile->avatar);

            $this->profile->update(['avatar' => null]);

            $this->profile = User::findOrFail(user()->id);

            session()->flash('success', 'Profile image removed successfully!');
        }
    }

    /**
     * Update admin profile
     */
    public function adminUpdate()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->profile->id,
            'newImage' => 'nullable|image|max:2048', // 2MB max
            'is_default' => 'nullable|boolean',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'number' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () {
                // Validate the input
                $data = [
                    'name' => $this->name,
                    'email' => $this->email,
                    'number' => $this->number,
                    'date_of_birth' => $this->date_of_birth,
                    'updated_at' => now(),
                    'updated_by' => user()->id,
                ];
                // Handle avatar upload
                if ($this->newImage) {
                    // Delete old image if exists
                    if ($this->profile->avatar) {
                        $this->deleteOldImage($this->profile->avatar);
                    }

                    // Upload new image
                    $data['avatar'] = $this->fileUploadService->uploadImage(
                        file: $this->newImage,
                        directory: 'avatars',
                        width: 400,
                        height: 400,
                        disk: 'public',
                        maintainAspectRatio: true
                    );
                }

                // Update the user
                $this->profile->update($data);
                Addresse::updateOrCreate(

                    ['user_id' => $this->profile->id],
                    [
                        'address' => $this->address,
                        'city' => $this->city,
                        'state' => $this->state,
                        'postal_code' => $this->postal_code,
                        'is_default' => $this->is_default,
                        'updated_at' => now(),
                        'updated_by' => user()->id,
                    ]
                );
            });
            $this->reset('newImage');
            session()->flash('success', 'Profile updated successfully!');
        } catch (\Throwable $e) {
            Log::error($e);
            throw $e;
        }
    }

    /**
     * Delete old image from storage
     */
    private function deleteOldImage($imagePath)
    {
        // Remove 'storage/' prefix if it exists in the path
        $cleanPath = str_replace('storage/', '', $imagePath);

        // Check if file exists and delete it
        if (Storage::disk('public')->exists($cleanPath)) {
            Storage::disk('public')->delete($cleanPath);
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.profile', [
            'profile' => $this->profile
        ]);
    }
}

<?php

namespace App\Livewire\Backend\User;

use App\Models\Addresse;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'app',
    [
        'title' => 'User-profile',
        'page_slug' => 'user-profile',
    ]
)]
class Profile extends Component
{
    // Basic Information
    public $name = '';
    public $email = '';
    public $number = '';

    // Address Information
    public $address_id = null;
    public $address = '';
    public $city = '';
    public $state = '';
    public $postal_code = '';
    public $address_type = 0; // Default to 'personal'

    protected function rules()
    {
        $userId = user()->id;
        
        return [
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,{$userId}",
            'number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'address_type' => 'nullable|integer|in:0,1,2',
        ];
    }

    public function mount()
    {
        // Get the authenticated user model instance
        $user = User::find(user()->id);

        // Ensure user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Load user basic information
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->number = $user->number ?? '';

        // Load default address if exists
        $defaultAddress = Addresse::where('user_id', $user->id)
            ->where('is_default', true)
            ->first();

        if ($defaultAddress) {
            $this->address_id = $defaultAddress->id;
            $this->address = $defaultAddress->address ?? '';
            $this->city = $defaultAddress->city ?? '';
            $this->state = $defaultAddress->state ?? '';
            $this->postal_code = $defaultAddress->postal_code ?? '';
            $this->address_type = $defaultAddress->address_type ?? 0;
        }
    }

    public function updateProfile()
    {
        $this->validate();

        // Get the authenticated user model instance
        $user = User::find(user()->id);

        if (!$user) {
            return redirect()->route('login');
        }

        // Update user basic information
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'number' => $this->number,
        ]);

        // Update or create address
        if ($this->address || $this->city || $this->state || $this->postal_code) {
            if ($this->address_id) {
                // Update existing address
                Addresse::where('id', $this->address_id)
                    ->where('user_id', $user->id)
                    ->update([
                        'address' => $this->address,
                        'city' => $this->city,
                        'state' => $this->state,
                        'postal_code' => $this->postal_code,
                        'address_type' => $this->address_type,
                    ]);
            } else {
                // Set all other addresses as not default
                Addresse::where('user_id', $user->id)->update(['is_default' => false]);
                
                // Create new address
                Addresse::create([
                    'user_id' => $user->id,
                    'address' => $this->address,
                    'city' => $this->city,
                    'state' => $this->state,
                    'postal_code' => $this->postal_code,
                    'address_type' => $this->address_type,
                    'is_default' => true,
                ]);
            }
        }

        session()->flash('success', 'Profile updated successfully!');

        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.backend.user.profile');
    }
}
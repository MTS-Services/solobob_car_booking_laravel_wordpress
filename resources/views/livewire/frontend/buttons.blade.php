 <div class="p-8 max-w-4xl mx-auto space-y-12">
     <div class="text-center">
         <h1 class="text-3xl font-bold mb-2">Blade Button Component Showcase</h1>
         <p class="text-lg text-text-secondary-light dark:text-text-secondary-dark">A gallery of button variants and
             states.</p>
     </div>

     <!-- Primary & Secondary Buttons -->
     <div class="space-y-4">
         <h2 class="text-2xl font-semibold mb-4">Primary & Secondary</h2>
         <div class="flex flex-wrap items-center gap-4">
             <x-button variant="primary">Generate Report</x-button>
             {{-- <x-button variant="primary" icon="plus">Add New Item</x-button>
             <x-button variant="primary" icon="download" iconPosition="right">Download</x-button> --}}
         </div>
         <div class="flex flex-wrap items-center gap-4">
             <x-button variant="secondary">Cancel</x-button>
             {{-- <x-button variant="secondary" icon="x-mark">Remove</x-button>
             <x-button variant="secondary" icon="check" iconPosition="right">Confirm</x-button> --}}
         </div>
     </div>

     <!-- Outline & Dashed Buttons -->
     <div class="space-y-4">
         <h2 class="text-2xl font-semibold mb-4">Outline & Dashed</h2>
         <div class="flex flex-wrap items-center gap-4">
             <x-button variant="outline">Learn More</x-button>
             {{-- <x-button variant="outline" icon="eye">Preview</x-button> --}}
             <x-button variant="dashed">Add Custom Field</x-button>
             {{-- <x-button variant="dashed" icon="plus">New</x-button> --}}
         </div>
     </div>

     <!-- Link Buttons -->
     <div class="space-y-4">
         <h2 class="text-2xl font-semibold mb-4">Link Style</h2>
         <div class="flex flex-wrap items-center gap-4">
             <x-button variant="link">Go Back</x-button>
             {{-- <x-button variant="link" icon="arrow-left">Back to Dashboard</x-button> --}}
         </div>
     </div>

     <!-- Disabled States -->
     <div class="space-y-4">
         <h2 class="text-2xl font-semibold mb-4">Disabled Buttons</h2>
         <div class="flex flex-wrap items-center gap-4">
             <x-button variant="primary" disabled>Saving...</x-button>
             <x-button variant="secondary" disabled>Disabled</x-button>
             <x-button variant="outline" disabled>Not Available</x-button>
             <x-button variant="link" disabled>Disabled Link</x-button>
         </div>
     </div>

     <!-- Small Buttons -->
     <div class="space-y-4">
         <h2 class="text-2xl font-semibold mb-4">Small Buttons</h2>
         <div class="flex flex-wrap items-center gap-4">
             <x-button variant="primary" small>Submit</x-button>
             <x-button variant="secondary" small>Cancel</x-button>
             {{-- <x-button variant="primary" small icon="plus">Add</x-button> --}}
         </div>
     </div>
 </div>

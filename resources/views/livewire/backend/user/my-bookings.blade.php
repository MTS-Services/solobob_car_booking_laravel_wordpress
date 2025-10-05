<section class="container mx-auto ">
   

  @if($myBookings)
        <div>
          
            <x-backend.table :columns="$columns" :data="$myBookings" :actions="$actions" search-property="search"
            per-page-property="perPage" empty-message="No admins found." />



         
   
        </div>
     @else
      <div class="text-center bg-gray-50 h-[50vh]">
        <div class="flex justify-center mb-8 ">
        
            <svg class="w-32 h-32 text-cyan-500" viewBox="0 0 200 120" fill="none" stroke="currentColor" stroke-width="3"
                stroke-linecap="round" stroke-linejoin="round">
                <!-- Car Body -->
                <rect x="30" y="60" width="140" height="40" rx="5" />

                <!-- Car Roof -->
                <path d="M50 60 L50 40 L90 40 L100 60" />
                <path d="M100 60 L110 40 L150 40 L150 60" />

                <!-- Windows -->
                <line x1="55" y1="45" x2="55" y2="58" />
                <line x1="85" y1="45" x2="85" y2="58" />
                <line x1="115" y1="45" x2="115" y2="58" />
                <line x1="145" y1="45" x2="145" y2="58" />

                <!-- Wheels -->
                <circle cx="60" cy="100" r="12" />
                <circle cx="60" cy="100" r="6" />
                <circle cx="140" cy="100" r="12" />
                <circle cx="140" cy="100" r="6" />

                <!-- Car Details -->
                <line x1="40" y1="75" x2="50" y2="75" />
                <line x1="150" y1="75" x2="160" y2="75" />

                <!-- Roof Light -->
                <rect x="95" y="30" width="10" height="5" rx="2" />
            </svg>
        </div>

        <!-- Empty State Text -->
       
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">No Bookings Yet</h2>
        <p class="text-gray-500">Your booking history will appear here</p>
       
    </div>
    @endif
</section>

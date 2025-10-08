<div>
    <section>

        <div class="flex items-center justify-between glass-card rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold text-text-primary">{{ __('Deposit List') }}</h2>
            <div class="flex items-center gap-2">
                {{--
                <x-button href="#" icon="plus" permission="order-create">
                    {{ __('Add') }}
                </x-button> --}}
            </div>
        </div>


        {{-- Table Section --}}
      <x-backend.table :columns="$columns" :data="$deposits" :actions="$actions" search-property="search"
            per-page-property="perPage" empty-message="No admins found." />

    </section>

</div>
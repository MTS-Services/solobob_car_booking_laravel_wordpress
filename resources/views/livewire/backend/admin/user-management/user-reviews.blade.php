<div>
  <x-backend.table :columns="$columns" :data="$items" :actions="$actions" search-property="search"
            per-page-property="perPage" empty-message="No Users found." />
</div>

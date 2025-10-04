<?php

use App\Http\Traits\AuditColumnsTrait;
use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->tinyInteger('status')->default(Category::STATUS_ACTIVE)->index();
            
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

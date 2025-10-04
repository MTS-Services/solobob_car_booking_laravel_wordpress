<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;
use App\Models\Review;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);

            // Relationships
            $table->unsignedBigInteger('booking_id')->unique();
            $table->unsignedBigInteger('user_id');

            // Review fields
            $table->decimal('rating', 2, 1)->check('rating >= 1.0 and rating <= 5.0');
            $table->string('title', 255)->nullable();
            $table->text('comment')->nullable();

            // Review status
            $table->tinyInteger('review_status')->default(Review::STATUS_PENDING);

            // Common columns
            $table->timestamps();
            $table->softDeletes();

            // Admin audit trail
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            // Foreign keys
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

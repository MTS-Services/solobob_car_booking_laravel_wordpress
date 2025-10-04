<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;

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


            $table->unsignedBigInteger('booking_id')->unique();
            $table->unsignedBigInteger('reviewer_id');
            $table->unsignedBigInteger('reviewee_id');
            $table->tinyInteger('review_type');
            
            $table->decimal('rating', 2, 1);
            $table->string('title', 255)->nullable();
            $table->text('comment')->nullable();
            
            $table->integer('cleanliness_rating')->nullable();
            $table->integer('communication_rating')->nullable();
            $table->integer('vehicle_accuracy_rating')->nullable();
            $table->integer('value_rating')->nullable();
            
            $table->text('response')->nullable();
            $table->timestamp('response_date')->nullable();
            
            $table->boolean('is_featured')->default(false);
            $table->tinyInteger('review_status')->default(0)->comment("'0 = pending', '1 = published', '2 = flagged', '3 = removed'");
            
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('reviewee_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade')->onUpdate('cascade');
            
            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            $table->index('booking_id', 'idx_booking_id');
            $table->index('reviewer_id', 'idx_reviewer_id');
            $table->index('reviewee_id', 'idx_reviewee_id');
            $table->index('review_type', 'idx_review_type');
            $table->index('rating', 'idx_rating');
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

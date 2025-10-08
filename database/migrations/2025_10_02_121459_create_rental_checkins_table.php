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
        Schema::create('rental_checkins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);
            // Relation with booking (one-to-one)
            $table->unsignedBigInteger('booking_id')->unique();


            // Check-in details
            $table->timestamp('checkin_datetime');
            $table->integer('mileage_start');
            $table->tinyInteger('fuel_level_start');
            $table->text('vehicle_condition_notes');
            $table->json('damage_photos');
            $table->string('checkin_signature_url', 500);
            $table->unsignedBigInteger('performed_by');

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('performed_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            // Audit & Soft Deletes
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
        Schema::dropIfExists('rental_checkins');
    }
};

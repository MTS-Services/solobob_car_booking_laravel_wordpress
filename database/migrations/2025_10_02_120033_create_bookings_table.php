<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;
use App\Models\Booking;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);

            // Relations
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pickup_location_id')->nullable();
            $table->unsignedBigInteger('audit_by')->nullable();

            // Booking info
            $table->string('booking_reference', 50)->unique();
            $table->dateTime('pickup_date')->nullable();
            $table->dateTime('return_date')->nullable();
            $table->dateTime('booking_date')->nullable();
            $table->string('return_location')->nullable();

            // Pricing
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('service_fee', 10, 2)->nullable();
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->decimal('security_deposit', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();

            // Status
            $table->tinyInteger('booking_status')
                ->default(Booking::BOOKING_STATUS_PENDING);

            // Additional info
            $table->text('special_requests')->nullable();
            $table->text('reason')->nullable();

            // Foreign key constraints
            $table->foreign('vehicle_id')
                ->references('id')->on('vehicles')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('pickup_location_id')
                ->references('id')->on('vehicle_locations')
                ->onDelete('set null')->onUpdate('cascade');

            $table->foreign('audit_by')
                ->references('id')->on('users')
                ->onDelete('set null')->onUpdate('cascade');

            // Common columns
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
        Schema::dropIfExists('bookings');
    }
};

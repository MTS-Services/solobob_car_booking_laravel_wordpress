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

            // Relations
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('renter_id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('pickup_location_id')->nullable();
            $table->unsignedBigInteger('return_location_id')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();

            // Booking core info
            $table->string('booking_reference', 50)->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->time('pickup_time')->nullable();
            $table->time('return_time')->nullable();
            $table->integer('total_days')->nullable();

            // Pricing
            $table->decimal('daily_rate', 10, 2)->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('service_fee', 10, 2)->nullable();
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->decimal('security_deposit', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();

            // Statuses
            $table->tinyInteger('booking_status')
                ->default(Booking::BOOKING_STATUS_PENDING);
            $table->tinyInteger('payment_status')
                ->default(Booking::PAYMENT_STATUS_PENDING);

            // Extra info
            $table->text('special_requests')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();

            // Foreign Key Constraints
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('renter_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pickup_location_id')->references('id')->on('vehicle_locations')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('return_location_id')->references('id')->on('vehicle_locations')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cancelled_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');

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

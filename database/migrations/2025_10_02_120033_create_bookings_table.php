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

            // Relationships
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pickup_location_id')->nullable();
            $table->unsignedBigInteger('audit_by')->nullable();

            // Booking details
            $table->string('booking_reference', 50)->unique();
            $table->dateTime('pickup_date');
            $table->dateTime('return_date');
            $table->dateTime('booking_date');

            $table->string('return_location')->nullable();
            $table->text('special_requests')->nullable();
            $table->text('reason')->nullable();

            // Financials
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('service_fee', 10, 2);
            $table->decimal('tax_amount', 10, 2);
            $table->decimal('security_deposit', 10, 2);
            $table->decimal('total_amount', 10, 2);

            // Booking status
            $table->tinyInteger('booking_status')
                ->default(Booking::BOOKING_STATUS_PENDING);

            // Common columns
            $table->timestamps();
            $table->softDeletes();
            $this->addAdminAuditColumns($table);

            // Foreign keys
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pickup_location_id')->references('id')->on('vehicle_locations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('audit_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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

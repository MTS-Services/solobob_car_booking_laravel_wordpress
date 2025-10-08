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
        Schema::create('rental_checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);
            
            $table->unsignedBigInteger('booking_id')->unique();
            $table->foreign('booking_id')
                ->references('id')->on('bookings')
                ->onDelete('cascade')->onUpdate('cascade');

            // Checkout details
            $table->timestamp('checkout_datetime');
            $table->integer('mileage_end');
            $table->tinyInteger('fuel_level_end')
                ->comment("1 = empty, 2 = quarter, 3 = half, 4 = three_quarter, 5 = full")->default(1);
            $table->text('vehicle_condition_notes');
            $table->json('damage_photos');
            $table->decimal('additional_charges', 10, 2)->default(0);
            $table->text('additional_charges_reason');
            $table->string('checkout_signature_url', 500);
            $table->unsignedBigInteger('performed_by');

            // Foreign Keys
            $table->foreign('performed_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('rentalcheckouts');
    }
};

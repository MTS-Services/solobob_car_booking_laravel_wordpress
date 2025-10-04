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
        Schema::create('rentalcheckouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);
            
            $table->unsignedBigInteger('booking_id')->unique();
            $table->foreign('booking_id')
                ->references('id')->on('bookings')
                ->onDelete('cascade')->onUpdate('cascade');

            // Checkout details
            $table->timestamp('checkout_datetime')->nullable();
            $table->integer('mileage_end')->nullable();
            $table->tinyInteger('fuel_level_end')
                ->comment("0 = empty, 1 = quarter, 2 = half, 3 = three_quarter, 4 = full")
                ->nullable();
            $table->text('vehicle_condition_notes')->nullable();
            $table->json('damage_photos')->nullable();
            $table->decimal('additional_charges', 10, 2)->default(0);
            $table->text('additional_charges_reason')->nullable();
            $table->string('checkout_signature_url', 500)->nullable();
            $table->unsignedBigInteger('performed_by')->nullable();

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

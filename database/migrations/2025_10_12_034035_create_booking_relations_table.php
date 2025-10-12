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
        Schema::create('booking_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);

            // Foreign keys
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('billing_information_id')->nullable();
            $table->unsignedBigInteger('residential_address_id')->nullable();
            $table->unsignedBigInteger('parking_address_id')->nullable();
            $table->unsignedBigInteger('user_document_id')->nullable();

            // Signature and terms
            $table->string('signature_path')->nullable();
            $table->boolean('terms_accepted')->default(false);
            $table->boolean('sms_alerts')->default(false);
            $table->timestamp('terms_accepted_at')->nullable();

            // Address relation flags
            $table->boolean('same_as_residential')->default(false);

            // Rental type
            $table->enum('rental_range', ['weekly', 'monthly'])->default('weekly');

            // Foreign key constraints
            $table->foreign('booking_id')->references('id')->on('bookings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('billing_information_id')->references('id')->on('billing_information')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('residential_address_id')->references('id')->on('addresses')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('parking_address_id')->references('id')->on('addresses')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('user_document_id')->references('id')->on('user_documents')->onUpdate('cascade')->onDelete('set null');

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
        Schema::dropIfExists('booking_relations');
    }
};

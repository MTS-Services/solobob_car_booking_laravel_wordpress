<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\AuditColumnsTrait;
use App\Models\Vehicle;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('category_id');

            // Vehicle info
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('year')->nullable();
            $table->string('color', 50)->nullable();
            $table->string('license_plate', 50)->unique();
            $table->integer('seating_capacity')->nullable();
            $table->integer('mileage')->nullable();
            $table->text('description')->nullable();

            // Pricing
            $table->decimal('weekly_rate', 10, 2)->nullable();
            $table->decimal('monthly_rate', 10, 2)->nullable();
            $table->decimal('security_deposit_weekly', 10, 2)->nullable();
            $table->decimal('security_deposit_monthly', 10, 2)->nullable();
            // Options
            $table->boolean('instant_booking')->default(false);
            $table->boolean('delivery_available')->default(false);
            $table->decimal('delivery_fee', 10, 2)->nullable();

            // Statuses
            $table->tinyInteger('status')
                ->default(Vehicle::STATUS_AVAILABLE);

            $table->tinyInteger('transmission_type');

            $table->foreign('owner_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('vehicles');
    }
};

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
        Schema::create('vehicle_relations', function (Blueprint $table) {
            $table->id();

            // Vehicle Relation Columns
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('feature_id');
            $table->unsignedBigInteger('make_id');
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('transmission_id');

            // Foreign Key Constraints
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('feature_id')->references('id')->on('vehicle_features')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('make_id')->references('id')->on('vehicle_makes')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('model_id')  ->references('id')->on('vehicle_models') ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('transmission_id')
                ->references('id')->on('vehicle_transmissions')
                ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('vehicle_relations');
    }
};

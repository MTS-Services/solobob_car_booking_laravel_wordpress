<?php

use App\Http\Traits\AuditColumnsTrait;
use App\Models\UserDocuments;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
                
            $table->string('licence')->nullable();
            $table->string('selfe_licence')->nullable();
            $table->string('address_proof')->nullable();
            $table->date('issue_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->tinyInteger('verification_status')->default(UserDocuments::VERIFICATION_PENDING);
            $table->timestamp('verified_at')->nullable();
            
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
        Schema::dropIfExists('user_documents');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('phone')->nullable();
            $table->text('message')->nullable();
            $table->string('subject')->nullable();
            $table->enum('status', ['new', 'contacted', 'follow_up', 'qualified', 'closed', 'cancelled'])->default('new');
            $table->text('notes')->nullable(); // internal notes for admin/agent
            $table->string('source')->default('website'); // website, whatsapp, phone
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};

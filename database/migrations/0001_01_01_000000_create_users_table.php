<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('role_id')->nullable();
            $table->string('email')->unique();
            $table->unsignedInteger('branch_id')->nullable();
			$table->boolean('status')->default('1');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('employee', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('branch_id')->nullable();
            $table->unsignedInteger('woreda_id')->nullable();
            $table->string('kebele')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('broker_name')->nullable();
            $table->string('broker_phone_no')->nullable();
            $table->string('guarantor')->nullable();
            $table->string('guarantor_phone_no')->nullable();
            $table->string('employee_id_card')->nullable();
            $table->string('guarantor_id_card')->nullable();
            $table->string('guarante_form')->nullable();
            $table->string('work_type')->nullable();  
			$table->boolean('is_deleted')->default('0');
            $table->timestamps();
            
        });

		Schema::create('salary', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id')->nullable();
            $table->Date('hired_date')->nullable();
            $table->string('salary_per_month')->nullable();
            $table->string('salary_total')->nullable();
            $table->string('salary_left')->nullable();
			$table->boolean('is_deleted')->default('0'); 
            $table->timestamps();

           
        });

        Schema::create('employee_credit', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('salary_id')->nullable();
            $table->string('reason')->nullable();
            $table->string('credit')->nullable();
            $table->Date('date')->nullable();
            $table->boolean('is_deleted')->default('0'); 
            $table->timestamps();

           
        });


		Schema::create('notification', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('user_id')->nullable();
			$table->string('message');
			$table->boolean('is_seen')->default('0');
			$table->timestamps();
		});

    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('employee');
        Schema::dropIfExists('salary');
        Schema::dropIfExists('notification');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

	public function up(): void
	{
		Schema::create('yemeta_khat', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id')->nullable();
			$table->unsignedInteger('khat_id')->nullable();
			$table->string('yemeta_khat')->nullable();
			$table->date('date')->nullable();
			$table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});
		Schema::create('daily_work_khat', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id')->nullable();
			$table->unsignedInteger('wede_branch_id')->nullable();
			$table->string('lela_branch_yetelake')->nullable(); 
			$table->string('yetelake_amount')->nullable(); 
			$table->string('type')->nullable();  // 80, 100, 140, 200, 300, 600  from selling_price attribute of khat table
			$table->string('yemeta')->nullable();  // takes value from yemeta_khat table 
			$table->string('total_khat')->nullable(); // yemeta + yaderew
			$table->string('yalew_khat')->nullable(); 
			$table->string('yeteshete_khat')->nullable();
			$table->string('birr')->nullable();
			$table->date('date')->nullable();
			$table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		Schema::create('daily_work_soft_drink', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id')->nullable();
			$table->unsignedInteger('soft_drink_id')->nullable();
			$table->string('yetefeta')->nullable();
			$table->string('total_soft_drink')->nullable();  // yetefeta + yaderew
			$table->string('yadere_soft_drink')->nullable();
			$table->string('yeteshete_soft_drink')->nullable();
			$table->string('birr')->nullable();
			$table->date('date')->nullable();
			$table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		Schema::create('daily_work_lozi', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id')->nullable();
			$table->unsignedInteger('lozi_id')->nullable();
			$table->string('yemeta')->nullable();
			$table->string('total_lozi')->nullable();  // yemeta + yaderew
			$table->string('yadere_lozi')->nullable();
			$table->string('yeteshete_lozi')->nullable();
			$table->string('birr')->nullable();
			$table->date('date')->nullable();
			$table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		Schema::create('daily_work_cigarates', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id')->nullable();
			$table->unsignedInteger('cigarates_id')->nullable();
			$table->string('yetekefete_cigarates')->nullable();
			$table->string('total_cigarates')->nullable();      // yetekefete + yaderew    packet + half e.g 12 + 1/2 
			$table->string('yadere_packet')->nullable();
			$table->string('yadere_half')->nullable(); 
			$table->string('yeteshete_cigarates')->nullable();  // packet + half e.g 12 + 1/2 
			$table->string('birr')->nullable();
			$table->date('date')->nullable();
			$table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		Schema::create('daily_work_woci', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id')->nullable();
			$table->string('name')->nullable();
			$table->string('birr_amount')->nullable();      
			$table->date('date')->nullable();
			$table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		Schema::create('daily_work_account', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id')->nullable();
			$table->string('type');    // account or tele birr
			$table->string('name');
			$table->string('birr_amount')->nullable();      
			$table->date('date')->nullable();
			$table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});


		Schema::create('daily_work_credit', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id')->nullable();
			$table->string('name');
			$table->string('birr_amount')->nullable();      
			$table->date('date')->nullable();
			$table->boolean('is_paid')->default('0');
			$table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		Schema::create('daily_work_birr', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id')->nullable();
			$table->string('cash_birr')->nullable();  
			$table->string('zirzir_birr')->nullable();     
			$table->date('date')->nullable();
			$table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		Schema::create('daily_work_yetekefele', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id')->nullable();
			$table->unsignedInteger('credit_id')->nullable(); 
			$table->string('paid_amount')->nullable();  // minus paid_amount from amount on credit table    
			$table->date('date')->nullable();
			$table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		Schema::create('daily_work_gudilet', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id')->nullable();
			$table->string('gudilet')->nullable();
			$table->date('date')->nullable();
			$table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		


		

	}
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('khat', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('buying_price');
			$table->string('selling_price');
			$table->boolean('status')->default('1');
			// $table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		

		Schema::create('soft_drink', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('price');
			$table->string('number_in_pack');
			$table->boolean('status')->default('1');
			// $table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		Schema::create('cigarates', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('half_price');           
			$table->string('packet_price');
			$table->string('number_in_pack');
			$table->boolean('status')->default('1');
			// $table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});


		Schema::create('lozi', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();   
			$table->string('price');
			$table->boolean('status')->default('1');
			// $table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		Schema::create('store', function (Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id')->nullable();
			$table->string('material_type');           //soft_drink or cigarates
			$table->unsignedInteger('soft_drink_id')->nullable();
			$table->unsignedInteger('cigarates_id')->nullable();
			$table->string('number');  		
			// $table->boolean('is_deleted')->default('0');
			$table->timestamps();
		});

		


		

	}
};

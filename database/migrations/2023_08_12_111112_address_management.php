<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	
	public function up(): void
	{
		
		Schema::create('region', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('type');
			$table->timestamps();
		});

		Schema::create('zone', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('region_id');
			$table->timestamps();
		});

		Schema::create('woreda', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->unsignedInteger('zone_id');
			$table->timestamps();
		});

		

		Schema::create('branch', function (Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('phone_number_1')->unique();
			$table->string('phone_number_2')->nullable();
			$table->unsignedInteger('woreda_id');
			$table->string('location');
			$table->boolean('status')->default('1');
			$table->timestamps();
		});

		
		

	}
};

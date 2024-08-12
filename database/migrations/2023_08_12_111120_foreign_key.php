<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('users', function (Blueprint $table) {
			
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			
		});

		Schema::table('employee', function (Blueprint $table){
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			$table->foreign('woreda_id')->references('id')->on('woreda')->onDelete('cascade');

		});

		Schema::table('salary', function (Blueprint $table){
			$table->foreign('employee_id')->references('id')->on('employee')->onDelete('cascade');

		});

		Schema::table('notification', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});

		Schema::table('region', function (Blueprint $table) {
			
		});

		Schema::table('zone', function (Blueprint $table) {
			$table->foreign('region_id')->references('id')->on('region')->onDelete('cascade');
			
		});

		Schema::table('woreda', function (Blueprint $table) {
			$table->foreign('zone_id')->references('id')->on('zone')->onDelete('cascade');
			
		});
		Schema::table('employee_credit', function (Blueprint $table) {
			$table->foreign('salary_id')->references('id')->on('salary')->onDelete('cascade');
           
        });

		

		Schema::table('branch', function (Blueprint $table) {
			$table->foreign('woreda_id')->references('id')->on('woreda')->onDelete('cascade');
			
		});

		Schema::table('khat', function (Blueprint $table) {
			
		});


		Schema::table('soft_drink', function (Blueprint $table){

		});

		Schema::table('cigarates', function (Blueprint $table){

		});

		Schema::table('lozi', function (Blueprint $table){
			
		});

		Schema::table('store', function (Blueprint $table){
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			$table->foreign('soft_drink_id')->references('id')->on('soft_drink')->onDelete('cascade');
			$table->foreign('cigarates_id')->references('id')->on('cigarates')->onDelete('cascade');
			
		});
		
		Schema::table('yemeta_khat', function (Blueprint $table)
		{
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			$table->foreign('khat_id')->references('id')->on('khat')->onDelete('cascade');
			
		});

		Schema::table('daily_work_khat', function (Blueprint $table){
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			$table->foreign('wede_branch_id')->references('id')->on('branch')->onDelete('cascade');
			
		});
		
		Schema::table('daily_work_soft_drink', function (Blueprint $table){
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			$table->foreign('soft_drink_id')->references('id')->on('soft_drink')->onDelete('cascade');
			
		});

		Schema::table('daily_work_lozi', function (Blueprint $table){
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			$table->foreign('lozi_id')->references('id')->on('lozi')->onDelete('cascade');
			
		});

		Schema::table('daily_work_cigarates', function (Blueprint $table){
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			$table->foreign('cigarates_id')->references('id')->on('cigarates')->onDelete('cascade');
			
		});

		Schema::table('daily_work_woci', function (Blueprint $table){
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			
		});

		Schema::table('daily_work_account', function (Blueprint $table){
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			
		});

		Schema::table('daily_work_credit', function (Blueprint $table){
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			
		});

		Schema::table('daily_work_birr', function (Blueprint $table){
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			
		});

		Schema::table('daily_work_yetekefele', function (Blueprint $table){
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			$table->foreign('credit_id')->references('id')->on('daily_work_credit')->onDelete('cascade');
			
		});

		Schema::table('daily_work_gudilet', function (Blueprint $table){
			$table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
			
		});
		

		
		

		
		

	

	}
};

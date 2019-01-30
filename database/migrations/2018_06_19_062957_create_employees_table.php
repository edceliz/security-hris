<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('surname');
            $table->string('first_name');
            $table->string('middle_initial');
            $table->string('blood_type')->nullable();
            $table->string('current_address');
            $table->string('permanent_address');
            $table->string('contact_number');
            $table->date('birthday');
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Separated', 'Divorced']);
            $table->tinyInteger('dependents_no')->nullable();
            $table->string('sss');
            $table->string('tin');
            $table->string('philhealth');
            $table->string('pagibig');
            $table->string('health_insurance')->nullable();

            $table->integer('license_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('detachment_id')->nullable();
            $table->integer('position_id')->nullable();

            $table->string('emergency_contact')->nullable();
            $table->string('emergency_number')->nullable();

            $table->date('date_hired');

            $table->integer('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}

<?php

use App\Models\Module\ProviderModule;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosts', function (Blueprint $table) {
            $table->id();

            // $table->unsignedBigInteger('upstream_id')->index();


            // name
            $table->string('name')->index();

            // client_id
            $table->unsignedBigInteger('client_id')->index();
            $table->foreign('client_id')->references('id')->on('clients');

            // price
            $table->double('price', 60, 8)->index();

            // config
            $table->json('configuration')->nullable();

            // status
            $table->enum('status', ['running', 'stopped', 'error', 'suspended', 'pending'])->default('pending')->index();

            // soft delete
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
        Schema::dropIfExists('hosts');
    }
};

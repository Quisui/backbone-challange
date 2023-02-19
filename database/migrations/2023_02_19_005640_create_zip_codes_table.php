<?php

use App\Services\Api\V1\DocumentReader\ReadDocument;
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
        if (!app()->environment('testing')) {
            $filePath = public_path('app') . '/CPdescarga.xls';
            $columnKeys = (new ReadDocument)->readDocument('readFile', ['facadeName' => 'excel', 'filePath' => $filePath]);
            $columns = $columnKeys['migration_columns'];
            Schema::create('zip_codes', function (Blueprint $table) use ($columns) {
                $table->id();
                foreach ($columns as $key => $columnValue) {
                    $table->string($columnValue)->nullable();
                }
                $table->timestamps();
            });
        } else {
            Schema::create('zip_codes', function (Blueprint $table) {
                $table->id();
                $table->string('d_codigo')->nullable();
                $table->string('d_asenta')->nullable();
                $table->string('d_tipo_asenta')->nullable();
                $table->string('D_mnpio')->nullable();
                $table->string('d_estado')->nullable();
                $table->string('d_ciudad')->nullable();
                $table->string('d_CP')->nullable();
                $table->string('c_estado')->nullable();
                $table->string('c_oficina')->nullable();
                $table->string('c_CP')->nullable();
                $table->string('c_tipo_asenta')->nullable();
                $table->string('c_mnpio')->nullable();
                $table->string('id_asenta_cpcons')->nullable();
                $table->string('d_zona')->nullable();
                $table->string('c_cve_ciudad')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zip_codes');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoTable extends Migration {

    //Declaracion del metodo up
    public function up ()
    {
        //Funcion Schema
        Schema::create('productos', function (Blueprint $table) {
            //Estructura de la tabla
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('idcategoria')->unsigned();
            $table->string('codigo', 50)->nullable();
            $table->string('nombre', 100)->unique();
            $table->decimal('precio_venta', 11, 2);
            $table->integer('stock');
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            //Se crea la relacion de las tablas a travez del foreing
            $table->foreign('idcategoria')->references('id')->on('categorias');
             });
    }

    //Declaracion del metodo down
    public function down ()
    {
        //Funcion <<dropIfExists>>, elimina la tabla si existe una con el mismo nombre
        Schema::dropIfExists('producto');
    }
}

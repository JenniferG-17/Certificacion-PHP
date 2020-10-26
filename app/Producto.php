<?php namespace App;

use Illuminate\Database\Eloquent\Model;

//Clase <<Producto>> que extiende de la clase <<Model>>
class Producto extends Model {

	//La funcion protected nos ayuda a proteger la tabla
    protected $table = 'productos';
    //y tambien las propiedades de la tabla
    protected $fillable = ['idcategoria', 'codigo','nombre', 'precio_venta', 
    'stock','condicion', 'imagen'];
}

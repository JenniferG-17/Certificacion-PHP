<?php namespace App\Http\Controllers; 

use Illuminate\Http\Request; //Libreria para formularios
use App\Categoria; // Modelo de Categoria
use Illuminate\Support\Facades\Redirect; //Provee un metodo que perimite redirijir a una vista en especifico
use DB; //Permite hacer uso de la base de datos, y querys

class CategoriaController extends Controller {
    
    //Declaracion del metodo index, que recibe un parametro llamado $request
    public function index (Request $request)
    {
        //Condicion que verifica se existe lo obtenido del campo de texto llamado <<buscarTexto>> y enlista las categorias 
        if ($request)
        {
            $sql = trim($request->get('buscarTexto'));
            $categorias = DB::table('categorias')->where('nombre', 'LIKE', '%'.$sql.'%')
            ->orderBy('id', 'desc')->paginate(5);

            return view('categoria.index', ["categorias" => $categorias, 
                "buscarTexto" => $sql]);
            //Retornamos la vista de <<categoria.index>>
        }
    }

    //Declaracion del metodo store, que recibe un parametro llamado $request
    public function store(Request $request)
    {
        //Se crea una instancia del objeto <<Categoria>>
        $categoria = new Categoria();
        //Se le asigna el valor a la variable <<categoria>> 
        //a travez de la variable $request que contiene lo que 
        //recibe de los campos del formulario
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        //Con <<save>> guardamos los valores en la variable categoria
        $categoria->save();

        return Redirect::to("categoria");
        //Retornamos a la vista de categoria
    }

    //Declaracion del metodo update, recibe un parametro llamado request
    public function update(Request $request)
    {
        //Instancia que le asigna el valor a la valirable <<categoria>> de lo encontrado por la funcion findOrFail, que obtiene el valor del id y lo guarda en la variable <<request>>
        $categoria = Categoria::findOrFail($request->id_categoria);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        //Con <<save>> guardamos los valores en la variable categoria
        $categoria->save();

        return Redirect::to("categoria");
        //Retornamos a la vista de categoria
    }

    //Declaracion del metodo destroy, recibe un parametro llamado request
    public function destroy(Request $request)
    {
        //Instancia que le asigna el valor a la valirable <<categoria>> de lo encontrado por la funcion findOrFail, que obtiene el valor del id y lo guarda en la variable <<request>>
        $categoria= Categoria::findOrFail($request->id_categoria);
        
        //Condcion que evalua si la condicion es igual a 1
        if ($categoria->condicion == "1") {
            //Si la condicion es equivalente a 1, cambia el valor a 0
            $categoria->condicion = '0';
            //Guardamos los cambios con la funcion <<save>>
            $categoria->save();

            return Redirect::to("categoria");
            //Retorna a la vista de Categoria

        }else{
            //Si la condicion no es igual a 1, el valor cambia por el 1
            $categoria->condicion = '1';
            //Guardamos los cambios con la funcion <<save>>
            $categoria->save();

            return Redirect::to("categoria");
            //Retorna a la vista de Categoria
        }
    }
}

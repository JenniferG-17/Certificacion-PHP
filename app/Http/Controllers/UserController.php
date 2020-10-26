<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request) {
            $sql = trim($request->get('buscarTexto'));
            $usuarios = DB::table('users')
                ->join('roles', 'users.idrol', '=', 'roles.id')
                ->select(
                    'users.id',
                    'users.nombre',
                    'users.tipo_documento',
                    'users.num_documento',
                    'users.direccion',
                    'users.telefono',
                    'users.email',
                    'users.usuario',
                    'users.password',
                    'users.condicion',
                    'users.idrol',
                    'roles.nombre as rol'
                )
                ->where('users.nombre', 'LIKE', '%' . $sql . '%')
                ->orwhere('users.num_documento', 'LIKE', '%' . $sql . '%')
                ->orderBy('id', 'desc')
                ->paginate(3);

            $roles = DB::table('roles')
                ->select('id', 'nombre', 'descripcion')
                ->where('condicion', '=', '1')->get();

            return view('user.index', ["usuarios" => $usuarios, "roles" => $roles, "buscarTexto" => $sql]);
            //return $usuarios;
        }
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->nombre = $request->nombre;
        $user->tipo_documento = $request->tipo_documento;
        $user->num_documento = $request->num_documento;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->direccion = $request->direccion;
        $user->usuario = $request->usuario;
        $user->password = bcrypt($request->password);
        $user->condicion = '1';
        $user->idrol = $request->id_rol;



        //fin registrar imagen
        $user->save();
        return Redirect::to("user");
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id_usuario);
        $user->nombre = $request->nombre;
        $user->tipo_documento = $request->tipo_documento;
        $user->num_documento = $request->num_documento;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->direccion = $request->direccion;
        $user->usuario = $request->usuario;
        $user->password = bcrypt($request->password);
        $user->condicion = '1';
        $user->idrol = $request->id_rol;

       

        //fin editar imagen

        $user->save();
        return Redirect::to("user");
    }

    public function destroy(Request $request)
    {
        //
        $user = User::findOrFail($request->id_usuario);

        if ($user->condicion == "1") {

            $user->condicion = '0';
            $user->save();
            return Redirect::to("user");
        } else {

            $user->condicion = '1';
            $user->save();
            return Redirect::to("user");
        }
    }
}

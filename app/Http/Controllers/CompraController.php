<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compra;
use App\DetalleCompra;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use DB;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        if ($request) {

            $sql = trim($request->get('buscarTexto'));
            $compras = Compra::join('proveedores_tabla', 'compras.idproveedor', '=', 'proveedores_tabla.id')
                ->join('users', 'compras.idusuario', '=', 'users.id')
                ->join('detalle_compras', 'compras.id', '=', 'detalle_compras.idcompra')
                ->select(
                    'compras.id',
                    'compras.tipo_identificacion',
                    'compras.num_compra',
                    'compras.fecha_compra',
                    'compras.impuesto',
                    'compras.estado',
                    'compras.total',
                    'proveedores_tabla.nombre as proveedor',
                    'users.nombre'
                )
                ->where('compras.num_compra', 'LIKE', '%' . $sql . '%')
                ->orderBy('compras.id', 'desc')
                ->groupBy(
                    'compras.id',
                    'compras.tipo_identificacion',
                    'compras.num_compra',
                    'compras.fecha_compra',
                    'compras.impuesto',
                    'compras.estado',
                    'compras.total',
                    'proveedores_tabla.nombre',
                    'users.nombre'
                )
                ->paginate(8);

            //return view('compra.index', ["compras" => $compras, "buscarTexto" => $sql]);
            return $compras;
        }
    }

    public function create()
    {
        $proveedores = DB::table('proveedores_tabla')->get();

        $productos = DB::table('productos as prod')
            ->select(DB::raw('CONCAT(prod.codigo," ",prod.nombre) AS producto'), 'prod.id')
            ->where('prod.condicion', '=', '1')->get();

        return view('compra.create', ["proveedores_tabla" => $proveedores, "productos" => $productos]);
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $mytime = Carbon::now('America/Guatemala');

            $compra = new Compra();
            $compra->idproveedor = $request->id_proveedor;
            $compra->idusuario = \Auth::user()->id;
            $compra->tipo_identificacion = $request->tipo_identificacion;
            $compra->num_compra = $request->num_compra;
            $compra->fecha_compra = $mytime->toDateString();
            $compra->impuesto = '0.20';
            $compra->total = $request->total_pagar;
            $compra->estado = 'Registrado';
            $compra->save();

            $id_producto = $request->id_producto;
            $cantidad = $request->cantidad;
            $precio = $request->precio_compra;

            //Recorro todos los elementos
            $cont = 0;

            while ($cont < count($id_producto)) {
                $detalle = new DetalleCompras();

                $detalle->idcompra = $compra->id;
                $detalle->idproducto = $id_producto[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio = $precio[$cont];
                $detalle->save();
                $cont = $cont + 1;
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        return Redirect::to('compra');
    }

    public function show($id)
    {
        $compra = Compra::join('proveedores_tabla', 'compras.idproveedor', '=', 'proveedores_tabla.id')
            ->join('detalle_compras', 'compras.id', '=', 'detalle_compras.idcompra')
            ->select(
                'compras.id',
                'compras.tipo_identificacion',
                'compras.num_compra',
                'compras.fecha_compra',
                ' compras.impuesto',
                'compras.estado',
                DB::raw('sum(detalle_compras.cantidad*precio) as total'),
                'proveedores_tabla.nombre'
            )
            ->where('compras.id', '=', $id)
            ->orderBy('compras.id', 'desc')
            ->groupBy(
                'compras.id',
                'compras.tipo_identificacion',
                'compras.num_compra',
                'compras.fecha_compra',
                'compras.impuesto',
                'compras.estado',
                'proveedores_tabla.nombre'
            )
            ->first();

        $detalles = DetalleCompra::join('productos', 'detalle_compras.idproducto', '=', 'productos.id')
            ->select('dtalle_compras.cantidad', 'detalle_compras.precio', 'productos.nombre as producto')
            ->where('detalle_compras.idcompra', '=', $id)
            ->orderBy('detalle_compras.id', 'desc')->get();

        return view('compra.show', ['compra' => $compra, 'detalles' => $detalles]);
    }

    public function destroy(Request $request)
    {
        $compra = Compra::findOrFail($request->id_compra);
        $compra->estado = 'Anulado';
        $compra->save();
        return Redirect::to('compra');
    }


}
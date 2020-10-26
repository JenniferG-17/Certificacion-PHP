@extends('auth.contenido')

@section('login')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card-group mb-0">
            <div class="card p-4">
                <form class="form-horizontal was-validated" method="POST" action="{{route('login')}}">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <h3 class="text-center bg-success">Compras - Ventas</h3>

                        <div class="form-group mb-3 {{$errors->has('usuario' ? 'is-invalid' : '')}}">
                            <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                            {!!$errors->first('usuario','<p class="invalid-feedback">:message</p>')!!}
                        </div>

                        <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                            <input type="password" name="password" id="contrasenia" class="form-control" placeholder="Contraseña" >
                            {!!$errors->first('password', '<p class="invalid-feedback">:message</p>') !!}
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-success px-4"><i class="fa fa-sign-in fa-2x"></i> Iniciar sesión</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

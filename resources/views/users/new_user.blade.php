@extends('base.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ url( '/usuarios') }}" class="btn btn-secondary">Atrás</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h3 class="card-title">Registro de usuarios</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('/usuarios') }}" method="POST">
                            @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @csrf
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Nombre(s)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" name="nombre" class="form-control" placeholder="Nombre(s)" value="{{ old('nombre') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Apellidos</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" name="apellidos" class="form-control" placeholder="Apellidos" value="{{ old('apellidos') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Status</label>
                                        <select class="form-control select2" name="status">
                                            <option value="1" selected="selected">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Correo Electrónico</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>¿Se le asigna terminal?</label>
                                        <select class="form-control select2">
                                            <option value="1" selected="selected">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Número de Terminal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-list-ol"></i></span>
                                            </div>
                                            <input type="text" name="terminal" class="form-control" placeholder="Número de terminal" value="{{ old('terminal') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="submit" class="btn btn-block btn-primary">Registrar Usuario</button>
                                </div>
                                
                            </form>
                        </div>    
                    </div>
                </div>
            </div>
        </div>  
    </section>


@section('script')

    <script type="text/javascript">
        $(document).ready(function () 
        {
            
        });
    </script>

@endsection

@endsection

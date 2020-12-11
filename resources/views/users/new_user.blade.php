@extends('base.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nombre Completo</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Nombre y Apellido">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control select2" style="width: 100%;">
                                            <option selected="selected">Activo</option>
                                            <option>Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>¿Se le asigna terminal?</label>
                                        <select class="form-control select2" style="width: 100%;">
                                            <option selected="selected">Sí</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nombre Base de Datos</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Autocomplete">
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label>Correo Electrónico</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" placeholder="Correo Electrónico">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Número de Terminal</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-list-ol"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Número de terminal">
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                            <button type="button" class="btn btn-block btn-primary">Registrar Usuario</button>
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

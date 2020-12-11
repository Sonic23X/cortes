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
                                    <h3 class="card-title">Registro de pago realizado por repartidor</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" data-inputmask-alias="datetime"
                                                   data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Repartidor</label>
                                        <select class="form-control select2" style="width: 100%;">
                                            <option selected="selected">Adrián Hernández</option>
                                            <option>Alejandro Gómez</option>
                                            <option>Angel Ortiz</option>
                                            <option>Antonio Arvizu</option>
                                            <option>Arturo Cortés</option>
                                            <option>Armando Peña</option>
                                            <option>Arturo Austria Arteaga</option>
                                            <option>Axel Martinez</option>
                                            <option>Bernardo Aguilar</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Negocio</label>
                                        <input type="text" class="form-control" placeholder="Autocomplete de negocios">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Número de Pedido</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fas fa-truck-loading"></i></span>
                                            </div>
                                            <input type="number" class="form-control" placeholder="No. Pedido">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Monto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="text" class="form-control">
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Tipo de Pago</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control select2" style="width: 100%;">
                                                <option selected="selected">Efectivo</option>
                                                <option>Tarjeta Bancaria</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <button type="button" class="btn btn-block btn-primary">Registrar Pago</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@section('script')

    <script type="text/javascript">
        $(document).ready(function () {
            $("#tablaPagos").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "responsive": true,
                "buttons": ['excel', 'pdf', 'colvis']
            }).buttons().container().appendTo('#tablaPagos_wrapper .col-md-6:eq(0)');
        });
    </script>

@endsection

@endsection

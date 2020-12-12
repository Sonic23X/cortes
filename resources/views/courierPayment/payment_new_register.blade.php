@extends('base.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
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
                            <form action="{{ url('/pagosPorRepartidor') }}" method="POST">
                                @csrf
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
                                                       data-inputmask-inputformat="dd/mm/yyyy" data-mask name="fechaPago">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Repartidor</label>
                                            <select class="form-control select2" style="width: 100%;" name="repartidorPago">
                                                @foreach ($couriers as $courier)
                                                    <option value="{{ $courier[0] }}">{{ $courier[1] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Negocio</label>
                                            <input type="text" class="form-control"
                                                   placeholder="Autocomplete de negocios" name="placesPagos">
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
                                                <input type="number" class="form-control" placeholder="No. Pedido" name="pedidoPago">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Monto</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="text" class="form-control" name="montoPago">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Tipo de Pago</label>
                                            <div class="input-group mb-3">
                                                <select class="form-control select2" style="width: 100%;" name="tipoPagoPagos">
                                                    @foreach ($paymentTypes as $paymentType)
                                                        <option value="{{ $paymentType[0] }}">{{ $paymentType[1] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="button" class="btn btn-block btn-primary">Registrar Pago</button>
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

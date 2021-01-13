@extends('base.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Registro de pago realizado por repartidor</h3>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ url( '/pagos') }}" class="btn btn-secondary">Atrás</a>
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
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form action="{{ url('/pagos') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Fecha:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" data-inputmask-alias="datetime"
                                                   data-inputmask-inputformat="dd/mm/yyyy" data-mask name="fecha" value="{{ old('fecha') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Número de Pedido</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="fas fa-truck-loading"></i></span>
                                            </div>
                                            <input type="number" class="form-control" placeholder="No. Pedido" name="pedido" value="{{ old('pedido') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Repartidor</label>
                                        <select class="form-control select2" name="repartidor" value="{{ old('repartidor') }}">
                                            @foreach ($couriers as $courier)
                                                <option value="{{ $courier[0] }}">{{ $courier[1] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Monto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" name="monto" value="{{ old('monto') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Negocio</label>
                                        <select class="form-control select2" name="negocio" value="{{ old('negocio') }}">
                                            @foreach ($places as $place)
                                                <option value="{{ $place[0] }}">{{ $place[1] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="submit" class="btn btn-block btn-primary">Registrar Pago</button>
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
            $('.select2').select2(
            {
                theme: 'bootstrap4',
            });
        });
    </script>

@endsection

@endsection

@extends('base.layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Registro Movimientos de Flujo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url( '/flujo') }}">Atrás</a></li>
                    </ol>
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
                                    <h3 class="card-title">Registro Movimientosde Flujo</h3>
                                </div>
                            </div>
                        </div>
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
                            <form action="{{ url('/flujo') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tipo de Movimiento</label>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="tipo">
                                                    <option value="1" selected="selected">Cargo</option>
                                                    <option value="2">Pago</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Cantidad</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="number" class="form-control" name="cantidad">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Elige Concepto</label>
                                            <select class="form-control" name="concepto" id="concepto">
                                                @foreach ($concepts as $concept)
                                                    <option value="{{ $concept->id }}">{{ $concept->concept }}</option>                                    
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Detalle:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Ingrese detalle" name="detalle">
                                            </div>
                                        </div>
                                        <div class="form-group" id="courier_input">
                                            <label>Elegir Repartidor:</label>
                                            <div class="input-group">
                                                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" name="repartidor">
                                                @foreach ($couriers as $courier)
                                                    <option value="{{ $courier[0] }}">{{ $courier[1] }}</option>                                    
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Cuenta</label>
                                            <select class="form-control" name="cuenta">
                                                <option selected="selected" value="1">Sergio BBVA</option>
                                                <option value="2">Antonio BBVA</option>
                                                <option value="3">Ouvio BBVA</option>
                                                <option value="4">Mercado Pago</option>
                                                <option value="5">Efectivo</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Fecha:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" name="fecha">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="submit" class="btn btn-block btn-primary">Registrar</button>
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
            $('.select2').select2(
            {
                theme: 'bootstrap4',
            });

            $('#concepto').change( event => 
            {
                if( $('#concepto').val() == '1' || $('#concepto').val() == '3' )
                {
                    $('#courier_input').show();
                }
                else
                {
                    $('#courier_input').hide();
                }
            });


        });
    </script>

@endsection

@endsection

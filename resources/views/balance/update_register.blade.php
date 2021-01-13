@extends('base.layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Registro de movimiento</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ url( '/saldos') }}" class="btn btn-secondary">Atrás</a>
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
                            <form action="{{ url('/saldos/' . $movement->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Elegir Repartidor:</label>
                                        <div class="input-group">
                                            <select class="form-control select2" id="repartidor" name="repartidor" value="">
                                            @foreach ($couriers as $courier)
                                                @if( $courier->id == $movement->id_courier )
                                                <option value="{{ $courier->id }}" selected>{{ $courier->name }} {{ $courier->last_name }}</option>                                    
                                                @else
                                                <option value="{{ $courier->id }}">{{ $courier->name }} {{ $courier->last_name }}</option>                                    
                                                @endif
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Cantidad Madero</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" step="any" name="madero" value="{{ $movement->amount_madero }}">
                                        </div>
                                    </div>                      
                                </div>

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>Acumulado de repartos</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" step="any" name="repartos" value="{{ $movement->amount_repartos }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Pagos a Urbo</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" step="any" name="urbo" value="{{ $movement->amount_urbo }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Pagos a Repartidor</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" step="any" name="repartidor_monto" value="{{ $movement->amount_repartidor }}">
                                        </div>
                                    </div>                         
                                </div>
                                <div class="row">
                                    <button type="submit" class="btn btn-block btn-primary">Actualizar</button>
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
        });

    </script>

@endsection

@endsection

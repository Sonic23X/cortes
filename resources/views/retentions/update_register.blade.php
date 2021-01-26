@extends('base.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>{{ $title }}</h3>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ url( '/retenciones/' . $movement->id) }}" class="btn btn-secondary">Atrás</a>
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
                            <form action="{{ url('/retenciones/' . $movement->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Fecha:</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="far fa-calendar-alt"></i></span>
                                            </div>
                                            @php
                                                $fecha = explode(' ', $movement->date)
                                            @endphp
                                            <input type="date" class="form-control" data-inputmask-alias="datetime"
                                                   data-inputmask-inputformat="dd/mm/yyyy" data-mask name="fecha" value="{{ $fecha[0] }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Número de Pedido</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i
                                                    class="fas fa-truck-loading"></i></span>
                                            </div>
                                            <input type="number" class="form-control" placeholder="No. Pedido" name="pedido" value="{{ $movement->id_order }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Repartidor</label>
                                        <select class="form-control select2" name="repartidor" value="{{ old('repartidor') }}">
                                        @foreach ($couriers as $courier)
                                            @if( $courier->id == $movement->id_courier )
                                            <option value="{{ $courier->id }}" selected>{{ $courier->name }} {{ $courier->last_name }}</option>                                    
                                            @else
                                            <option value="{{ $courier->id }}">{{ $courier->name }} {{ $courier->last_name }}</option>                                    
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Monto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" step="any" class="form-control" name="monto" value="{{ $movement->amount }}">
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
        $(document).ready(function () {
            $('.select2').select2(
            {
                theme: 'bootstrap4',
            });
        });
    </script>

@endsection

@endsection

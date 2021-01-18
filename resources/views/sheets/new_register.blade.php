@extends('base.layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nuevo movimiento</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ url( '/hojas') }}" class="btn btn-secondary">Atrás</a>
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
                        <div class="card-body text-center">
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ url('/hojas') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>Tipo de Movimiento</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control" name="tipo" id="tipo_movimiento">
                                                <option value="1">Egreso</option>
                                                <option value="2">Ingreso</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Elige la hoja de calculo</label>
                                        <select class="form-control select2" name="hoja" id="hoja">
                                        @foreach ($sheets as $sheet)
                                            <option value="{{ $sheet->id }}">{{ $sheet->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Cantidad</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" step="any" name="cantidad" value="{{ old('cantidad') }}">
                                        </div>
                                    </div>                                                           
                                </div>

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>Descripción:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Ingrese la descripción" name="detalle" value="{{ old('detalle') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Fecha:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="datetime-local" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" name="fecha" value="{{ old('fecha') }}" step="1">
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
        });
    </script>

@endsection

@endsection

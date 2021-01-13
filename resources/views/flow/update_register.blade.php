@extends('base.layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Actualizar movimiento</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ url( '/flujo') }}" class="btn btn-secondary">Atrás</a>
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
                            <form action="{{ url('/flujo/' . $movement->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>Tipo de Movimiento</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control" name="tipo" id="tipo_movimiento" disabled>
                                                @if($movement->type == 'cargo')
                                                <option value="1" selected>Egreso</option>
                                                <option value="2">Ingreso</option>
                                                @else
                                                <option value="1">Egreso</option>
                                                <option value="2" selected>Ingreso</option>
                                                @endif
                                            </select>
                                            <input type="hidden" name="tipo" id="tipo" value="{{ $movement->type }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Elige Concepto</label>
                                        <select class="form-control" name="concepto" id="concepto">
                                        @foreach ($concepts as $concept)
                                            @if ( $concept->id == $movement->concept )
                                            <option value="{{ $concept->id }}" selected>{{ $concept->concept }}</option>
                                            @else
                                            <option value="{{ $concept->id }}">{{ $concept->concept }}</option>
                                            @endif
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Cuenta</label>
                                        <select class="form-control" name="cuenta">
                                        @foreach ($accounts as $account)
                                            @if ( $account->id == $movement->id_account )
                                            <option value="{{ $account->id }}" selected>{{ $account->name }}</option>
                                            @else
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>    
                                            @endif                                
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>Cantidad</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" step="any" class="form-control" name="cantidad" value="{{ $movement->amount }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Detalle:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Ingrese detalle" name="detalle" value="{{ $movement->details }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Fecha:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            @php
                                                $fecha = str_replace(' ', 'T', $movement->date)
                                            @endphp
                                            <input type="datetime-local" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" name="fecha" value="{{ $fecha }}" step="1">
                                        </div>
                                    </div>                          
                                </div>
                                <div class="row d-flex align-items-center justify-content-center">
                                    <div class="form-group col-4" id="courier_input">
                                        <label>Elegir Repartidor:</label>
                                        <div class="input-group">
                                            <select class="form-control select2" id="repartidor" name="repartidor">
                                            @if ($movement->id_courier == null || $movement->id_courier == 0)
                                                <option value="0" selected>Sin repartidor</option>
                                            @else
                                                <option value="0">Sin repartidor</option>
                                            @endif
                                            @foreach ($couriers as $courier)
                                            @if( $courier[0] == $movement->id_courier )
                                                <option value="{{ $courier[0] }}" selected>{{ $courier[1] }}</option>
                                            @else
                                                <option value="{{ $courier[0] }}">{{ $courier[1] }}</option>
                                            @endif
                                            @endforeach
                                            </select>
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

            conceptType();

            $('#tipo_movimiento').on('change', () =>
            {
                $('#tipo').val(`${ $('#tipo_movimiento').val() }`)
            });

            $('#concepto').on('change', () =>
            {
                conceptType();
            });
        });

        function conceptType() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ url("/flujo/concepto") }}',
                type: 'POST',
                dataType: 'json',
                data: { id: $('#concepto').val() },
            })
            .done(response => {
                if (response.repartidor)
                {
                    $('#courier_input').show();
                    $('#tipo_movimiento').prop('disabled', true);
                    if (response.tipo == 1)
                    {
                        $('#tipo_movimiento').val('1');
                        $('#tipo').val('1');
                    }
                    else
                    {
                        $('#tipo_movimiento').val('2');
                        $('#tipo').val('2');
                    }
                }
                else
                {
                    $('#tipo_movimiento').prop('disabled', false);
                    $('#tipo_movimiento').val('1');
                    $('#tipo').val('1');
                    $('#repartidor').val('0').trigger('change');
                    $('#courier_input').hide();
                }
            });
        }
    </script>

@endsection

@endsection

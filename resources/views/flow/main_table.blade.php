@extends('base.layouts.app')

@section('content')
    
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-2">
                <div class="col-sm-4">
                    <h1 style="font-size: 40px;">{{ $title }}</h1>
                </div>
                <div class="col-sm-8">
                    <div class="card padding-5">
                        <div class="card-body">
                            <div class="table-responsive text-center">
                                <table class="bg-white table table-bordered nowrap rounded shadow-xs border-xs" cellspacing="0">
                                    <thead>
                                        <tr>
                                        @foreach ($accounts as $account)
                                            <th>{{ $account->name }}</th>
                                        @endforeach
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        @php($total = 0)
                                        @foreach ($accounts as $account)
                                            <th>${{ $account->amount }}</th>
                                            @php($total += $account->amount)
                                        @endforeach
                                            <th>${{ $total }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mb3"></div>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <p class="lead mb-0">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <h5 style="font-weight: bold;">Periodo</h5>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h5 style="font-weight: bold;">De:</h5>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                </div>
                                                                <input type="date" class="form-control filterDate" data-inputmask-alias="datetime"
                                                                        data-inputmask-inputformat="yyyy/mm/dd" data-mask id="fechaInicio">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <h5 style="font-weight: bold;">A:</h5>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                </div>
                                                                <input type="date" class="form-control filterDate" data-inputmask-alias="datetime"
                                                                        data-inputmask-inputformat="yyyy/mm/dd" data-mask id="fechaFin">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-secondary" id="btnLimpiar">
                                                    Limpiar 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2"> 
                                        <a id="registerPaid" href="{{ url( '/flujo/create') }}" class="btn btn-secondary float-right">Agregar Movimiento</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="tablaUsuarios" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Concepto</th>
                                            <th>Detalle</th>
                                            <th>Cuenta</th>
                                            <th>Fecha</th>
                                            <th>Cargo</th>
                                            <th>Abono</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="flowTableBody">
                                    @foreach ($movements as $movement)
                                        <tr>
                                            <td>{{ $movement[0] }}</td>
                                            <td>{{ $movement[1] }}</td>
                                            <td>{{ $movement[2] }}</td>
                                            <td>{{ $movement[3] }}</td>
                                            <td>{{ $movement[4] }}</td>
                                            <td>{{ $movement[5] }}</td>
                                            <td>${{ $movement[6] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>             
            </div>
        </div>
    </div>

@section('script')

    <script type="text/javascript">
        
        $(document).ready(function () 
        {
            var dtFlow = null;

            dtFlow = $('#tablaUsuarios').DataTable(
            {
                'responsive': true,
                'lengthChange': false,
                'autoWidth': false,
                'responsive': true,
                'buttons': ['excel', 'pdf', 'colvis']
            });
            
            dtFlow
            .buttons()
            .container()
            .appendTo('#tablaUsuarios_wrapper .col-md-6:eq(0)');

            $('.filterDate').on('change', function () {
                
                let fechaI = $('#fechaInicio').val();
                let fechaF = $('#fechaFin').val();

                let data = 
                {
                    fechaInicio: fechaI,
                    fechaFin: fechaF,
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/flujo/filtro") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                })
                .done(response => {
                    if (dtFlow != null)
                        dtFlow.destroy();
                    
                    $('#flowTableBody').html('');

                    let movimientos = response.movements;

                    movimientos.forEach(movimiento => {
                        let plantilla = 
                        `
                            <tr>
                                <td>${ movimiento[0] }</td>
                                <td>${ movimiento[1] }</td>
                                <td>${ movimiento[2] }</td>
                                <td>${ movimiento[3] }</td>
                                <td>${ movimiento[4] }</td>
                                <td>${ movimiento[5] }</td>
                                <td>${ movimiento[6] }</td>
                            </tr>
                        `;

                        $('#flowTableBody').append(plantilla);
                    });

                    dtFlow = $('#tablaUsuarios').DataTable(
                    {
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,
                        'buttons': ['excel', 'pdf', 'colvis']
                    });

                    dtFlow
                    .buttons()
                    .container()
                    .appendTo('#tablaUsuarios_wrapper .col-md-6:eq(0)');
                
                });
            });
            
            $('#btnLimpiar').click(event => {

                $('#fechaInicio').val('');
                $('#fechaFin').val('');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/flujo/filtro") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { },
                })
                .done(response => {
                    if (dtFlow != null)
                        dtFlow.destroy();
                    
                    $('#flowTableBody').html('');

                    let movimientos = response.movements;

                    movimientos.forEach(movimiento => {
                        let plantilla = 
                        `
                            <tr>
                                <td>${ movimiento[0] }</td>
                                <td>${ movimiento[1] }</td>
                                <td>${ movimiento[2] }</td>
                                <td>${ movimiento[3] }</td>
                                <td>${ movimiento[4] }</td>
                                <td>${ movimiento[5] }</td>
                                <td>${ movimiento[6] }</td>
                            </tr>
                        `;

                        $('#flowTableBody').append(plantilla);
                    });

                    dtFlow = $('#tablaUsuarios').DataTable(
                    {
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,
                        'buttons': ['excel', 'pdf', 'colvis']
                    });

                    dtFlow
                    .buttons()
                    .container()
                    .appendTo('#tablaUsuarios_wrapper .col-md-6:eq(0)');
                
                });
            });

        });

    </script>

@endsection

@endsection

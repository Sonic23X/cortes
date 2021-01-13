@extends('base.layouts.app')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-2">
                <div class="col-sm-5">
                    <h1 style="font-size: 40px;">{{ $title }} de '{{ $account->name }}'</h1>
                </div>
                <div class="col-sm-7">
                    <div class="card padding-5">
                        <div class="card-body">
                            <div class="table-responsive text-center">
                                <table class="bg-white table table-bordered nowrap rounded shadow-xs border-xs" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>${{ $account->amount }}</th>
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
                                        <a href="{{ url( '/flujo') }}" class="btn btn-secondary float-right">Atrás</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="tablaFlow" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Concepto</th>
                                            <th>Detalle</th>
                                            <th>Egreso</th>
                                            <th>Ingreso</th>
                                            <th>Saldo</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="flowTableBody">
                                    @foreach ($movements as $movement)
                                        <tr>
                                            <td>{{ $movement[2] }}</td>
                                            <td>{{ $movement[0] }}</td>
                                            <td>{{ $movement[1] }}</td>
                                            <td>{{ $movement[3] }}</td>
                                            <td>{{ $movement[4] }}</td>
                                            <td>${{ $movement[5] }}</td>
                                            <td>
                                                <a href="{{ url('/flujo/' . $movement[6] .'/edit') }}" class="text-primary" style="cursor:pointer;">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a onclick="removeRow({{ $movement[6] }})" class="text-danger" style="cursor:pointer;">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </td>
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

            dtFlow = $('#tablaFlow').DataTable(
            {
                'ordering': false,
                'responsive': true,
                'lengthChange': false,
                'autoWidth': false,
                'responsive': true,
                'bInfo' : false,
                'pageLength': 10,
                'buttons': ['excel', 'pdf', 'colvis']
            });

            dtFlow
            .buttons()
            .container()
            .appendTo('#tablaFlow_wrapper .col-md-6:eq(0)');

            $('.filterDate').on('change', function () {

                let fechaI = $('#fechaInicio').val();
                let fechaF = $('#fechaFin').val();

                let data =
                {
                    fechaInicio: fechaI,
                    fechaFin: fechaF,
                    cuenta: {{ $account->id }}
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/flujo/filtro/cuenta") }}',
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
                                <td>${ movimiento[3] }</td>
                                <td>${ movimiento[0] }</td>
                                <td>${ (movimiento[1] == null) ? '' : movimiento[1] }</td>
                                <td>${ movimiento[2] }</td>
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
                    url: '{{ url("/flujo/filtro/cuenta") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { cuenta: {{ $account->id }}, },
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
                                <td>${ movimiento[3] }</td>
                                <td>${ movimiento[0] }</td>
                                <td>${ (movimiento[1] == null) ? '' : movimiento[1] }</td>
                                <td>${ movimiento[2] }</td>
                                <td>${ movimiento[4] }</td>
                                <td>${ movimiento[5] }</td>
                                <td>${ movimiento[6] }</td>
                            </tr>
                        `;

                        $('#flowTableBody').append(plantilla);
                    });

                    dtFlow = $('#tablaFlow').DataTable(
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
                    .appendTo('#tablaFlow_wrapper .col-md-6:eq(0)');

                });
            });

        });

        function removeRow(id) {

            let confirmacion = confirm('¿Estas seguro de eliminar el registro?');

            if (confirmacion)
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: `{{ url("/flujo") }}/${id}` ,
                    type: 'DELETE',
                    dataType: 'json',
                })
                .done(response => {
                    console.log(response);
                    location.reload();
                })
                .always(function (response, textStatus, jqXHR) {
                    if(jqXHR.status != 200)
                        alert(response.responseJSON.message);
                });
            }
        }

    </script>

@endsection

@endsection

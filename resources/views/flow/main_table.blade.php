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
                                            <div class="col-sm">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <h5 style="font-weight: bold;">De:</h5>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                                </div>
                                                                <input id="min" class="date form-control" data-inputmask-alias="datetime"
                                                                        data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm">
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
                                                                <input type="max" class="date form-control" data-inputmask-alias="datetime"
                                                                        data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2"> 
                                        <a id="registerPaid" href="{{ url( '/flujo/create') }}" class="btn btn-secondary float-right">Agregar Depósito</a>
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
                                    <tbody>
                                    @foreach ($movements as $movement)
                                        <tr>
                                        @switch($movement->concept)
                                            @case(1)
                                                <td>Pago a Repartidor</td>
                                                @break
                                            @case(2)
                                                <td>Pago a Urbo</td>
                                                @break
                                            @case(3)
                                                <td>Cobrado por el Repartidor</td>
                                                @break
                                            @case(4)
                                                <td>Saldo Inicial</td>
                                                @break
                                        @endswitch
                                            <td>{{ $movement->details }}</td>
                                            <td>{{ $movement->id_account }}</td>
                                            <td>{{ $movement->date }}</td>

                                        @switch($movement->type)
                                            @case('cargo')
                                                <td>${{ $movement->amount }}</td>
                                                <td>-</td>
                                                <td>${{ $movement->balance }}</td>
                                                @break
                                            @case('abono')
                                                <td>-</td>
                                                <td>${{ $movement->amount }}</td>
                                                <td>${{ $movement->balance }}</td>
                                                @break
                                        @endswitch
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="text-align: center;">
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>TOTAL</th>
                                            <th>$1500.00</th>
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

@section('script')


    <script type="text/javascript">
        $(document).ready(function () 
        {
            
            $('#tablaUsuarios').DataTable(
            {
                'responsive': true,
                'lengthChange': false,
                'autoWidth': false,
                'responsive': true,
                'buttons': ['excel', 'pdf', 'colvis']
            })
            .buttons()
            .container()
            .appendTo('#tablaUsuarios_wrapper .col-md-6:eq(0)');

        });
    </script>
    <script>
        $(document).ready(function () {
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min').datepicker('getDate');
                    var max = $('#max').datepicker('getDate');
                    var startDate = new Date(data[4]);
                    if (min == null && max == null) return true;
                    if (min == null && startDate <= max) return true;
                    if (max == null && startDate >= min) return true;
                    if (startDate <= max && startDate >= min) return true;
                    return false;
                }
            );

            $('#min').datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $('#max').datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            var table = $('#tablaUsuarios').DataTable();

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
        });
    </script>

@endsection

@endsection

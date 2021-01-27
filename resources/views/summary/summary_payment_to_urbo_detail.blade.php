@extends('base.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Pagos hechos al repartidor {{ $courier->name }} {{ $courier->last_name }}</h3>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ url( '/resumen') }}" class="btn btn-secondary">Atrás</a>
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
                            <p class="lead mb-0">
                                <div class="row">
                                    <div class="col-sm-12">
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
                                                    <button class="btn btn-secondary btn-block" id="btnLimpiar">
                                                        Limpiar 
                                                    </button>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
                                </div>
                            </p>

                            <table id="tablaPagosAUrbo" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Cuenta / Pedido</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaPagosAUrboBody">
                                    @php( $total = 0 )
                                    @foreach($columns1 as $column)
                                    <tr>
                                        <td>{{ $column[1] }}</td>
                                        <td>{{ $column[2] }}</td>
                                        <td>${{ $column[3] }}</td>
                                        @php( $total += $column[3] )
                                    </tr>
                                    @endforeach
                                    
                                    @foreach($columns2 as $column)
                                    <tr>
                                        <td>{{ $column[1] }}</td>
                                        <td>{!! $column[2] !!}</td>
                                        <td>${{ $column[3] }}</td>
                                        @php( $total += $column[3] )
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th id="saldoTotal">${{ $total }}</th>
                                    </tr>
                                </tfoot>
                            </table>
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
            var dtToUrbo = null;

            dtToUrbo = $("#tablaPagosAUrbo").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "responsive": true,
                'bInfo' : false,
                'pageLength': 10,
                'order': [[0, 'asc']],
                "buttons": ['excel', 'pdf']
            });
            dtToUrbo.buttons().container().appendTo('#tablaPagosAUrbo_wrapper .col-md-6:eq(0)');

            $('.filterDate').on('change', function () {
                
                let fechaI = $('#fechaInicio').val();
                let fechaF = $('#fechaFin').val();

                let data = 
                {
                    fechaInicio: fechaI,
                    fechaFin: fechaF,
                    repartidor: {{ $courier->id }}
                };

                $.ajaxSetup({
                    headers: {  
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/resumen/pagosurbo/filtros") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                })
                .done(response => {
                    if (dtToUrbo != null)
                        dtToUrbo.destroy();
                    
                    $('#tablaPagosAUrboBody').html('');

                    let detalles = response.detalles;
                    let total = 0;

                    detalles.forEach(detalle => {
                        let plantilla = 
                        `
                            <tr>
                                <td>${ detalle[1] }</td>
                                <td>${ detalle[2] }</td>
                                <td>$${ detalle[3] }</td>
                            </tr>
                        `;
                        total += detalle[3];
                        $('#tablaPagosAUrboBody').append(plantilla);
                    });

                    $('#saldoTotal').html('$' + total);

                    dtToUrbo = $('#tablaPagosAUrbo').DataTable(
                    {
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,        
                        'bInfo' : false,
                        'pageLength': 10,
                        'buttons': ['excel', 'pdf']
                    });
                    dtToUrbo.buttons().container().appendTo('#tablaPagosAUrbo_wrapper .col-md-6:eq(0)');
                
                });
            });

            $('#btnLimpiar').click(event => {

                $('#fechaInicio').val('');
                $('#fechaFin').val('');

                let data = 
                {
                    repartidor: {{ $courier->id }}
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/resumen/pagosurbo/filtros") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                })
                .done(response => {
                    if (dtToUrbo != null)
                        dtToUrbo.destroy();
                    
                    $('#tablaPagosAUrboBody').html('');

                    let detalles = response.detalles;
                    let total = 0;

                    detalles.forEach(detalle => {
                        let plantilla = 
                        `
                            <tr>
                                <td>${ detalle[1] }</td>
                                <td>${ detalle[2] }</td>
                                <td>$${ detalle[3] }</td>
                            </tr>
                        `;
                        total += detalle[3];
                        $('#tablaPagosAUrboBody').append(plantilla);
                    });

                    $('#saldoTotal').html('$' + total);

                    dtToUrbo = $('#tablaPagosAUrbo').DataTable(
                    {
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,        
                        'bInfo' : false,
                        'pageLength': 10,
                        'buttons': ['excel', 'pdf']
                    });
                    dtToUrbo.buttons().container().appendTo('#tablaPagosAUrbo_wrapper .col-md-6:eq(0)');
                
                });

            });
        });
    </script>

@endsection

@endsection

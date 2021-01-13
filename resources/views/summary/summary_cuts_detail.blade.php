@extends('base.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Detalle Pedidos Cobrados de {{ $courier->name }} {{ $courier->last_name }} </h3>
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

                            <table id="tablaDetallesCorte" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre del corte</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaDetallesCorteBody">
                                    @php( $total = 0 )
                                    @foreach($cortes as $corte)
                                    <tr id="corte_{{ $corte->id }}">
                                        <td>
                                            <a onclick="removeCorte({{ $corte->id }}, {{ $corte->amount }})" class="text-danger">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-4"></div>
                                                <div id="name_{{ $corte->id }}" class="col-sm-4">{{ $corte->name }}</div>
                                                <div class="col-sm-4">
                                                    <a onclick="editCorteName({{ $corte->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-4"></div>
                                                <div id="monto_{{ $corte->id }}" class="col-sm-4">${{ $corte->amount }}</div>
                                                <div class="col-sm-4">
                                                    <a onclick="editCorteAmount({{ $corte->id }}, {{ $corte->amount }})">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        @php( $total += $corte->amount )
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Total</th>
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

    <div class="modal fade" id="montoModal" tabindex="-1" aria-labelledby="montoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="montoModalLabel">Actualizar monto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="montoForm" method="POST">
                        <input type="hidden" id="montoId" name="montoId">
                        <input type="hidden" id="montoprevio" name="montoprevio">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>Monto</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="number" class="form-control" placeholder="Monto" id="monto" name="monto" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input type="password" class="form-control" placeholder="Contraseña" id="password" name="password" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Cancelar
                                </button>
                                <button type="submit" class="btn btn-success">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="nameModal" tabindex="-1" aria-labelledby="nameModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nameModalLabel">Actualizar nombre de corte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="nameForm" method="POST">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" id="nameId" name="nameId">
                                <div class="form-group">
                                    <label>Nombre del corte</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-cut"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Nombre del corte" id="name" name="name" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Cancelar
                                </button>
                                <button type="submit" class="btn btn-success">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@section('script')

    <script type="text/javascript">
        var dtCortes = null;
        var saldo_total = {{ $total }};

        $(document).ready(function ()
        {
            dtCortes = $("#tablaDetallesCorte").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "responsive": true,
                'bInfo' : false,
                'pageLength': 10,
                "buttons": ['excel', 'pdf']
            });
            dtCortes.buttons().container().appendTo('#tablaDetallesCorte_wrapper .col-md-6:eq(0)');

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
                    url: '{{ url("/resumen/cortes/filtros") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                })
                .done(response => {
                    if (dtCortes != null)
                        dtCortes.destroy();
                    
                    $('#tablaDetallesCorteBody').html('');

                    let cortes = response.cortes;
                    let total = 0;

                    cortes.forEach(corte => {
                        let plantilla = 
                        `
                            <tr id="corte_${corte.id}">
                                <td>
                                    <a onclick="removeCorte(${corte.id}, ${corte.amount})" class="text-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-4"></div>
                                        <div id="name_${corte.id}" class="col-sm-4">${ corte.name }</div>
                                        <div class="col-sm-4">
                                            <a onclick="editCorteName(${corte.id})">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-4"></div>
                                        <div id="monto_${corte.id }" class="col-sm-4">$${ corte.amount }</div>
                                        <div class="col-sm-4">
                                            <a onclick="editCorteAmount(${corte.id}, ${corte.amount})">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;
                        total += corte.amount;
                        $('#tablaDetallesCorteBody').append(plantilla);
                    });

                    $('#saldoTotal').html('$' + total);
                    saldo_total = total;

                    dtCortes = $('#tablaDetallesCorte').DataTable(
                    {
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,        
                        'bInfo' : false,
                        'pageLength': 10,
                        'buttons': ['excel', 'pdf']
                    });
                    dtCortes.buttons().container().appendTo('#tablaDetallesCorte_wrapper .col-md-6:eq(0)');
                
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
                    url: '{{ url("/resumen/cortes/filtros") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                })
                .done(response => {
                    if (dtCortes != null)
                        dtCortes.destroy();
                    
                    $('#tablaDetallesCorteBody').html('');

                    let cortes = response.cortes;
                    let total = 0;

                    cortes.forEach(corte => {
                        let plantilla = 
                        `
                            <tr id="corte_${corte.id}">
                                <td>
                                    <a onclick="removeCorte(${corte.id}, ${corte.amount})" class="text-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-4"></div>
                                        <div id="name_${corte.id}" class="col-sm-4">${ corte.name }</div>
                                        <div class="col-sm-4">
                                            <a onclick="editCorteName(${corte.id})">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-4"></div>
                                        <div id="monto_${corte.id }" class="col-sm-4">$${ corte.amount }</div>
                                        <div class="col-sm-4">
                                            <a onclick="editCorteAmount(${corte.id}, ${corte.amount})">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;

                        total += corte.amount;
                        $('#tablaDetallesCorteBody').append(plantilla);
                    });

                    $('#saldoTotal').html('$' + total);
                    saldo_total = total;

                    dtCortes = $('#tablaDetallesCorte').DataTable(
                    {
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,        
                        'bInfo' : false,
                        'pageLength': 10,
                        'buttons': ['excel', 'pdf']
                    });
                    dtCortes.buttons().container().appendTo('#tablaDetallesCorte_wrapper .col-md-6:eq(0)');
                
                });
            });

            $('#montoForm').submit(event => {

                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/cortes/updatemonto") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: $('#montoId').val(), monto: $('#monto').val(), contrasena: $('#password').val() },
                })
                .done(response => {
                    alert( response.message );
                    $(`#monto_${$('#montoId').val()}`).html('$' + $('#monto').val());

                    console.log( saldo_total - parseFloat($('#montoprevio').val()) );

                    let saldoT = (saldo_total - parseFloat($('#montoprevio').val()) ) + parseFloat($('#monto').val());
                    $('#saldoTotal').html(`$${saldoT}`);

                    $('#montoModal').modal('hide');
                    $('#montoForm').trigger('reset');
                })
                .always(function (response, textStatus, jqXHR) {
                    if(jqXHR.status != 200) 
                        alert(response.responseJSON.message);
                });
            });

            $('#nameForm').submit(event => {

                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/cortes/updatenombre") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: $('#nameId').val(), nombre: $('#name').val() },
                })
                .done(response => {
                    alert( response.message );
                    $(`#name_${$('#nameId').val()}`).html(`${$('#name').val()}`);

                    if (dtCortes != null)
                        dtCortes.destroy();

                    dtCortes = $('#tablaDetallesCorte').DataTable({
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,        
                        'bInfo' : false,
                        'pageLength': 10,
                        'buttons': ['excel', 'pdf']
                    });
                    dtCortes.buttons().container().appendTo('#tablaDetallesCorte_wrapper .col-md-6:eq(0)');
                    
                    $('#nameModal').modal('hide');
                    $('#nameForm').trigger('reset');                    
                })
                .always(function (response, textStatus, jqXHR) {
                    if(jqXHR.status != 200) 
                        alert(response.responseJSON.message);
                });
            });

        });

        function removeCorte(id, monto)
        {
            let confirmacion = confirm('¿Estas seguro de eliminar el registro?');
            
            if (confirmacion) 
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: `{{ url("/corte") }}/${id}` ,
                    type: 'DELETE',
                    dataType: 'json',
                })
                .done(response => {
                    alert( response.message );
                    $(`#corte_${id}`).html('');
                    
                    saldo_total -= monto;
                    $('#saldoTotal').html('$' + saldo_total);
                })
                .always(function (response, textStatus, jqXHR) {
                    if(jqXHR.status != 200) 
                        alert(response.responseJSON.message);
                });
            }
        }

        function editCorteAmount(id, monto) 
        {
            $('#montoId').val(id);
            $('#montoprevio').val(monto);
            $('#montoModal').modal('show');
        }

        function editCorteName(id) 
        {
            $('#nameId').val(id);
            $('#nameModal').modal('show');
        }

    </script>

@endsection

@endsection

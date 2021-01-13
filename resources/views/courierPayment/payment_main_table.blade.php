@extends('base.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Listado de Pedidos Cobrados por el Repartidor</h3>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ url('pagos/create') }}" class="btn btn-secondary float-right">Registrar Pedido</a>
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
                            <table id="tablaPagos" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>No. Pedido</th>
                                        <th>Repartidor</th>
                                        <th>Monto</th>
                                        <th>Negocio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr id="payment_{{ $payment[0] }}">
                                        <td>
                                            <a onclick="removePayment({{ $payment[0] }})" class="text-danger">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-4"></div>
                                                <div class="col-sm-4" id="datePerCourier_{{ $payment[0] }}">
                                                    {{ $payment[1] }}
                                                </div>
                                                <div class="col-sm-4">
                                                    <a onclick="editPaymentDate({{ $payment[0] }})">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-4"></div>
                                                <div class="col-sm-4" id="orderPerCourier_{{ $payment[0] }}">
                                                    {{ $payment[2] }}
                                                </div>
                                                <div class="col-sm-4">
                                                    <a onclick="editPaymentOrder({{ $payment[0] }})">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-4"></div>
                                                <div class="col-sm-4" id="courier_{{ $payment[0] }}">
                                                    {{ $payment[3] }}
                                                </div>
                                                <div class="col-sm-4">
                                                    <a onclick="editPaymentCourier({{ $payment[0] }})">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-4"></div>
                                                <div id="montoPerCourier_{{ $payment[0] }}" class="col-sm-4">${{ $payment[4] }}</div>
                                                <div class="col-sm-4">
                                                    <a onclick="editPaymentAmount({{ $payment[0] }})">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-4"></div>
                                                <div class="col-sm-4" id="shopPerCourier_{{ $payment[0] }}">
                                                    {{ $payment[5] }}
                                                </div>
                                                <div class="col-sm-4">
                                                    <a onclick="editPaymentShop({{ $payment[0] }})">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>No. Pedido</th>
                                        <th>Repartidor</th>
                                        <th>Monto</th>
                                        <th>Negocio</th>
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
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" id="montoId" name="montoId">
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

    <div class="modal fade" id="shopModal" tabindex="-1" aria-labelledby="shopModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shopModalLabel">Actualizar tienda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="shopForm" method="POST">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" id="shopId" name="shopId">
                                <div class="form-group">
                                    <label>Negocio</label>
                                    <select class="form-control select2" name="negocio" id="negocio">
                                        @foreach ($places as $place)
                                            <option value="{{ $place->id }}">{{ $place->name }}</option>
                                        @endforeach
                                    </select>
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

    <div class="modal fade" id="courierModal" tabindex="-1" aria-labelledby="courierModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="courierModalLabel">Actualizar repartidor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="courierForm" method="POST">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" id="courierId" name="courierId">
                                <div class="form-group">
                                    <label>Repartidor</label>
                                    <select class="form-control select2" name="repartidorForm" id="repartidorForm">
                                        @foreach ($couriers as $courier)
                                            <option value="{{ $courier->id }}">{{ $courier->name }} {{ $courier->last_name }}</option>
                                        @endforeach
                                    </select>
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

    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Actualizar pedido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="orderForm" method="POST">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" id="orderId" name="orderId">
                                <div class="form-group">
                                    <label>Pedido</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-truck-loading"></i></span>
                                        </div>
                                        <input type="number" class="form-control" placeholder="No. Pedido" name="pedido" id="pedido">
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

    <div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateModalLabel">Actualizar fecha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="dateForm" method="POST">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" id="dateId" name="dateId">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" name="fecha" id="fecha">
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

        var dtPagos = null;

        $(document).ready(function () {

            dtPagos = $("#tablaPagos").DataTable({
                'responsive': true,
                'lengthChange': false,
                'autoWidth': false,
                'responsive': true,
                'bInfo' : false,
                'pageLength': 10,
                'buttons': ['excel', 'pdf', 'colvis']
            });
            dtPagos.buttons().container().appendTo('#tablaPagos_wrapper .col-md-6:eq(0)');

            $('.select2').select2({
                theme: 'bootstrap4',
            });

            $('#montoForm').submit(event => {

                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/pagos/updatemonto") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: $('#montoId').val(), monto: $('#monto').val(), contrasena: $('#password').val() },
                })
                .done(response => {
                    alert( response.message );
                    $(`#montoPerCourier_${$('#montoId').val()}`).html('$' + $('#monto').val());
                    
                    if (dtPagos != null) 
                        dtPagos.destroy();

                    dtPagos = $("#tablaPagos").DataTable({
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,
                        'bInfo' : false,
                        'pageLength': 10,
                        'buttons': ['excel', 'pdf', 'colvis']
                    });
                    dtPagos.buttons().container().appendTo('#tablaPagos_wrapper .col-md-6:eq(0)');

                    $('#montoModal').modal('hide');
                    $('#montoForm').trigger('reset');
                })
                .always(function (response, textStatus, jqXHR) {
                    if(jqXHR.status != 200) 
                        alert(response.responseJSON.message);
                });
            });

            $('#shopForm').submit(event => {

                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/pagos/updatenegocio") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: $('#shopId').val(), place: $('#negocio').val() },
                })
                .done(response => {
                    alert( response.message );
                    $(`#shopPerCourier_${$('#shopId').val()}`).html(`${ response.place.name }`);
                    
                    if (dtPagos != null) 
                        dtPagos.destroy();

                    dtPagos = $("#tablaPagos").DataTable({
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,
                        'bInfo' : false,
                        'pageLength': 10,
                        'buttons': ['excel', 'pdf', 'colvis']
                    });
                    dtPagos.buttons().container().appendTo('#tablaPagos_wrapper .col-md-6:eq(0)');

                    $('#shopModal').modal('hide');
                    $('#shopForm').trigger('reset');
                })
                .always(function (response, textStatus, jqXHR) {
                    if(jqXHR.status != 200) 
                        alert(response.responseJSON.message);
                });

            });

            $('#courierForm').submit(event => {

                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/pagos/updaterepartidor") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: $('#courierId').val(), courier: $('#repartidorForm').val() },
                })
                .done(response => {
                    alert( response.message );
                    $(`#courier_${$('#courierId').val()}`).html(`${ response.courier.name + ' ' + response.courier.last_name }`);
                
                    if (dtPagos != null) 
                        dtPagos.destroy();

                    dtPagos = $("#tablaPagos").DataTable({
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,
                        'bInfo' : false,
                        'pageLength': 10,
                        'buttons': ['excel', 'pdf', 'colvis']
                    });
                    dtPagos.buttons().container().appendTo('#tablaPagos_wrapper .col-md-6:eq(0)');

                    $('#courierModal').modal('hide');
                    $('#courierForm').trigger('reset');
                })
                .always(function (response, textStatus, jqXHR) {
                    if(jqXHR.status != 200) 
                        alert(response.responseJSON.message);
                });

            });

            $('#orderForm').submit(event => {

                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/pagos/updatepedido") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: $('#orderId').val(), order: $('#pedido').val() },
                })
                .done(response => {
                    alert( response.message );
                    $(`#orderPerCourier_${$('#orderId').val()}`).html(`${ $('#pedido').val() }`);

                    if (dtPagos != null) 
                        dtPagos.destroy();

                    dtPagos = $("#tablaPagos").DataTable({
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,
                        'bInfo' : false,
                        'pageLength': 10,
                        'buttons': ['excel', 'pdf', 'colvis']
                    });
                    dtPagos.buttons().container().appendTo('#tablaPagos_wrapper .col-md-6:eq(0)');

                    $('#orderModal').modal('hide');
                    $('#orderForm').trigger('reset');
                })
                .always(function (response, textStatus, jqXHR) {
                    if(jqXHR.status != 200) 
                        alert(response.responseJSON.message);
                });

            });

            $('#dateForm').submit(event => {

                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/pagos/updatefecha") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: $('#dateId').val(), date: $('#fecha').val() },
                })
                .done(response => {
                    alert( response.message );
                    $(`#datePerCourier_${$('#dateId').val()}`).html(`${ response.payment }`);
                    
                    if (dtPagos != null) 
                        dtPagos.destroy();

                    dtPagos = $("#tablaPagos").DataTable({
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,
                        'bInfo' : false,
                        'pageLength': 10,
                        'buttons': ['excel', 'pdf', 'colvis']
                    });
                    dtPagos.buttons().container().appendTo('#tablaPagos_wrapper .col-md-6:eq(0)');

                    $('#dateModal').modal('hide');
                    $('#dateForm').trigger('reset');
                })
                .always(function (response, textStatus, jqXHR) {
                    if(jqXHR.status != 200) 
                        alert(response.responseJSON.message);
                });

            });
        });

        function editPaymentAmount(id) 
        {
            $('#montoId').val(id);
            $('#montoModal').modal('show');
        }

        function editPaymentShop(id) 
        {
            $('#shopId').val(id);
            $('#shopModal').modal('show');
        }

        function editPaymentCourier(id) 
        {
            $('#courierId').val(id);
            $('#courierModal').modal('show');
        }

        function editPaymentOrder(id) 
        {
            $('#orderId').val(id);
            $('#orderModal').modal('show');
        }

        function editPaymentDate(id) 
        {
            $('#dateId').val(id);
            $('#dateModal').modal('show');
        }

        function removePayment(id) 
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
                    url: `{{ url("/pagos") }}/${id}` ,
                    type: 'DELETE',
                    dataType: 'json',
                })
                .done(response => {
                    alert( response.message );
                    $(`#payment_${id}`).html('');
                    
                    if (dtPagos != null) 
                        dtPagos.destroy();

                    dtPagos = $("#tablaPagos").DataTable({
                        'responsive': true,
                        'lengthChange': false,
                        'autoWidth': false,
                        'responsive': true,
                        'bInfo' : false,
                        'pageLength': 10,
                        'buttons': ['excel', 'pdf', 'colvis']
                    });
                    dtPagos.buttons().container().appendTo('#tablaPagos_wrapper .col-md-6:eq(0)');
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

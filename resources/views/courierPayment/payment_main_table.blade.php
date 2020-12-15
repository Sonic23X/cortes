@extends('base.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
            </div>
        </div>
    </section>


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h3 class="card-title">Listado de Pedidos Cobrados por el Repartidor</h3>
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ url('pagos/create') }}" class="btn btn-primary float-right">Registrar Pedido</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="tablaPagos" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>No. Pedido</th>
                                        <th>Repartidor</th>
                                        <th>Monto</th>
                                        <th>Negocio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td>{{ $payment[1] }}</td>
                                        <td>{{ $payment[2] }}</td>
                                        <td>{{ $payment[3] }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-4"></div>
                                                <div id="montoPerCourier_{{ $payment[0] }}" class="col-sm-4">${{ $payment[4] }}</div>
                                                <div class="col-sm-4">
                                                    <a onclick="editPaymentAmount({{ $payment[0] }})">
                                                        <i id="editPaymentAmount" class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $payment[5] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
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
        $(document).ready(function () {
            $("#tablaPagos").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "responsive": true,
                "buttons": ['excel', 'pdf', 'colvis']
            }).buttons().container().appendTo('#tablaPagos_wrapper .col-md-6:eq(0)');

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
                    data: { id: $('#montoId').val(), monto: $('#monto').val() },
                })
                .done(response => {
                    alert( response.message );
                    $(`#montoPerCourier_${$('#montoId').val()}`).html('$' + $('#monto').val());
                    $('#montoModal').modal('hide');
                });
            });
        });

        function editPaymentAmount(id) 
        {
            $('#montoId').val(id);
            $('#montoModal').modal('show');
        }
    </script>

@endsection

@endsection

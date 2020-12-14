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
                                        <th>Tipo de Pago</th>
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
                                                <div id="noTerminal" class="col-sm-4">${{ $payment[4] }}</div>
                                                <div class="col-sm-4">
                                                    <a href="#" onclick="editPaymentAmount()"><i id="editPaymentAmount"
                                                                                                class="fas fa-edit"></i></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $payment[5] }}</td>
                                        <td>{{ $payment[6] }}</td>
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
                                        <th>Tipo de Pago</th>
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
        $(document).ready(function () {
            $("#tablaPagos").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "responsive": true,
                "buttons": ['excel', 'pdf', 'colvis']
            }).buttons().container().appendTo('#tablaPagos_wrapper .col-md-6:eq(0)');
        });
    </script>

@endsection

@endsection

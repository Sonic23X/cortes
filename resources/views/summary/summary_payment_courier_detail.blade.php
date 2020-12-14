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
                                    <h3 class="card-title">Detalle Pedidos Cobrados de $repartidor </h3>
                                </div>
                                <div class="col-sm-4"> <a id="registerUser" href="#" class="btn btn-primary btn-sm float-right"
                                                          onclick="registrarUsuario()">Registrar</a></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaPagosCobradosRepartidor" class="table table-bordered table-striped">
                                <thead>
                                <tr style="text-align: center;">
                                    <th>Fecha</th>
                                    <th>No. Pedido</th>
                                    <th>Negocio</th>
                                    <th>Monto</th>
                                    <th>Tipo de Pago</th>
                                </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                <tr>
                                    <td>14/11/2020</td>
                                    <td>2548</td>
                                    <td>Oiishi Roll</td>
                                    <td>$145.00</td>
                                    <td>Efectivo</td>
                                </tr>
                                <tr>
                                    <td>14/11/2020</td>
                                    <td>2548</td>
                                    <td>Oiishi Roll</td>
                                    <td>$145.00</td>
                                    <td>Efectivo</td>
                                </tr>
                                <tr>
                                    <td>14/11/2020</td>
                                    <td>2548</td>
                                    <td>Oiishi Roll</td>
                                    <td>$145.00</td>
                                    <td>Efectivo</td>
                                </tr>
                                <tr>
                                    <td>14/11/2020</td>
                                    <td>2548</td>
                                    <td>Oiishi Roll</td>
                                    <td>$145.00</td>
                                    <td>Efectivo</td>
                                </tr>

                                </tbody>
                                <tfoot>
                                <tr style="text-align: center;">
                                    <th>Fecha</th>
                                    <th>No. Pedido</th>
                                    <th>Negocio</th>
                                    <th>Monto</th>
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
        $(document).ready(function ()
        {
            $("#tablaPagosCobradosRepartidor").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "responsive": true,
                "buttons": ['excel', 'pdf', 'colvis']
            }).buttons().container().appendTo('#tablaPagosCobradosRepartidor_wrapper .col-md-6:eq(0)');
        });
    </script>

@endsection

@endsection

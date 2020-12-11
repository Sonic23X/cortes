@extends('base.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
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
                                    <h3 class="card-title">Detalle de Cortes de $repartidor </h3>
                                </div>
                                <div class="col-sm-4"> <a id="registerUser" href="#" class="btn btn-primary btn-sm float-right"
                                                          onclick="registrarUsuario()">Registrar</a></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaDetallesCorte" class="table table-bordered table-striped">
                                <thead>
                                <tr style="text-align: center;">
                                    <th>Nombre del corte</th>
                                    <th>Monto</th>
                                </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                <tr>
                                    <td>Del 1 al 30 de Noviembre</td>
                                    <td>$145.00</td>
                                </tr>
                                <tr>
                                    <td>Del 15 al 30 de Diciembre</td>
                                    <td>$145.00</td>
                                </tr>
                                <tr>
                                    <td>Del 2 al 7 de Diciembre</td>
                                    <td>$145.00</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr style="text-align: center;">
                                    <th>Corte</th>
                                    <th>Monto</th>>
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
            $("#tablaDetallesCorte").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "responsive": true,
                "buttons": ['excel', 'pdf', 'colvis']
            }).buttons().container().appendTo('#tablaDetallesCorte_wrapper .col-md-6:eq(0)');
        });
    </script>

@endsection

@endsection

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
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <p class="lead mb-0">
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
                                                    <input type="date" class="form-control" data-inputmask-alias="datetime"
                                                           data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                                </div>
                                                <!-- /.input group -->
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
                                                    <input type="date" class="form-control" data-inputmask-alias="datetime"
                                                           data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2"><button type="button" class="btn btn-primary" data-toggle="modal"
                                                      data-target="#corteModal">
                                CORTE
                            </button></div>
                    </div>
                    </p>

                    <!--MODAL-->
                    <div class="modal fade" id="corteModal" tabindex="-1" role="dialog" aria-labelledby="corteModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="corteModalLabel">Registrar Corte</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Nombre del Corte</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-cut"></i></span>
                                                        </div>
                                                        <input type="number" class="form-control" placeholder="No. Pedido">
                                                    </div>
                                                </div>
                                                <!-- /.form-group -->

                                                <div class="form-group">
                                                    <label>Repartidor</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" placeholder="autocomplete Repartidor">
                                                    </div>
                                                </div>
                                                <!-- /.form-group -->

                                                <div class="form-group">
                                                    <label>Cantidad Total de Corte</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="number" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">.00</span>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <!-- /.col -->
                                        </div>

                                        <!-- /.row -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary">Registrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--CLOSE MODAL-->


                    <table id="tablaResumen" class="table table-bordered table-striped">
                        <thead>
                        <tr style="text-align: center;">
                            <th>Repartidor</th>
                            <th>Pedidos Cobrados</th>
                            <th>Pagos Hechos a Urbo</th>
                            <th>Pagos al Repartidor</th>
                            <th>Cortes</th>
                            <th>Saldo Total</th>
                        </tr>
                        </thead>
                        <tbody style="text-align: center;">
                        <tr>
                            <td>Eduardo Ortega</td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>$7925.00</td>
                        </tr>
                        <tr>
                            <td>Emilio Waldo
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>$7925.00</td>
                        </tr>
                        <tr>
                            <td>Eduardo Silva
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>$7925.00</td>
                        </tr>
                        <tr>
                            <td>Enrique Pérez
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div id="noTerminal" class="col-sm-6">$3255.00</div>
                                    <div class="col-sm-4">
                                        <a href="#"><i class="fas fa-info-circle"></i></a></div>
                                </div>
                            </td>
                            <td>$7925.00</td>
                        </tr>

                        </tbody>
                        <tfoot>
                        <tr style="text-align: center;">
                            <th>Repartidor</th>
                            <th>Pedidos Cobrados</th>
                            <th>Pagos Hechos a Urbo</th>
                            <th>Pagos al Repartidor</th>
                            <th>Cortes</th>
                            <th>Saldo Total</th>
                        </tr>
                        </tfoot>
                    </table>


                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>


@section('script')

    <script type="text/javascript">
        $(document).ready(function ()
        {
            $("#tablaResumen").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "responsive": true,
                "buttons": ['excel', 'pdf', 'colvis']
            }).buttons().container().appendTo('#tablaResumen_wrapper .col-md-6:eq(0)');
        });
    </script>

@endsection

@endsection

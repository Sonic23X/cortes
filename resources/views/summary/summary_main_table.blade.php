@extends('base.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#corteModal">
                            Crear corte
                        </button>
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
                            <table id="tablaResumen" class="table table-bordered table-striped">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th>Repartidor</th>
                                        <th>Pedidos Cobrados</th>
                                        <th>Pagos del repartidor a Urbo</th>
                                        <th>Pagos de Urbo a repartidor</th>
                                        <th>Cortes</th>
                                        <th>Saldo Total</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                    @foreach($columns as $column)
                                    <tr>
                                        <td>{{ $column[1] }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-2"></div>
                                                <div id="noTerminal" class="col-sm-6">${{ $column[2] }}</div>
                                                <div class="col-sm-4">
                                                    <a href="{{ url('/resumen/pedidoscobrados/'.$column[0]  ) }}"><i class="fas fa-info-circle"></i></a></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-2"></div>
                                                <div id="noTerminal" class="col-sm-6">${{ $column[3] }}</div>
                                                <div class="col-sm-4">
                                                    <a href="{{ url('/resumen/pagosurbo/'.$column[0]  ) }}"><i class="fas fa-info-circle"></i></a></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-2"></div>
                                                <div id="noTerminal" class="col-sm-6">${{ $column[4] }}</div>
                                                <div class="col-sm-4">
                                                    <a href="{{ url('/resumen/pagosrepartido/'.$column[0]  ) }}"><i class="fas fa-info-circle"></i></a></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-2"></div>
                                                <div id="noTerminal" class="col-sm-6">${{ $column[5] }}</div>
                                                <div class="col-sm-4">
                                                    <a href="{{ url('/resumen/cortes/'.$column[0]  ) }}"><i class="fas fa-info-circle"></i></a></div>
                                            </div>
                                        </td>
                                        <td>${{ $column[6] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="text-align: center;">
                                        <th>Repartidor</th>
                                        <th>Pedidos Cobrados</th>
                                        <th>Pagos del repartidor a Urbo</th>
                                        <th>Pagos de Urbo a repartidor</th>
                                        <th>Cortes</th>
                                        <th>Saldo Total</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="corteModal" tabindex="-1" role="dialog" aria-labelledby="corteModalLabel" aria-hidden="true">
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
                        <form method="POST" id="corteForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nombre del Corte</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-cut"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Nombre del corte" id="nombreCorte" name="nombreCorte" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Repartidor</label>
                                        <div class="input-group mb-3">
                                            <select name="repartidor" id="repartidor" class="custom-select select2">
                                            @foreach ($couriers as $courier)
                                                <option value="{{ $courier[0] }}">{{ $courier[1] }}</option>                                    
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Cantidad Total de Corte</label>
                                        <div class="input-group">|
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" name="montoCorte" id="montoCorte" required>
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
    </div>


@section('script')

    <script type="text/javascript">
        $(document).ready(function ()
        {
            dtSummary = null;

            dtSummary = $("#tablaResumen").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "responsive": true,
                'bInfo' : false,
                'pageLength': 10,
                "buttons": ['excel', 'pdf', 'colvis']
            })
            
            dtSummary.buttons().container().appendTo('#tablaResumen_wrapper .col-md-6:eq(0)');

            $('.select2').select2(
            {
                theme: 'bootstrap4',
            });

            $('#corteForm').submit( event =>
            {
                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/corte") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { 
                        nombre: $('#nombreCorte').val(), 
                        repartidor: $('#repartidor').val(), 
                        monto: $('#montoCorte').val() 
                    },
                })
                .done(response => {
                    alert( response.message );

                    $('#corteModal').modal('hide');
                    location.reload();
                    
                });

            });

        });
    </script>

@endsection

@endsection

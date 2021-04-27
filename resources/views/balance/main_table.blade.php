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
                        <button class="btn btn-secondary" disabled>
                            Saldo total: 
                                @php($total = 0)
                                @foreach($columns as $column)
                                @php($total += round($column[6], 2))
                                @endforeach
                            <span id="spanTotal">${{ $total }}</span>
                        </button>
                        <a type="button" class="btn btn-secondary" href="{{ url('/saldos/create') }}">
                            Nuevo historico
                        </a>
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
                        <div class="card-header">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="repartidorSwitch">
                                <label class="custom-control-label" for="repartidorSwitch" id="repartidorSwitchLabel">
                                    Todos los repartidores
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaMadero" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Repartidor</th>
                                        <th>Madero</th>
                                        <th>Acumulado de repartos</th>
                                        <th>Pagos a Urbo</th>
                                        <th>Pagos a Repartidor</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tablaMaderoBody">
                                @foreach($columns as $column)
                                    <tr>
                                        <td>{{ $column[1] }}</td>
                                        <td>${{ $column[2] }}</td>
                                        <td>${{ $column[3] }}</td>
                                        <td>${{ $column[4] }}</td>
                                        <td>${{ $column[5] }}</td>
                                        <td>${{ round($column[6], 2) }}</td>
                                        <td>
                                            <a href="{{ url('/saldos/' . $column[0] .'/edit') }}" class="text-primary" style="cursor:pointer;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
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
            let dtSummary = null;

            dtSummary = $("#tablaMadero").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "responsive": true,
                'bInfo' : false,
                'pageLength': 10,
                "buttons": ['excel', 'pdf', 'colvis']
            })
            
            dtSummary.buttons().container().appendTo('#tablaMadero_wrapper .col-md-6:eq(0)');

            $("#repartidorSwitch").on('change', function() 
            {
                if ($(this).is(':checked')) 
                {
                    $('#repartidorSwitchLabel').html('Solo repartidores activos');
                }
                else 
                {
                    $('#repartidorSwitchLabel').html('Todos los repartidores');
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/saldos/filtro") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { filtro: $(this).is(':checked') },
                })
                .done(response => 
                {
                    if (dtSummary != null) 
                        dtSummary.destroy();

                    $('#tablaMaderoBody').html('');

                    let total = 0;
                    response.pagos.forEach(element => 
                    {
                        if( element != null )
                        {
                            let url = `{{ url('/saldos/${element[0]}/edit') }}`;
                            let plantilla = 
                            `
                            <tr>
                                <td>${element[1]}</td>
                                <td>$${element[2]}</td>
                                <td>$${element[3]}</td>
                                <td>$${element[4]}</td>
                                <td>$${element[5]}</td>
                                <td>$${parseFloat(element[6]).toFixed(2)}</td>
                                <td>
                                    <a href="${url}" class="text-primary" style="cursor:pointer;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            `; 
                            
                            $('#tablaMaderoBody').append(plantilla);

                            total += parseFloat(`${element[6]}`);
                        }
                    });

                    $('#spanTotal').html(`$${parseFloat(total).toFixed(2)}`);

                    dtSummary = $("#tablaMadero").DataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        "responsive": true,
                        'bInfo' : false,
                        'pageLength': 10,
                        "buttons": ['excel', 'pdf', 'colvis']
                    });
            
                    dtSummary.buttons().container().appendTo('#tablaMadero_wrapper .col-md-6:eq(0)');
                })
                .always(function (response, textStatus, jqXHR) {
                    if(jqXHR.status != 200) 
                        alert(response.responseJSON.message);
                });
            });
        });
    </script>

@endsection

@endsection

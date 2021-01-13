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
                                <tbody>
                                @foreach($columns as $column)
                                    <tr>
                                        <td>{{ $column[1] }}</td>
                                        <td>${{ $column[2] }}</td>
                                        <td>${{ $column[3] }}</td>
                                        <td>${{ $column[4] }}</td>
                                        <td>${{ $column[5] }}</td>
                                        <td>${{ ($column[2] + $column[3]) -$column[4] + $column[5] }}</td>
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
        });
    </script>

@endsection

@endsection

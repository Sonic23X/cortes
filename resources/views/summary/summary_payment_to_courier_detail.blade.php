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
                                    <h3 class="card-title">Pagos hechos al repartidor {{ $courier->name }} {{ $courier->last_name }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tablaPagosAUrbo" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($columns as $column)
                                    <tr>
                                        <td>{{ $column->date }}</td>
                                        <td>${{ $column->amount }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Monto</th>
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
            $("#tablaPagosAUrbo").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "responsive": true,
                "buttons": ['excel', 'pdf', 'colvis']
            }).buttons().container().appendTo('#tablaPagosAUrbo_wrapper .col-md-6:eq(0)');
        });
    </script>

@endsection

@endsection
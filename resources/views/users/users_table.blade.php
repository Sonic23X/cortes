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
                                    <h3 class="card-title">Listado de Usuarios Registrados</h3>
                                </div>
                                <div class="col-sm-4"> 
                                    <a href="{{ url( '/usuarios/create') }}" class="btn btn-secondary float-right">Registrar</a>
                                </div>
                            </div>
                        </div>
                
                        <div class="card-body">
                            <table id="tablaUsuarios" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Terminal</th>
                                        <th>No. Terminal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($couriers as $courier)
                                        <tr>
                                            <td>
                                                {{ $courier->name }} {{ $courier->last_name }} 
                                                <input type="hidden" id="courier_{{ $courier->id }}" value="{{ $courier->id }}">
                                            </td>
                                            <td>{{ $courier->email }}</td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <input id="switchStatus" type="checkbox" class="custom-control-input"
                                                        @if($courier->status == 1) checked @endif>
                                                    <label id="labelStatus" class="custom-control-label" for="switchStatus">Activo</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="hasTerminal"
                                                        @if($courier->terminal != null) checked @endif>
                                                    <label class="custom-control-label" for="hasTerminal" id="hasTerminalLabel">Sí</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-4"></div>
                                                    <div id="noTerminal" class="col-sm-4">
                                                    @if($courier->terminal == null)
                                                        <span>Sin terminal</span>
                                                    @else
                                                        <span>{{ $courier->terminal }}</span>
                                                    @endif
                                                    </div>
                                                    <div class="col-sm-4">
                                                    @if($courier->terminal != null)
                                                        <a href="#" onclick="editTerminalNumber()"><i id="editNoTerminal"
                                                                class="fas fa-edit"></i></a>
                                                    @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Terminal</th>
                                        <th>No.Terminal</th>
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
            $("#tablaUsuarios").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "responsive": true,
                "buttons": ['excel', 'pdf', 'colvis']
            }).buttons().container().appendTo('#tablaUsuarios_wrapper .col-md-6:eq(0)');
        });
    </script>

@endsection

@endsection

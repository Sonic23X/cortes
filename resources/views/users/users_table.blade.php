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
                                                    <input id="switchStatus_{{ $courier->id }}" type="checkbox" class="custom-control-input"
                                                        onChange="changeStatus({{ $courier->id }})" @if($courier->status == 1) checked @endif>
                                                    <label id="labelStatus_{{ $courier->id }}" class="custom-control-label" for="switchStatus_{{ $courier->id }}">
                                                    @if($courier->status == 1) 
                                                        Activo
                                                    @else
                                                        Inactivo
                                                    @endif
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="hasTerminal_{{ $courier->id }}"
                                                        onChange="terminalStatus({{ $courier->id }})" @if($courier->terminal != null) checked @endif>
                                                    <label class="custom-control-label" for="hasTerminal_{{ $courier->id }}" id="hasTerminal_{{ $courier->id }}Label">
                                                    @if($courier->terminal == null)
                                                        No
                                                    @else
                                                        Sí
                                                    @endif
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-4"></div>
                                                    <div id="noTerminal_{{ $courier->id }}" class="col-sm-4">
                                                    @if($courier->terminal == null)
                                                        <span>Sin terminal</span>
                                                    @else
                                                        <span>{{ $courier->terminal }}</span>
                                                    @endif
                                                    </div>
                                                    <div class="col-sm-4" id="terminalEditButton_{{ $courier->id }}">
                                                    @if($courier->terminal != null)
                                                        <a onclick="editTerminalNumber({{ $courier->id }})">
                                                            <i id="editNoTerminal" class="fas fa-edit"></i>
                                                        </a>
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

        <div class="modal fade" id="terminalModal" tabindex="-1" aria-labelledby="terminalModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="terminalModalLabel">Actualizar terminal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="terminalForm" method="POST">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input type="hidden" id="courierId" name="courierId">
                                    <div class="form-group">
                                        <label>Numero de Terminal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-wrench"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Numero de terminal" id="numTerminal" name="numTerminal" required>
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

        <div class="modal fade" id="terminalModal2" tabindex="-1" aria-labelledby="terminalModal2Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="terminalModal2Label">Actualizar terminal</h5>
                    </div>
                    <div class="modal-body">
                        <form id="terminalForm2" method="POST">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <input type="hidden" id="courierId2" name="courierId">
                                    <div class="form-group">
                                        <label>Numero de Terminal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-wrench"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Numero de terminal" id="numTerminal2" name="numTerminal2" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="btn-group w-100" role="group">
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

            $('#terminalForm').submit(event => {

                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/usuarios/updateTerminal") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: $('#courierId').val(), terminal: $('#numTerminal').val() },
                })
                .done(response => {
                    if (response.status == 200) {
                        alert( response.message );    
                        $(`#noTerminal_${$('#courierId').val()}`).html(`<span>${$('#numTerminal').val()}</span>`);
                        $('#terminalModal').modal('hide');
                        $('#numTerminal').val('');
                    }
                    else
                    {
                        alert( response.message );
                    }
                });
            });

            $('#terminalForm2').submit(event => {

                event.preventDefault();

                let id = $('#courierId2').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/usuarios/updateTerminal") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: id, terminal: $('#numTerminal2').val() },
                })
                .done(response => {
                    if (response.status == 200) {
                        alert( response.message );
                        $(`#noTerminal_${id}`).html(`<span>${$('#numTerminal2').val()}</span>`);
                        $(`#terminalEditButton_${id}`).show();
                        $(`#hasTerminal_${id}Label`).html('Si');
                        $('#terminalModal2').modal('hide');
                        $('#numTerminal2').val('');
                    }
                    else
                    {
                        alert( response.message );
                    }                    
                });
            });
        });

        function changeStatus(id) {
            
            let status = ($(`#switchStatus_${id}`).is(':checked')) ? 1 : 0;
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ url("/usuarios/updateStatus") }}',
                type: 'POST',
                dataType: 'json',
                data: { id: id, status: status },
            })
            .done(response => {
                alert( response.message );        
                if (status == 1) {
                    $(`#labelStatus_${id}`).html('Activo');
                }
                else {
                    $(`#labelStatus_${id}`).html('Inactivo');
                }
            });
        }

        function editTerminalNumber(id) {
            $('#courierId').val(id);
            
            $('#terminalModal').modal({
                keyboard: false,
                backdrop: 'static',
            });
        }

        function terminalStatus(id) {
                        
            if(!$(`#hasTerminal_${id}`).is(':checked'))
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ url("/usuarios/updateTerminal") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: id, terminal: 'off' },
                })
                .done(response => {
                    alert( response.message );    
                    $(`#noTerminal_${id}`).html(`<span>Sin terminal</span>`);
                    $(`#terminalEditButton_${id}`).hide();
                    $(`#hasTerminal_${id}Label`).html('No');
                    $('#terminalModal').modal('hide');
                    $('#terminalForm').reset();
                });
            } 
            else {
                $('#courierId2').val(id);

                $('#terminalModal2').modal({
                    keyboard: false,
                    backdrop: 'static',
                });
            }
        }

    </script>

@endsection

@endsection

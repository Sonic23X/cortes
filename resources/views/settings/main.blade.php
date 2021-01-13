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
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="text-center">Conceptos del flujo</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                  <table class="table table-bordered text-center" id="dtConcepts">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody id="conceptTableBody">
                                        @foreach($concepts as $concept)
                                            <tr>
                                                <td>{{ $concept->id }}</td>
                                                <td>{{ $concept->concept }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#newConceptModal">
                                    Nuevo concepto
                                </button>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="text-center">Cuentas</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                  <table class="table table-bordered text-center" id="dtAccounts">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nombre de la cuenta</th>
                                                <th scope="col">Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody id="accountTableBody">
                                        @foreach($accounts as $account)
                                            <tr>
                                                <td>{{ $account->id }}</td>
                                                <td>{{ $account->name }}</td>
                                                <td>${{ $account->amount }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#newAccountModal">
                                    Nueva cuenta
                                </button>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="text-center">Negocios registrados</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                  <table class="table table-bordered text-center" id="dtNegocios">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody id="negociosTableBody">
                                        @foreach($places as $place)
                                            <tr>
                                                <td>{{ $place->id }}</td>
                                                <td>{{ $place->name }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#newShopModal">
                                    Nuevo negocio
                                </button>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="text-center">Hojas de calculos</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                  <table class="table table-bordered text-center" id="dtHojas">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody id="hojasTableBody">
                                        @foreach($sheets as $sheet)
                                            <tr>
                                                <td>{{ $sheet->id }}</td>
                                                <td>{{ $sheet->name }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#newSheetModal">
                                    Nueva hoja
                                </button>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>  
    </section>

    <!-- Modals -->
    <div class="modal fade" id="newConceptModal" tabindex="-1" aria-labelledby="newConceptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newConceptModalLabel">Nuevo concepto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-danger">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newConcept">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Descripción del concepto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="descripcion" id="descripcion" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Rubro del concepto</label>
                                <select class="custom-select" name="concepto" id="concepto">
                                    <option value="1" selected="selected">Urbo -> repartidor</option>
                                    <option value="2">Repartidor -> Urbo</option>
                                    <option value="3">Otro</option>
                                </select>
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

    <div class="modal fade" id="newAccountModal" tabindex="-1" aria-labelledby="newAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newAccountModalLabel">Nueva cuenta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-danger">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newAccount">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Nombre</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="nombreCuenta" id="nombreCuenta" required>
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

    <div class="modal fade" id="newShopModal" tabindex="-1" aria-labelledby="newShopModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newAccountModalLabel">Nueva negocio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-danger">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newNegocio">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Nombre</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="nombreNegocio" id="nombreNegocio" required>
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

    <div class="modal fade" id="newSheetModal" tabindex="-1" aria-labelledby="newSheetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newSheetModalLabel">Nueva hoja de calculos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-danger">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newHoja">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Nombre</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="nombreHoja" id="nombreHoja" required>
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

@section('script')
    
<script>
    $(document).ready(() =>
    {
        var dtShops = null;
        var dtAccounts = null;
        var dtConcepts = null;
        var dtHojas = null;

        dtShops = $('#dtNegocios').DataTable(
        {
            'responsive': true,
            'lengthChange': false,
            'autoWidth': false,
            'responsive': true,
            'ordering': false,
            'bInfo' : false,
            'pageLength': 10
        });

        dtAccounts = $('#dtAccounts').DataTable(
        {
            'responsive': true,
            'lengthChange': false,
            'autoWidth': false,
            'responsive': true,
            'ordering': false,
            'bInfo' : false,
            'pageLength': 10
        });

        dtConcepts = $('#dtConcepts').DataTable(
        {
            'responsive': true,
            'lengthChange': false,
            'autoWidth': false,
            'responsive': true,
            'ordering': false,
            'bInfo' : false,
            'pageLength': 10
        });

        dtHojas = $('#dtHojas').DataTable(
        {
            'responsive': true,
            'lengthChange': false,
            'autoWidth': false,
            'responsive': true,
            'ordering': false,
            'bInfo' : false,
            'pageLength': 10
        });

        $('#newConcept').submit(event =>
        {
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ url("/concepto") }}',
                type: 'POST',
                dataType: 'json',
                data: { concepto: $('#descripcion').val(), rubro: $('#concepto').val() },
            })
            .done(response => {
                alert( response.message );        
                $('#conceptTableBody').html('');

                response.conceptos.forEach(concepto => 
                {
                    let plantilla = 
                    `
                        <tr>
                            <td>${concepto.id}</td>
                            <td>${concepto.concept}</td>
                        </tr>
                    `;

                    $('#conceptTableBody').append(plantilla);
                });

                $('#newConceptModal').modal('hide');
                $('#newConcept').trigger('reset');
            });
        });

        $('#newAccount').submit(event =>
        {
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ url("/cuenta") }}',
                type: 'POST',
                dataType: 'json',
                data: { nombre: $('#nombreCuenta').val() },
            })
            .done(response => {
                alert( response.message );        
                $('#accountTableBody').html('');

                response.cuentas.forEach(cuenta => 
                {
                    let plantilla = 
                    `
                        <tr>
                            <td>${cuenta.id}</td>
                            <td>${cuenta.name}</td>
                            <td>${cuenta.amount}</td>
                        </tr>
                    `;

                    $('#accountTableBody').append(plantilla);
                });

                $('#newAccountModal').modal('hide');
                $('#newAccount').trigger('reset');
            });
        });

        $('#newNegocio').submit(event =>
        {
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ url("/negocio") }}',
                type: 'POST',
                dataType: 'json',
                data: { nombre: $('#nombreNegocio').val() },
            })
            .done(response => {
                alert( response.message );
                
                if(dtShops != null)
                    dtShops.destroy();
                
                $('#negociosTableBody').html('');

                response.negocios.forEach(negocio => 
                {
                    let plantilla = 
                    `
                        <tr>
                            <td>${negocio.id}</td>
                            <td>${negocio.name}</td>
                        </tr>
                    `;

                    $('#negociosTableBody').append(plantilla);
                });

                dtShops = $('#dtNegocios').DataTable(
                {
                    'responsive': true,
                    'lengthChange': false,
                    'autoWidth': false,
                    'responsive': true,
                    'ordering': false,
                    'bInfo' : false,
                    'pageLength': 10
                });

                $('#newShopModal').modal('hide');
                $('#newNegocio').trigger('reset');
            });
        });

        $('#newHoja').submit(event =>
        {
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ url("/hoja") }}',
                type: 'POST',
                dataType: 'json',
                data: { nombre: $('#nombreHoja').val() },
            })
            .done(response => {
                alert( response.message );
                
                if(dtHojas != null)
                    dtHojas.destroy();
                
                $('#hojasTableBody').html('');

                response.hojas.forEach(hoja => 
                {
                    let plantilla = 
                    `
                        <tr>
                            <td>${hoja.id}</td>
                            <td>${hoja.name}</td>
                        </tr>
                    `;

                    $('#hojasTableBody').append(plantilla);
                });

                dtHojas = $('#dtHojas').DataTable(
                {
                    'responsive': true,
                    'lengthChange': false,
                    'autoWidth': false,
                    'responsive': true,
                    'ordering': false,
                    'bInfo' : false,
                    'pageLength': 10
                });

                $('#newSheetModal').modal('hide');
                $('#newHoja').trigger('reset');
            });
        });
    });
</script>
    
@endsection

@endsection

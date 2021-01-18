@extends('base.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-2">
                <div class="col-sm-6">
                    <h1 style="font-size: 40px;">{{ $title }}</h1>
                </div>
                <div class="col-sm-3">
                    <form>
                        <div class="form-group text-center">
                            <label>Hojas de calculo</label>
                            <div class="input-group mb-3">
                                <select class="form-control" name="tipo" id="tipo_movimiento">
                                    @foreach ($sheets as $sheet)
                                        <option value="{{ $sheet->id }}">{{ $sheet->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-3">
                    <a href="{{ url('/hojas/create') }}" class="btn btn-secondary btn-block">
                        Nuevo movimiento
                    </a>
                </div>
            </div>
        </div>
    </div>
        
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                
            </div>
        </div>
    </div>

@section('script')

    <script type="text/javascript">
        
        $(document).ready(() =>
        {
            
        });

    </script>

@endsection

@endsection

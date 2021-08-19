@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Carpetas') }}
                    <div style="float: right;">
                        <button class="btn btn-primary" id="add_carpeta">Agregar Carpeta</button>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row" id="carpetas_list">
                        <div class="col-md-1">ID</div>
                        <div class="col-md-2">Nombre</div>
                        <div class="col-md-6">Ruta</div>
                        <div class="col-md-3">Acciones</div>
                    </div>
                    <div class="row" id="carpeta_result">
                    </div>
                </div>
            </div>
            <div class="card" style="margin-top:50px;">
                <div class="card-header">{{ __('Subcarpetas') }}
                </div>

                <div class="card-body" >
                    <div class="row" id="subcarpetas_list">
                        <div class="col-md-1">ID</div>
                        <div class="col-md-2">Id Padre</div>
                        <div class="col-md-6">Nombre</div>
                        <div class="col-md-3">Acciones</div>
                    </div>
                    <div class="row" id="subcarpeta_result">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalDetalle" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="width: 680px !important;">
            <div class="modal-content" >
                <div class="modal-header">
                    <h1 id="titulo_modal">Detalle Carpeta</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mediumBody">
                    <div>
                        <div class="row" id="detalles_tabla">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

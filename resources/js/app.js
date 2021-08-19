import './bootstrap';
import Swal from 'sweetalert2'

(function($){
	$.fn.getAllCarpetas = function(tabla,accion = "carpetas") {
		$.ajax({
            url: "https://localhost/prueba_etraining/public/api/" + accion,
            type: "GET",
            data: {
                api_key: '$2y$10$LRyUsiLNnQQzuo8t9lkJlukE5SXisBS7wW5v7.8s4HJlqAaT3aWMO', 
                api_token: '$2y$10$U54AVkcMA5HrkVf2WUZrhuMnwaFoOA1FV8zAEeL956pHTxiLWAuIm'
            },
            dataType: "json",
        }).done(function(result) {
            if(accion == "carpetas"){
                $.fn.renderTabla(result);
            }else{
                $.fn.renderTabla(result,"subcarpeta_result");
            }
        }).fail(function(error) {
            alert( "error" );
        });
	}
    
    $.fn.getCarpetaById = function(id,edit=false,subcarpeta = false) {
        var tabla = "detalles_tabla";
        var tipo = subcarpeta === false ? "carpetas" : "subcarpetas";
		$.ajax({
            url: "https://localhost/prueba_etraining/public/api/"+tipo+"/"+id,
            type: "GET",
            data: {
                api_key: '$2y$10$LRyUsiLNnQQzuo8t9lkJlukE5SXisBS7wW5v7.8s4HJlqAaT3aWMO', 
                api_token: '$2y$10$U54AVkcMA5HrkVf2WUZrhuMnwaFoOA1FV8zAEeL956pHTxiLWAuIm'
            },
            dataType: "json",
        }).done(function(result) {
            if(edit){
                $.fn.renderTablaEdit(result,tabla,tipo);
            }else{
                $.fn.renderTablaDetalle(result,tabla);
            }
        }).fail(function(error) {
            alert( "error" );
        });
	}
  
    $.fn.renderTablaEdit = function(array,tabla,tipo) {
        
        var array = array[0];
        var table = $('#' + tabla);
        var html = `
        <form id="edit_carpeta"> 
            <div class="row col-md-12 text-left">
                    <div class="col-md-3">ID</div>
                    <div class="col-md-9">${array.id}</div>
                    <input type="hidden" value="${array.id}" name="id"/>
                </div>
                <div class="row col-md-12 text-left">
                    <div class="col-md-3">Nombre</div>
                    <div class="col-md-9">
                        <input type="text" value="${array.nombre}" name="nombre"/>
                    </div>
                </div>
                <div class="row col-md-12 text-left">
                    <div class="col-md-3">Ruta</div>
                    <div class="col-md-9">${array.ruta}</div>
                </div>
                <div class="row col-md-12 text-left">
                    <div class="col-md-3">Activo</div> 
                    <div class="col-md-9">${array.activo}</div>
                </div>
                <div class="row col-md-12 text-left">
                    <div class="col-md-3">Fecha creacion</div>
                    <div class="col-md-9">${array.created_at}</div>
                </div>
                <div class="row col-md-12 text-left">
                    <div class="col-md-3">Fecha modificacion</div>
                    <div class="col-md-9">${array.updated_at}</div>
                </div>
                <div class="row ">
                    <div class="col text-center">
                        <button class="btn btn-success" type="button" id="btn-edit">Editar</button>
                    </div>
                </div>
                        
        </form> 
        `;
        $('#titulo_modal').text((tipo === "carpetas" ? "Editar Carpeta" : "Editar Subcarpeta") + array.id +" - "+array.nombre);
        table.html(html);
        $('#ModalDetalle').modal('show');
        $.fn.formActionEdit(array.id,tipo);
    }

    $.fn.renderTablaDetalle = function(array,tabla) {
        
        var array = array[0];
        var table = $('#' + tabla);
        var html = `
                <div class="row col-md-12 text-left">
                    <div class="col-md-3">ID</div>
                    <div class="col-md-9">${array.id}</div>
                </div>
                <div class="row col-md-12 text-left">
                    <div class="col-md-3">Nombre</div>
                    <div class="col-md-9">${array.nombre}</div>
                </div>
                <div class="row col-md-12 text-left">
                    <div class="col-md-3">Ruta</div>
                    <div class="col-md-9">${array.ruta}</div>
                </div>
                <div class="row col-md-12 text-left">
                    <div class="col-md-3">Activo</div> 
                    <div class="col-md-9">${array.activo}</div>
                </div>
                <div class="row col-md-12 text-left">
                    <div class="col-md-3">Fecha creacion</div>
                    <div class="col-md-9">${array.created_at}</div>
                </div>
                <div class="row col-md-12 text-left">
                    <div class="col-md-3">Fecha modificacion</div>
                    <div class="col-md-9">${array.updated_at}</div>
                </div>
        `;
        if(typeof(array.subcarpetas) !== 'undefined'){
            if(array.subcarpetas.length > 0){
                html += `<h2 style="margin-left:15px;">Detalle Subcarpeta</h2>`;
                $.each(array.subcarpetas,function(i,data){
                    html += `
                        <div class="row col-md-12 text-left">
                        <div class="col-md-3">ID</div>
                        <div class="col-md-9">${data.id}</div>
                    </div>
                    <div class="row col-md-12 text-left">
                        <div class="col-md-3">Nombre</div>
                        <div class="col-md-9">${data.nombre}</div>
                    </div>
                    <div class="row col-md-12 text-left">
                        <div class="col-md-3">Ruta</div>
                        <div class="col-md-9">${data.ruta}</div>
                    </div>
                    <div class="row col-md-12 text-left">
                        <div class="col-md-3">Activo</div> 
                        <div class="col-md-9">${data.activo === 1 ? "Activo" : "Inactivo"}</div>
                    </div>
                    <div class="row col-md-12 text-left">
                        <div class="col-md-3">Fecha creacion</div>
                        <div class="col-md-9">${data.created_at}</div>
                    </div>
                    <div class="row col-md-12 text-left">
                        <div class="col-md-3">Fecha modificacion</div>
                        <div class="col-md-9">${data.updated_at}</div>
                    </div>
                    `;
                })
            }

        }else{
            
                html += `<h2 style="margin-left:15px;">Detalle Carpeta</h2>`;
                html += `
                        <div class="row col-md-12 text-left">
                        <div class="col-md-3">ID</div>
                        <div class="col-md-9">${array.carpeta.id}</div>
                    </div>
                    <div class="row col-md-12 text-left">
                        <div class="col-md-3">Nombre</div>
                        <div class="col-md-9">${array.carpeta.nombre}</div>
                    </div>
                    <div class="row col-md-12 text-left">
                        <div class="col-md-3">Ruta</div>
                        <div class="col-md-9">${array.carpeta.ruta}</div>
                    </div>
                    <div class="row col-md-12 text-left">
                        <div class="col-md-3">Activo</div> 
                        <div class="col-md-9">${array.carpeta.activo === 1 ? "Activo" : "Inactivo"}</div>
                    </div>
                    <div class="row col-md-12 text-left">
                        <div class="col-md-3">Fecha creacion</div>
                        <div class="col-md-9">${array.carpeta.created_at}</div>
                    </div>
                    <div class="row col-md-12 text-left">
                        <div class="col-md-3">Fecha modificacion</div>
                        <div class="col-md-9">${array.carpeta.updated_at}</div>
                    </div>
                    `;

        }
        $('#titulo_modal').text(typeof(array.subcarpetas) !== 'undefined' ? "Detalle Carpeta" : "Detalle Subcarpeta");
        table.html(html);
        $('#ModalDetalle').modal('show');
    }

    $.fn.renderTabla = function(array,tabla = false) {
   
        var table = tabla === false ? $('#carpeta_result') : $('#'+tabla);
        var html = ``;
        $.each(array,function(i,data){
            if(tabla === false){
                html += `
                <div class="col-md-1">${data.id}</div>
                <div class="col-md-2">${data.nombre}</div>
                <div class="col-md-6">${data.ruta}</div>
                <div class="col-md-3" style="cursor: pointer;">
                    <i title="Detalles" class="fas fa-info-circle" data-id=${data.id} data-action="detail"></i>
                    <i title="Editar" class="far fa-edit" data-id=${data.id} data-action="edit"></i>
                    <i title="Agregar Subcarpeta" class="fas fa-plus-circle" data-id=${data.id} data-action="add"></i>
                    <i title="Eliminar" class="fas fa-times-circle" data-id=${data.id} data-action="del"></i>
                </div>
            `;
            }else{
                html += `
                <div class="col-md-1">${data.id}</div>
                <div class="col-md-2">${data.carpeta_id}</div>
                <div class="col-md-6">${data.nombre}</div>
                <div class="col-md-3" style="cursor: pointer;">
                    <i title="Detalles" class="fas fa-info-circle" data-id=${data.id} data-action="detail"></i>
                    <i title="Editar" class="far fa-edit" data-id=${data.id} data-action="edit"></i>
                    <i title="Eliminar" class="fas fa-times-circle" data-id=${data.id} data-action="del"></i>
                </div>
                `;
            }
        });
        table.html(html);
        $.fn.setAction();
    }

    $.fn.renderTablaAdd = function(id = null) {
        var table = $('#detalles_tabla');
        var accion = id === null ? "carpetas" : "subcarpetas";
        var titulo = id === null ? "Nombre carpeta" : "Nombre subcarpeta";
        var html = `
        <form id="crear_carpeta" class="col-md-12"> 
                <div class="row  text-left">
                    <div class="col-md-6">${titulo}</div>
                    <div class="col-md-6">
                        <input type="text" placeholder="nombre" name="nombre"/>
                        <input type="hidden" name="accion" value="${accion}"/>
                        <input type="hidden" name="id_carpeta" value="${id}"/>
                    </div>
                </div>
                <div class="row " style="margin-top: 20px;">
                    <div class="col text-center">
                        <button class="btn btn-primary" type="button" id="btn-crear">Crear</button>
                    </div>
                </div>         
        </form> 
        `;   
        table.html(html);
        $('#titulo_modal').text(id === null ? "Agregar Carpeta" : "Agregar Subcarpeta");
        $('#ModalDetalle').modal('show');
        $.fn.formActionCreate();

    }

    $.fn.setAction = function(){
        $('#carpeta_result i').on('click',function(){
            switch(this.dataset.action){
                case "detail":
                    $.fn.getCarpetaById(this.dataset.id);
                break;
                case "edit":
                    $.fn.getCarpetaById(this.dataset.id,true);
                break;
                case "add":
                    $.fn.addSubCarpetaById(this.dataset.id);
                break;
                case "del":
                    $.fn.deleteCarpetaById(this.dataset.id);
                break;
            }
        });

        $('#subcarpeta_result i').on('click',function(){
            switch(this.dataset.action){
                case "detail":
                    $.fn.getCarpetaById(this.dataset.id,false,true);
                break;
                case "edit":
                    $.fn.getCarpetaById(this.dataset.id,true,true);
                break;
                case "del":
                    $.fn.deleteCarpetaById(this.dataset.id,true);
                break;
            }
        });
    }

    $.fn.setActionAddCarpeta = function(){
        $('#add_carpeta').on('click',function(){
            $.fn.renderTablaAdd();
        });
    }

    $.fn.formActionCreate = function(){
        $('#btn-crear').on('click',function(){
            var data_Form = $('#crear_carpeta').serializeArray();
            $.ajax({
                url: "https://localhost/prueba_etraining/public/api/" + data_Form[1].value,
                type: "POST",
                data: {
                    api_key: '$2y$10$LRyUsiLNnQQzuo8t9lkJlukE5SXisBS7wW5v7.8s4HJlqAaT3aWMO', 
                    api_token: '$2y$10$U54AVkcMA5HrkVf2WUZrhuMnwaFoOA1FV8zAEeL956pHTxiLWAuIm',
                    nombre : data_Form[0].value,
                    id_carpeta : data_Form[2].value
                },
                dataType: "json",
            }).done(function(result) {
                $.fn.getAllCarpetas("carpetas_list");
                $.fn.getAllCarpetas("subcarpetas_list","subcarpetas");
                $('#ModalDetalle').modal('hide');
            }).fail(function(error) {
                alert( "error" );
            });
        })
    }

    $.fn.formActionEdit = function(id,tipo = "carpetas"){
        $('#btn-edit').on('click',function(id){
            var data_Form = $('#edit_carpeta').serializeArray();
            $.ajax({
                url: "https://localhost/prueba_etraining/public/api/"+tipo+"/" + data_Form[0].value,
                type: "PUT",
                data: {
                    api_key: '$2y$10$LRyUsiLNnQQzuo8t9lkJlukE5SXisBS7wW5v7.8s4HJlqAaT3aWMO', 
                    api_token: '$2y$10$U54AVkcMA5HrkVf2WUZrhuMnwaFoOA1FV8zAEeL956pHTxiLWAuIm',
                    nombre : data_Form[1].value
                },
                dataType: "json",
            }).done(function() {
                if(tipo === "carpetas"){
                    $.fn.getAllCarpetas("carpetas_list");
                }else{
                    $.fn.getAllCarpetas("subcarpetas_list","subcarpetas");
                }
                $('#ModalDetalle').modal('hide');
            }).fail(function(error) {
                alert( "error" );
            });
        })
    }

    $.fn.deleteCarpetaById = function(id,subcarpeta = false){

        var tipo = subcarpeta === false ? "carpetas" : "subcarpetas";
        var text = subcarpeta === false ? "carpeta?" : "subcarpeta?";
        Swal.fire({
            icon: 'warning',
            text: 'Quieres borrar la '+text,
            showCancelButton: true,
            confirmButtonText: 'Borrar',
            confirmButtonColor: '#e3342f',
        }).then((result) => {
            var id_carpeta = id;
            if (result.isConfirmed) {
                $.ajax({
                    url: "https://localhost/prueba_etraining/public/api/"+tipo+"/"+id_carpeta,
                    type: "DELETE",
                    data: {
                        api_key: '$2y$10$LRyUsiLNnQQzuo8t9lkJlukE5SXisBS7wW5v7.8s4HJlqAaT3aWMO', 
                        api_token: '$2y$10$U54AVkcMA5HrkVf2WUZrhuMnwaFoOA1FV8zAEeL956pHTxiLWAuIm'
                    },
                    dataType: "json",
                }).done(function() {
                    if(subcarpeta){
                        $.fn.getAllCarpetas("subcarpetas_list","subcarpetas");
                    }else{
                        $.fn.getAllCarpetas("carpetas_list");
                        $.fn.getAllCarpetas("subcarpetas_list","subcarpetas");
                    }
                }).fail(function(error) {
                    alert( "error" );
                });
            }
        });
    }

    //Subcarpetas

    $.fn.addSubCarpetaById = function(id){
        $.fn.renderTablaAdd(id);
    }

})(jQuery);
$.fn.getAllCarpetas("carpetas_list");
$.fn.getAllCarpetas("subcarpetas_list","subcarpetas");
$.fn.setActionAddCarpeta();


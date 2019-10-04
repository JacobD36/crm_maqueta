<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: '.$_SERVER['DOCUMENT_ROOT'].'/app_maqueta/index.php');
    }
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $usr = new usuario_model();
?>
<!-- Content Header (Page header) -->
<style type="text/css">
    .modal-header {
        background-color: #605ca8;
        color: white;
    }
</style>
<section class="content-header">
    <h1>CAMPAÑAS</h1>
    <ol class="breadcrumb">
        <li><a href="./inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Campañas</li>
    </ol>
</section>
<section class="content">
    <div id="sys_camp">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-search"></i> Búsqueda</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label for="sel_nombre">Campaña a buscar</label>
                            <input type="text" class="form-control" id="sel_nombre" placeholder="" v-model="nombre">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="buscar_dato" @click="buscar_campana()" style="float:left;">
                                <i class="glyphicon glyphicon-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-calendar-minus-o"></i> Campañas Registradas</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" @click="nueva_campana()" id="nueva_campana" style="float:left;">
                                <i class="glyphicon glyphicon-tasks"></i> Nueva Campaña
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <p>&nbsp;</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <table class="table table-bordered table-striped table-hover display responsive nowrap" width="100%" cellspacing="0" id="my-table" >
                                <thead>
                                    <tr role="row" class="col_heading"></tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <div class="modal fade" id="myModal" data-backdrop="static" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content" id="contenido_modal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 v-if="tipoAccion==1" class="modal-title"><i class="fa fa-calendar-minus-o"></i>&nbsp;&nbsp;Nueva Campaña</h4>
                        <h4 v-if="tipoAccion==2" class="modal-title"><i class="fa fa-calendar-minus-o"></i>&nbsp;&nbsp;Actualizar Campaña</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" v-model="id">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group" id="sel_nom_campana">
                                    <label for="nom_campana">Nombre de Campaña</label>
                                    <input type="text" class="form-control" id="nom_campana" placeholder="" v-model="cod_campana" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-group" id="sel_descripcion">
                                    <label for="desc_campana">Descripción</label>
                                    <input type="text" class="form-control" id="desc_campana" placeholder="" v-model="desc_campana">
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="modal-footer">
                        <button type="button" v-if="tipoAccion==1" @click="guardar_campana()" class="btn btn-primary" id="guardar_info">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" @click="actualizar_campana()" class="btn btn-primary" id="guardar_info">Actualizar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var sys_camp = new Vue({
        el: '#sys_camp',
        data: {
            id:"",
            nombre:"",
            cod_campana:"",
            desc_campana:"",
            tipoAccion:0
        },
        created: function () {
        },
        methods:{
            buscar_campana(){
                this.mostrar_campanas(sys_camp.nombre);
            },
            nueva_campana(){
                sys_camp.tipoAccion=1;
                this.limpia_registros();
            },
            edita_campana(id){
                sys_camp.tipoAccion=2;
                axios.post('controlador/edita_sys_campana.php',{
                    id_base:id
                }).then(function (response) {
                    var info = response.data['data'][0];
                    sys_camp.id = id;
                    sys_camp.cod_campana = info['cod_campana'];
                    sys_camp.desc_campana = info['desc_campana'];
                });
            },
            desactiva_campana(id){
                swal({
                    title: "¿Confirma la desactivación del elemento?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: {
                        cancel: "Cancelar",
                        catch: {
                            text: "Aceptar",
                            value: "aceptar",
                        },
                    }
                })
                .then((value) => {
                    if (value=="aceptar") {
                        $.ajax({
                            type: "post",
                            url: "controlador/cambia_estado_camp.php?opt=0",
                            data: {
                                id: id
                            },
                            success: function(datos) {
                                $('#my-table').DataTable().ajax.reload();
                                swal("¡Operación exitosa! Se ha desactivado el registro...", {icon: "success",});
                            }
                        });
                    }
                });
            },
            activa_campana(id){
                swal({
                    title: "¿Confirma la activación del elemento?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: {
                        cancel: "Cancelar",
                        catch: {
                            text: "Aceptar",
                            value: "aceptar",
                        },
                    }
                })
                .then((value) => {
                    if (value=="aceptar") {
                        $.ajax({
                            type: "post",
                            url: "controlador/cambia_estado_camp.php?opt=1",
                            data: {
                                id: id
                            },
                            success: function(datos) {
                                $('#my-table').DataTable().ajax.reload();
                                swal("¡Operación exitosa! Se ha activado el registro...", {icon: "success",});
                            }
                        });
                    } 
                });
            },
            guardar_campana(){
                if(sys_camp.nom_campana!="" && sys_camp.desc_campana!=""){
                    axios.post('controlador/genera_campana_sys.php',{
                        cod_campana:sys_camp.cod_campana,
                        desc_campana:sys_camp.desc_campana
                    }).then(function (response) {
                        $('#my-table').DataTable().ajax.reload();
                        $('#myModal').modal('toggle');
                        $("#sel_nom_campana").removeClass("has-error has-feedback");
                        $("#sel_descripcion").removeClass("has-error has-feedback");
                        swal("¡Operación exitosa! Se guardó la información registrada para "+response.data, { icon: "success", });
                    });
                } else {
                    if(sys_camp.cod_campana==""){
                        $("#sel_nom_campana").addClass("has-error has-feedback");
                        swal("¡Error! Por favor, ingrese el nombre de la campaña.", { icon: "error", });
                    } else {
                        $("#sel_nom_campana").removeClass("has-error has-feedback");
                        if(sys_camp.desc_campana==""){
                            $("#sel_descripcion").addClass("has-error has-feedback");
                            swal("¡Error! Por favor, ingrese una descripción para la campaña.", { icon: "error", });
                        } else {
                            $("#sel_descripcion").removeClass("has-error has-feedback");
                        }
                    }
                }
            },
            actualizar_campana(){
                if(sys_camp.cod_campana!="" && sys_camp.desc_campana!=""){
                    axios.post('controlador/actualiza_campana_sys.php',{
                        id:sys_camp.id,
                        cod_campana:sys_camp.cod_campana,
                        desc_campana:sys_camp.desc_campana
                    }).then(function (response) {
                        $('#my-table').DataTable().ajax.reload();
                        $('#myModal').modal('toggle');
                        $("#sel_nom_campana").removeClass("has-error has-feedback");
                        $("#sel_descripcion").removeClass("has-error has-feedback");
                        swal("¡Operación exitosa! Se actualizó la información de la campaña", { icon: "success", });
                    });
                } else {
                    if(sys_camp.cod_campana==""){
                        $("#sel_nom_campana").addClass("has-error has-feedback");
                        swal("¡Error! Por favor, ingrese el nombre de la campaña.", { icon: "error", });
                    } else {
                        $("#sel_nom_campana").removeClass("has-error has-feedback");
                        if(sys_camp.desc_campana==""){
                            $("#sel_descripcion").addClass("has-error has-feedback");
                            swal("¡Error! Por favor, ingrese una descripción para la campaña.", { icon: "error", });
                        } else {
                            $("#sel_desripcion").removeClass("has-error has-feedback");
                        }
                    }
                }
            },
            limpia_registros(){
                sys_camp.id="";
                sys_camp.cod_campana="";
                sys_camp.desc_campana="";
                $("#sel_nom_campana").removeClass("has-error has-feedback");
                $("#sel_descripcion").removeClass("has-error has-feedback");
            },
            mostrar_campanas(nombre){
                var columns = [
                    { "title":"ID","width": "10%" },
                    { "title":"NOMBRE","width": "30%" },
                    { "title":"DESCRIPCION","width": "40%" },
                    { "title":"ESTADO","width": "10%" },
                    { "title":"OPCIONES","width": "10%" }
                ];

                var table = $('#my-table').DataTable( {
                    "processing": true,
                    "lengthChange": true,
                    "responsive" : true,
                    "searching": true,
                    "ordering": true,
                    "order": [[ 1, "asc" ]],
                    "info": true,
                    "autoWidth": false,
                    "destroy": true,
                    "columns": columns,
                    "ajax": "controlador/get_all_campanas.php?nombre="+nombre,
                    "deferRender": true,
                    "paging": true,
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "Sin registros",
                        "sEmptyTable": "Tabla vacía",
                        "sInfo": "_START_ a _END_ de _TOTAL_ reg",
                        "sInfoEmpty": "0 a 0 de 0 REG",
                        "sInfoFiltered": "(_MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                    "bInfo": true,
                    "columnDefs": [
                        { responsivePriority: 1, targets: 0 },
                        { responsivePriority: 2, targets: 1 },
                        { responsivePriority: 3, targets: 4 },
                        {
                            "targets": [0],
                            "render": function(data, type, full) {
                                return data;
                            }
                        },
                        {
                            "targets": [1],
                            "render": function(data, type, full) {
                                return data;
                            }
                        },
                        {
                            "targets": [2],
                            "render": function(data, type, full) {
                                return data;
                            }
                        },
                        {
                            "targets": [3],
                            "render": function(data, type, full) {
                                if (data!="") {
                                    if (data==1) {
                                        return "<center><span class='label label-success'>ACTIVO</span></center>";
                                    } else {
                                        if (data==0) {
                                            return "<center><span class='label label-danger'>INACTIVO</span></center>";
                                        } else {
                                            if (data==3) {
                                                return '';
                                            }
                                        }
                                    }
                                } else {
                                    return '';
                                }
                            }
                        },
                        {
                            "targets": [4],
                            "render": function(data, type, full) {
                                return '<center>'+data+'</data>';
                            }
                        },
                    ],
                });
                $("th").css("background-color", "#00a65a");
                $("th").css("color", "white");
            }
        },
        mounted() {
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass   : 'iradio_minimal-blue'
            });
            this.mostrar_campanas('','');
        }
    });
</script> 
<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: '.$_SERVER['DOCUMENT_ROOT'].'/app_maqueta/index.php');
    }
    require_once($_SESSION['BASE']."/modelo/usuario_model.php");
    $usr = new usuario_model();
    $perfiles = $usr->get_all_perfiles();
?>
<!-- Content Header (Page header) -->
<style type="text/css">
    .modal-header {
        background-color: #605ca8;
        color: white;
    }
</style>
<section class="content-header">
    <h1>USUARIOS DEL SISTEMA</h1>
    <ol class="breadcrumb">
        <li><a href="./inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Usuarios</li>
    </ol>
</section>
<section class="content">
    <div id="sys_user">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-search"></i> Búsqueda</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label for="sel_nombre">Usuario a Buscar</label>
                            <input type="text" class="form-control" id="sel_nombre" placeholder="" v-model="nombre">
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="sel_perfil">Perfil</label>
                            <select class="form-control" id="sel_perfil" style="width: 100%;" v-model="perfil">
                                <option value="">SELECCIONE UNA CATEGORÍA</option>
                                <option v-for="per in arrayPerfiles" :key="per.id" :value="per.id" v-text="per.descripcion"></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="buscar_dato" @click="buscar_usuario()" style="float:right;">
                                <i class="glyphicon glyphicon-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-users"></i> Usuarios Registrados</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" @click="nuevo_usuario()" id="nuevo_usuario" style="float:left;">
                                <i class="glyphicon glyphicon-user"></i> Nuevo Usuario
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content" id="contenido_modal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 v-if="tipoAccion==1" class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp;Nuevo Usuario</h4>
                        <h4 v-if="tipoAccion==2" class="modal-title"><i class="fa fa-user"></i>&nbsp;&nbsp;Actualizar Usuario</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" v-model="id">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group" id="sel_nombre1">
                                    <label for="nombre1">Primer Nombre</label>
                                    <input type="text" class="form-control" id="nombre1" placeholder="" v-model="nombre1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group" id="sel_nombre2">
                                    <label for="nombre2">Segundo Nombre</label>
                                    <input type="text" class="form-control" id="nombre2" placeholder="" v-model="nombre2" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group" id="sel_apellido1">
                                    <label for="apellido1">Primer Apellido</label>
                                    <input type="text" class="form-control" id="apellido1" placeholder="" v-model="apellido1" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group" id="sel_apellido2">
                                    <label for="apellido2">Segundo Apellido</label>
                                    <input type="text" class="form-control" id="apellido2" placeholder="" v-model="apellido2" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group" id="sel_dni">
                                    <label for="dni">DNI</label>
                                    <input type="number" class="form-control" id="dni" placeholder="" v-model.number="dni">
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group" id="sel_perfil">
                                    <label for="perfil">Perfil</label>
                                    <select class="form-control" id="perfil" style="width: 100%;" v-model="perfil_frm">
                                        <option value="">SELECCIONE UNA CATEGORIA</option>
                                        <option v-for="per in arrayPerfiles" :key="per.id" :value="per.id" v-text="per.descripcion"></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <legend>Mantenimiento</legend>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" v-model="adm_check">
                                        Super Administrador
                                    </label>
                                </div>
                            </div> 
                        </div>
                    </div>  
                    <div class="modal-footer">
                        <button type="button" v-if="tipoAccion==1" @click="guardar_usuario()" class="btn btn-primary" id="guardar_info">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" @click="actualizar_usuario()" class="btn btn-primary" id="guardar_info">Actualizar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var sys_user = new Vue({
        el: '#sys_user',
        data: {
            id:"",
            nombre:"",
            perfil:"",
            nombre1:"",
            nombre2:"",
            apellido1:"",
            apellido2:"",
            dni:"",
            perfil_frm:"",
            super_adm:0,
            arrayPerfiles:[],
            tipoAccion:0,
            adm_check:false
        },
        created: function () {
        },
        methods:{
            get_perfiles(){
                let me = this;
                var url = 'controlador/get_all_perfiles.php';
                axios.get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayPerfiles = respuesta['data'];
                })
                .catch(function (error) {
                    console.log(error);
                })
                .finally(function () {
                });
            },
            buscar_usuario(){
                this.mostrar_usuarios(sys_user.nombre,sys_user.perfil);
            },
            nuevo_usuario(){
                sys_user.tipoAccion=1;
                this.get_perfiles();
                this.limpia_registros();
            },
            reset_password(id){
                swal({
                    title: "¿Confirma el reseteo de la contraseña?",
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
                            url: "controlador/reset_password.php",
                            data: {
                                id: id  
                            },
                            success: function(datos) {
                                $('#my-table').DataTable().ajax.reload();
                                swal("¡Operación exitosa! Se generó la contraseña: "+datos+" Se solicitará el cambio en el próximo inicio de sesión.", {icon: "success",});
                            }
                        });
                    } 
                });
            },
            edita_contacto(id){
                sys_user.tipoAccion=2;
                axios.post('controlador/edita_sys_usuario.php',{
                    id_base:id
                }).then(function (response) {
                    var info = response.data['data'][0];
                    sys_user.id = id;
                    sys_user.nombre1 = info['nombre1'];
                    sys_user.nombre2 = info['nombre2'];
                    sys_user.apellido1 = info['apellido1'];
                    sys_user.apellido2 = info['apellido2'];
                    sys_user.dni = info['dni'];
                    sys_user.perfil_frm = info['perfil'];
                    sys_user.super_adm = info['superadm'];
                    if(sys_user.super_adm==1){sys_user.adm_check=true;}else{sys_user.adm_check=false;}
                });
            },
            desactiva_usuario(id){
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
                            url: "controlador/cambia_estado.php?opt=0",
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
            activa_usuario(id){
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
                            url: "controlador/cambia_estado.php?opt=1",
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
            guardar_usuario(){
                if(sys_user.adm_check==true){
                    sys_user.super_adm = 1;
                } else {
                    sys_user.super_adm = 0;
                }

                if(sys_user.nombre1!="" && sys_user.apellido1!="" && sys_user.apellido2!="" && sys_user.dni!="" && sys_user.perfil_frm!=""){
                    axios.post('controlador/genera_usuario_sys.php',{
                        nombre1:sys_user.nombre1,
                        nombre2:sys_user.nombre2,
                        apellido1:sys_user.apellido1,
                        apellido2:sys_user.apellido2,
                        dni:sys_user.dni,
                        perfil:sys_user.perfil_frm,
                        superadm:sys_user.super_adm
                    }).then(function (response) {
                        if(response.data!="existe"){
                            var info = response.data.split("|");
                            $('#my-table').DataTable().ajax.reload();
                            $('#myModal').modal('toggle');
                            $("#sel_nombre1").removeClass("has-error has-feedback");
                            $("#sel_apellido1").removeClass("has-error has-feedback");
                            $("#sel_apellido2").removeClass("has-error has-feedback");
                            $("#sel_dni").removeClass("has-error has-feedback");
                            $("#sel_perfil").removeClass("has-error has-feedback");
                            swal("¡Operación exitosa! Se generó el usuario: "+info[0]+" Con contraseña: "+info[1], { icon: "success", });
                        } else {
                            $('#my-table').DataTable().ajax.reload();
                            $('#myModal').modal('toggle');
                            swal("¡Error! El usuario ya existe", { icon: "error", });
                        }
                    });
                } else {
                    if(sys_user.nombre1==""){
                        $("#sel_nombre1").addClass("has-error has-feedback");
                        swal("¡Error! Por favor, ingrese el(los) nombre(s).", { icon: "error", });
                    } else {
                        $("#sel_nombre1").removeClass("has-error has-feedback");
                        if(sys_user.apellido1==""){
                            $("#sel_apellido1").addClass("has-error has-feedback");
                            swal("¡Error! Por favor, ingrese el primer apellido", { icon: "error", });
                        } else {
                            $("#sel_apellido1").removeClass("has-error has-feedback");
                            if(sys_user.apellido2==""){
                                $("#sel_apellido2").addClass("has-error has-feedback");
                                swal("¡Error! Por favor, ingrese el segundo apellido", { icon: "error", });
                            } else {
                                $("#sel_apellido2").removeClass("has-error has-feedback");
                                if(sys_user.dni==""){
                                    $("#sel_dni").addClass("has-error has-feedback");
                                    swal("¡Error! Por favor, ingrese el dni", { icon: "error", });
                                } else {
                                    $("#sel_dni").removeClass("has-error has-feedback");
                                    if(sys_user.perfil_frm==""){
                                        $("#sel_perfil").addClass("has-error has-feedback");
                                    } else {
                                        $("#sel_perfil").removeClass("has-error has-feedback");
                                    }
                                }
                            }
                        }
                    }
                }
            },
            actualizar_usuario(){
                if(sys_user.adm_check==true){
                    sys_user.super_adm = 1;
                } else {
                    sys_user.super_adm = 0;
                }

                if(sys_user.nombre1!="" && sys_user.apellido1!="" && sys_user.apellido2!="" && sys_user.perfil_frm!="" && sys_user.perfil_frm!=""){
                    axios.post('controlador/actualiza_usuario_sys.php',{
                        id:sys_user.id,
                        nombre1:sys_user.nombre1,
                        nombre2:sys_user.nombre2,
                        apellido1:sys_user.apellido1,
                        apellido2:sys_user.apellido2,
                        dni:sys_user.dni,
                        perfil:sys_user.perfil_frm,
                        superadm:sys_user.super_adm
                    }).then(function (response) {
                        $('#my-table').DataTable().ajax.reload();
                        $('#myModal').modal('toggle');
                        $("#sel_nombre1").removeClass("has-error has-feedback");
                        $("#sel_apellido1").removeClass("has-error has-feedback");
                        $("#sel_apellido2").removeClass("has-error has-feedback");
                        $("#sel_dni").removeClass("has-error has-feedback");
                        $("#sel_perfil").removeClass("has-error has-feedback");
                        swal("¡Operación exitosa! Se actualizó la información del usuario", { icon: "success", });
                    });
                } else {
                    if(sys_user.nombre1==""){
                        $("#sel_nombre1").addClass("has-error has-feedback");
                        swal("¡Error! Por favor, ingrese el(los) nombre(s).", { icon: "error", });
                    } else {
                        $("#sel_nombre1").removeClass("has-error has-feedback");
                        if(sys_user.apellido1==""){
                            $("#sel_apellido1").addClass("has-error has-feedback");
                            swal("¡Error! Por favor, ingrese el primer apellido", { icon: "error", });
                        } else {
                            $("#sel_apellido1").removeClass("has-error has-feedback");
                            if(sys_user.apellido2==""){
                                $("#sel_apellido2").addClass("has-error has-feedback");
                                swal("¡Error! Por favor, ingrese el segundo apellido", { icon: "error", });
                            } else {
                                $("#sel_apellido2").removeClass("has-error has-feedback");
                                if(sys_user.perfil_frm==""){
                                    $("#sel_perfil").addClass("has-error has-feedback");
                                    swal("¡Error! Por favor, ingrese el dni", { icon: "error", });
                                } else {
                                    $("#sel_perfil").removeClass("has-error has-feedback");
                                }
                            }
                        }
                    }
                }
            },
            limpia_registros(){
                sys_user.id="";
                sys_user.nombre1="";
                sys_user.nombre2="";
                sys_user.apellido1="";
                sys_user.apellido2="";
                sys_user.perfil_frm=""; 
                sys_user.dni="";
                sys_user.super_adm=0;
                sys_user.adm_check=false;
                $("#sel_nombre1").removeClass("has-error has-feedback");
                $("#sel_apellido1").removeClass("has-error has-feedback");
                $("#sel_apellido2").removeClass("has-error has-feedback");
                $("#sel_dni").removeClass("has-error has-feedback");
                $("#sel_perfil").removeClass("has-error has-feedback");
            },
            mostrar_usuarios(nombre,perfil){
                var columns = [
                    { "title":"NOMBRES Y APELLIDOS","width": "30%" },
                    { "title":"PERFIL","width": "15%" },
                    { "title":"USUARIO","width": "15%" },
                    { "title":"ESTADO","width": "10%" },
                    { "title":"OPCIONES","width": "15%" }
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
                    "ajax": "controlador/get_all_users.php?nombre="+nombre+"&perfil="+perfil,
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
                            if(data==1){
                                return "<center><span class='label label-success'>ACTIVO</span></center>";
                            } else {
                                if (data==0) {
                                    return "<center><span class='label label-danger'>INACTIVO</span></center>";
                                } else {
                                    if(data==3){
                                        return '';
                                    }
                                }
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
            this.get_perfiles();
            this.mostrar_usuarios('','');
        }
    });
</script> 
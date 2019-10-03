<?php session_start(); ?>
<section class="content-header">
    <h1>CONFIGURACIÓN</h1>
    <ol class="breadcrumb">
        <li><a href="./inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Configuración</li>
    </ol>
</section>
<section class="content">
    <div id="pass_panel">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Cambiar Contraseña</h3>
            </div>
            <div class="box-body">
                <input type="hidden" id="codusuario" name="codusuario" value="<?php echo $_SESSION['usuario'];?>">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group" id="sel_password1">
                            <label for="password1">Contraseña</label>
                            <input type="password" class="form-control" id="password1" placeholder="" v-model="password1">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group" id="sel_password2">
                            <label for="password2">Repetir Contraseña</label>
                            <input type="password" class="form-control" id="password2" placeholder="" v-model="password2">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="graba_pass" style="float:left;" @click="actualiza_password()">
                                <i class="glyphicon glyphicon-floppy-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var pass_panel = new Vue({
        el: '#pass_panel',
        data: {
            codusuario:"<?php echo $_SESSION['usuario'];?>",
            password1:"",
            password2:""
        },
        created: function () {
        },
        methods:{
            actualiza_password(){
                if(pass_panel.password1!="" && pass_panel.password2!=""){
                    if(pass_panel.password1 == pass_panel.password2){
                        $("#sel_password1").removeClass("has-error has-feedback");
                        $("#sel_password2").removeClass("has-error has-feedback");
                        axios.post('controlador/actualiza_password.php',{
                            codusuario:pass_panel.codusuario,
                            password1:pass_panel.password1,
                            password2:pass_panel.password2
                        }).then(function (response) {
                            pass_panel.password1="";
                            pass_panel.password2="";
                            swal("¡Operación exitosa! Se actualizó la contraseña", { icon: "success", });
                        });
                    } else {
                        $("#sel_password1").addClass("has-error has-feedback");
                        $("#sel_password2").addClass("has-error has-feedback");
                        swal("¡Error! Las contraseñas no coinciden", { icon: "error", });
                    }
                } else {
                    if(pass_panel.password1==""){
                        $("#sel_password1").addClass("has-error has-feedback");
                        swal("¡Error! Por favor, ingrese la contraseña", { icon: "error", });
                    } else {
                        $("#sel_password1").removeClass("has-error has-feedback");
                        if(pass_panel.password2==""){
                            $("#sel_password2").addClass("has-error has-feedback");
                            swal("¡Error! Por favor, repita la contraseña", { icon: "error", });
                        } else {
                            $("#sel_password2").removeClass("has-error has-feedback");
                        }
                    }
                }
            }
        }
    });
</script>
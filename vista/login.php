<!doctype html>
<html>
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./vista/css/bootstrap.min.css">
    <link rel="stylesheet" href="./vista/css/login_style.css">
    <script src="./vista/js/jquery.min.js"></script>
    <script src="./vista/js/bootstrap.min.js"></script>
    <script src="./vista/js/vue.js"></script>
    <script src="./vista/js/axios.min.js"></script>
    <title>Bayental App</title>
</head>
<body>
<div class="container" id="app_login">
    <div class="card card-container">
        <img src="./vista/img/CRM-2.png" class="center-block img-responsive">
        <p id="profile-name" class="profile-name-card"></p>
        <div class="titulo"></div>
        <form class="form-signin">
            <div id="resultado"></div>
            <input type="text" class="form-control" v-model="user" placeholder="Usuario" required autofocus>
            <input type="password" class="form-control" v-model="pass" placeholder="Contraseña" required>
            <div><p></p></div>
            <button type="button" class="btn btn-primary" @click="verificarLogin()">Ingresar</button>
        </form>
    </div>
</div>
<script>
    var app = new Vue({
        el: '#app_login',
        data: {
            user: "",
            pass: ""
        },
        created: function () {
        },
        methods: {
            verificarLogin(){
                let me = this;
                var usuario = app.user;
                var pass = app.pass;
                if(usuario!="" && pass!=""){
                    axios.post('controlador/login_getlogininfo.php',{
                        username:this.user,
                        userpass:this.pass
                    }).then(function (response) {
                        if(response.data==0){
                            me.user="";
                            me.pass="";
                            $("#resultado").html("<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>Usuario y/o contraseña incorrecto(a)</div>");
                        } else {
                            location.assign("../app_maqueta/inicio.php");
                        }
                    });
                } else {
                    $("#resultado").html("<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>x</a>Por favor, ingrese la información solicitada</div>");
                }
            }
        },
        mounted() {
        }
    });
</script>
</body>
</html>
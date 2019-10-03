<?php
require_once($_SERVER['DOCUMENT_ROOT']."/app_maqueta/configuracion/conectar.php");

class usuario_model{
    
    public function __construct(){}

    public function valida_acceso($user,$pass){
        $busqueda = array();
        $valor_hash=$this->get_hash($user);
        if($valor_hash!=null) {
            $hash_x = hash('sha256',$pass.$valor_hash['salt']);
            if ($valor_hash['hashcode'] == $hash_x) {
                $row = DB::queryFirstRow("select * from usuarios where codusuario=%s and estado=1",$user);
                return $row;
            } else {
                return "";
            }
        } else {
            return "";
        }
    }

    public function update_user($id_usuario,$id_persona,$nombre1,$nombre2,$apellido1,$apellido2,$dni,$perfil,$super_adm){
        DB::update('personas',array(
            'nombre1'=>$nombre1,
            'nombre2'=>$nombre2,
            'apellido1'=>$apellido1,
            'apellido2'=>$apellido2,
            'dni'=>$dni
        ),'id=%i',$id_persona);
        DB::update('usuarios',array(
            'idperfil'=>$perfil,
            'superadm'=>$super_adm
        ),'id=%i',$id_usuario);
    }

    public function get_hash($codusuario) {
        $row = DB::queryFirstRow("select hashcode,salt from login_code where codusuario=%s",$codusuario);
        return $row;
    }

    public function get_campanas(){
        $rows = DB::query("select * from campanas where estado=1");
        return $rows;
    }

    public function get_all_user_campaign($id){
        $resultado = "";
        $rows = DB::query("select * from acceso where idusuario=%i and estado=1",$id);
        $rows1 = DB::queryFirstRow()("select id from campanas order by id desc");
        foreach($rows as $rs){
            $rows2 = DB::query("select * from campanas where id=%i",$rs['idcampana']);
            if ($rows2['id']!=$rows1['id']) {
                $resultado.=$rows2['descripcion']." | ";
            } else {
                $resultado.=$rows2['descripcion'];
            }
        }
        return $resultado;
    }

    public function get_num_camp(){
        $row = DB::query("select count(*) as cuenta from campanas where estado=1");
        return $row['cuenta'];
    }

    public function get_menu_items($campana){
        $rows = DB::query("select * from menu where campana=%i and estado=1 order by id asc",$campana);
        return $rows;
    }

    public function get_submenu_items($id_menu){
        $rows = DB::query("select * from submenu where id_menu=%i and estado=1 order by id asc",$id_menu);
        return $rows; 
    }
    
    public function get_personal_info($id){
        $row = DB::queryFirstRow("select * from personas where idusuario=%i",$id);
        return $row;
    }

    public function get_sysuser_info($id){
        $row = DB::queryFirstRow("select * from usuarios where id=%i",$id);
        return $row;
    }

    public function get_username($id){
        $row = DB::queryFirstRow("select codusuario from usuarios where id=%i order by id desc",$id);
        return $row;
    }

    public function get_user_perfil($id){
        $rows = DB::query("select descripcion from perfiles where id=%i",$id);
        return $rows;
    }

    public function get_all_perfiles(){
        $rows = DB::query("select * from perfiles where estado=1");
        return $rows;
    }

    public function get_all_users($nombre,$perfil){
        $rows = "";
        if($nombre!="" && $perfil==""){
            $rows = DB::query("SELECT * FROM usuarios WHERE codusuario like %ss or id IN (SELECT idusuario FROM personas WHERE CONCAT(nombre1,nombre2,apellido2,apellido2) LIKE %ss)",$nombre,$nombre);
        }
        if($nombre=="" && $perfil!=""){
            $rows = DB::query("SELECT * FROM usuarios WHERE idperfil=%i",$perfil);
        }
        if($nombre=="" && $perfil==""){
            $rows = DB::query("SELECT * FROM usuarios");
        }
        if($nombre!="" && $perfil!=""){
            $rows = DB::query("SELECT * FROM usuarios WHERE codusuario like %ss or id IN (SELECT idusuario FROM personas WHERE CONCAT(nombre1,nombre2,apellido1,apellido2) LIKE %ss) AND idperfil=%i",$nombre,$nombre,$perfil);
        }
        return $rows;
    }

    public function get_perfil($id){
        $rows = DB::queryFirstRow("select idperfil from usuarios where id=%i",$id);
        return $rows['idperfil'];
    }

    public function cambia_estado($id,$opt){
        DB::update('usuarios',array(
            'estado'=>$opt
        ),'id=%i',$id);
    }

    public function accesa_campana($idusuario,$idcampana){
        $rows = DB::query("select * from acceso where idusuario=%i and idcampana=%i",$idusuario,$idcampana);
        if($rows!=null){
            if($rows[0]['estado']==1){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function accesa_superadm($id){
        $rows = DB::query("select superadm from usuarios where id=%i",$id);
        return $rows['superadm'];
    }

    public function valida_permiso_menu_unico($idperfil,$id_menu,$idcampana){
        $busqueda = array();
        $validacion = false;
        $rows = DB::queryFirstRow("select * from permisos where idperfil=%i and id_menu=%i and idcampana=%i and estado=1 order by id",$idperfil,$id_menu,$idcampana);
        foreach($rows as $rs){
            $busqueda[] = $rs;
        }
        if($busqueda!=null){$validacion=true;}
        return $validacion;
    }

    public function valida_permiso_submenu($idperfil,$id_menu,$id_submenu,$idcampana){
        $busqueda = array();
        $validacion = false;
        $rows = DB::queryFirstRow("select * from permisos where idperfil=%i and id_menu=%i and id_submenu=%i and idcampana=%i and estado=1 order by id",$idperfil,$id_menu,$id_submenu,$idcampana);
        foreach($rows as $rs){
            $busqueda[] = $rs;
        }
        if($busqueda!=null){$validacion=true;}
        return $validacion;
    }

    public function set_acceso($idusuario,$idcampana,$estado){
        if($estado!=0){$estado=1;}
        $rows = DB::query("select * from acceso where idusuario=%i and idcampana=%i",$idusuario,$idcampana);
        if($rows!=null){
            DB::update('acceso',array(
                'estado'=>$estado
            ),'idusuario=%i and idcampana=%i',$idusuario,$idcampana);
            
        } else {
            DB::insert('acceso',array(
                'idusuario'=>$idusuario,
                'idcampana'=>$idcampana,
                'estado'=>$estado
            ));
        }
    }

    public function existe_user($codusuario){
        $rows = DB::query("select * from usuarios where codusuario=%s",$codusuario);
        if($rows!=null){
            return true;
        } else {
            return false;
        }   
    }

    public function set_new_user($nombre1,$nombre2,$apellido1,$apellido2,$dni,$idperfil,$superadm,$password1){
        $codusuario = substr($nombre1,0,1);
        $apellido1 = str_replace("Ñ","N",$apellido1);
        $first_c = substr($apellido2,0,1);
        $codusuario.=$apellido1;
        if($this->existe_user($codusuario)==true){$codusuario.=$first_c;}
        if ($this->existe_user($codusuario)==false) {
            $codusuario = strtolower($codusuario);
            $rows = DB::queryFirstRow("select id from personas order by id desc");
            $id_persona = $rows['id']+1;
            DB::insert('usuarios',array(
                'idpersona'=>$id_persona,
                'codusuario'=>$codusuario,
                'idperfil'=>$idperfil,
                'superadm'=>$superadm
            ));
            $rows1 = DB::queryFirstRow("select * from usuarios where codusuario=%s order by id desc",$codusuario);
            DB::insert('personas',array(
                'idusuario'=>$rows1['id'],
                'dni'=>$dni,
                'nombre1'=>$nombre1,
                'nombre2'=>$nombre2,
                'apellido1'=>$apellido1,
                'apellido2'=>$apellido2
            ));
            $pass_salt = $this->generateHashWithSalt($password1);
            $pass_salt_val = explode("|",$pass_salt);
            $hash = $pass_salt_val[0];
            $salt = $pass_salt_val[1];
            DB::insert('login_code',array(
                'codusuario'=>$codusuario,
                'hashcode'=>$hash,
                'salt'=>$salt
            ));
            
            return $codusuario;
        } else {
            return "existe";
        }
    }

    public function actualiza_password($codusuario,$password){
        $pass_salt = $this->generateHashWithSalt($password);
        $pass_salt_val = explode("|",$pass_salt);
        $hash = $pass_salt_val[0];
        $salt = $pass_salt_val[1];
        DB::update('login_code',array(
            'hashcode'=>$hash,
            'salt'=>$salt
        ),'codusuario=%s',$codusuario);
    }

    public function elimina_permisos($idperfil,$idcampana){
        DB::delete('permisos','idperfil=%i and idcampana=%i',$idperfil,$idcampana);
    }

    public function asigna_permisos($idperfil,$idcampana,$id_menu,$id_submenu){
        DB::insert('permisos',array(
            'idperfil'=>$idperfil,
            'id_menu'=>$id_menu,
            'id_submenu'=>$id_submenu,
            'idcampana'=>$idcampana
        ));
    }

    public function existe_en_permisos($idperfil,$id_menu,$id_submenu,$idcampana){
        $rows = DB::query("select * from permisos where idperfil=%i and id_menu=%i and id_submenu=%i and idcampana=%i",$idperfil,$id_menu,$id_submenu,$idcampana);
        if($rows!=null){
            return true;
        } else {
            return false;
        }
    }

    public function contiene_elementos_activos($id_menu,$idcampana,$idperfil){
        $resultado = 0;
        $rows = DB::query("select * from submenu where id_menu=%i and estado=1 order by id asc",$id_menu);
        foreach($rows as $rs){
            $rows1 = DB::query("select * from permisos where idperfil=%i and id_menu=%i and id_submenu=%i and idcampana=%i",$idperfil,$id_menu,$rs['id'],$idcampana);
            if($rows1!=null){
                $resultado = 1;
            }
        }
        return $resultado;
    }

    function generateHashWithSalt($password) {
        define("MAX_LENGTH", 6);
        $intermediateSalt = md5(uniqid(rand(), true));
        $salt = substr($intermediateSalt, 0, MAX_LENGTH);
        return hash("sha256", $password . $salt)."|".$salt;
    }

    function generar_password_complejo($largo){
        $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $cadena_base .= '0123456789' ;
        //$cadena_base .= '!@#%^&*()_,./<>?;:[]{}\|=+';
        $cadena_base .= '#%&*+';
       
        $password = '';
        $limite = strlen($cadena_base) - 1;
       
        for ($i=0; $i < $largo; $i++)
          $password .= $cadena_base[rand(0, $limite)];
       
        return $password;
      }

    public function guarda_log($dato){
        $fp = fopen("../logs/querys.txt", "a");
        fputs($fp, $dato."\r\n");
        fclose($fp);
    }
}
?>
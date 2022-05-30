<?php
    /**
     * Redireccionar: Redirecciona al usuario a la página principal segun su rol
     */
    
    function regularNavegacion($id){
        if(isset($_SESSION["tip_user"]) && $_SESSION["tip_user"] != null){
            if($_SESSION["tip_user"] != $id){
                echo $_SESSION["tip_user"];
                echo " ".$id;
                header("Location: ../FrontEnd/index.front.php");
            }
        }
        else{
            header("Location: ../FrontEnd/index.front.php");
        }
    }

    /**
     * Enviar Correos a x momento
     */
    function SendEmailsProgramed(){
        $mimanejo = 77;
        $contrasena = 30;
        $tiempos = 10;
        for($w = 0; $w < $tiempos; $w++) {
        sleep($contrasena);
        $prueba = fopen("$mimanejo.txt","w+");
        fclose($prueba);
        $mimanejo++;
        include('mail.php');
        }
    }
    /**
     * Generacion AntiCSRF
     */
    function GenerarAntiCSRF(){
        // $_SESSION['anticsrf'] = md5(random_int(1000, 9999));
        // return $_SESSION['anticsrf'];
        $anticsrf = md5(random_int(1000, 9999));
        $_SESSION['anticsrf'] = $anticsrf;
     }

    /**
     * Limpieza de entradas de formularios en todo el sistema
     */
    function LimpiarEntradas(){
        if(isset($_POST)){
            foreach($_POST as $key => $value){
                $_POST[$key] = LimpiarCadena($value);
            }
        }
    }
    function LimpiarCadena($cadena){
        $patron = array('/<script>/','/<\/script>/','/</','/>/','/"/','/\'/');
        $cadena = preg_replace($patron,'',$cadena);
        $cadena = htmlspecialchars($cadena);
        return $cadena;
    }

    /**
     * Presentaciòn de errores en interfaz de usuario
     */
    function MostrarErrores(){
        error_reporting(E_ALL);
        ini_set('display_errors',1);
        ini_set('display_startup_errors', 1);
    }

    function IniciarSesionSegura(){
        
        if(ini_set('session.use,only_cookies',1)==FALSE){
            $action = "error";
            $error = "No puedo iniciar una sesion segura";
        }
    
        $cookieParams = session_get_cookie_params();
        $path = $cookieParams["path"];

        $secure = true;    
        $httponly = true;    
        $samesite = 'strict';  

        session_set_cookie_params([
            'lifetime' => $cookieParams["lifetime"],
            'path' => $path,
            'domain' => $_SERVER['HTTP_HOST'],//dominio
            'secure' => $secure,
            'httponly'=> $httponly,
            'samesite' => $samesite
        ]);
        
        session_start();
        // session_regenerate_id(true);
    }

    /**
     * 
     */

    function closeSession(){
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {

            $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
        }
        // Finalmente, destruir la sesión.
        session_destroy();
        header('Location:index.front.php');
     }
?>
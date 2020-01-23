<?php
/**
 * SEP 15 DE 2014
 * CLASE ENCARGADA DEL MANEJO DE LAS SESSIONES DEL APLICATIVO
 * ESTABLECE Y RECUPERA DATOS DE LAS VARIABLES DE SESSION
 * CONTROLA EL TIEMPO QUE DURA  LA SESIÓN DE UN USUARIO UNA VEZ QUE SE HA LOGUEADO
 *Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36
 */
	class Session
	{

        public static function Init( $NombreSession ){

          session_cache_limiter('nocache,private');
          session_name( $NombreSession );
          session_start();

            /* Establecemos que las paginas no pueden ser cacheadas */
          header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
          header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
          header("Cache-Control: no-store, no-cache, must-revalidate");
          header("Cache-Control: post-check=0, pre-check=0", false);
          header("Pragma: no-cache");


		}


        /**
         * SEP 27 DE 2014
         * DESTRE UNA VARIABLE(S) DE SESSION
         * @param boolean $clave [Nombre de la clave que se va a destruir]
         */
        public static function Destroy( $clave = false){
            if($clave) {
                if(is_array($clave)) {
                    for($i = 0; $i < count($clave); $i++) {
                        if(isset($_SESSION[$clave[$i]])) {  unset($_SESSION[$clave[$i]]); }
                    }
                }
                else{
                    if(isset($_SESSION[$clave])) {
                        unset($_SESSION[$clave]);
                    }
                }
              } else {
                foreach($_SESSION as $key => $value) {
                        $_SESSION[$key] = NULL;
                        unset( $_SESSION[$key] );
                }

                $_SESSION           = array();
                session_unset();
                session_unset( $_SESSION );
                session_destroy();
            }
        }


    public static function Iniciar_Variable($Variable, $Valor)
    {
         if( !isset($_SESSION[ $Variable ]) ) {
            $_SESSION[$Variable] = $Valor;
         }


    }

        public static function LogOut(){
            session_unset();
            session_destroy();
            session_start();
            session_regenerate_id(true);

           /* $_SESSION['userAgent']       = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['SKey']            = uniqid(mt_rand(), true);
            $_SESSION['IPaddress']       = $_SERVER['REMOTE_ADDR'];
            $_SESSION['LastActivity']    = $_SERVER['REQUEST_TIME'];
*/

        }

        public static function Set( $clave, $valor )        {

            $clave = trim($clave);
            if(!empty($clave))
            $_SESSION[$clave] = $valor;

        }

        public static function Get( $clave ) {
            $clave = trim($clave);
            if(isset($_SESSION[$clave]))
            return $_SESSION[$clave];
        }


        /**
         * SEP 29 DE 204
         * CONTROLA EL TIEMPO QUE EL USAURIO PODRÁ TRABAJAR EN EL SISTEMA
         */
    public static function Tiempo()
    {
        if(!Session::Get('Tiempo') || !defined('SESSION_TIME'))
            {  throw new Exception('No se ha definido el tiempo de sesión.');  }

        if(SESSION_TIME == 0) // Tiempo se sesión indefinido
            {  return; }

        // si ha pasado más del tiempo establecido, se cierra la sessión
        if(time() - Session::Get('Tiempo') > (SESSION_TIME * 60))
        {
            Session::Destroy();
            header('location:' . BASE_URL . 'error/access/8080');
        }
        else
            {   Session::Set('Tiempo', time()); }
    }


           /*$IpVisitante   = $_SERVER['REMOTE_ADDR'];
           $Navegador     = $_SERVER['HTTP_USER_AGENT'];
           $NombrePC      = gethostname() ;
           $Usuario       = get_current_user();
           $IpVisitante   = preg_replace('/[^A-Za-z0-9_]/', '', $IpVisitante);
           $Navegador     = preg_replace('/[^A-Za-z0-9_]/', '', $Navegador);
           $Usuario       = preg_replace('/[^A-Za-z0-9_]/', '', $Usuario );
           $NombrePC      = preg_replace('/[^A-Za-z0-9_]/', '', $NombrePC );

           $Identificador = $Usuario.$NombrePC.$IpVisitante.$Navegador;
           $Identificador = substr($Identificador,0,80);

*/

            /*if (session_status() == PHP_SESSION_NONE) {
                session_set_cookie_params(0,"/");
                session_start();
            }
                */

}
?>

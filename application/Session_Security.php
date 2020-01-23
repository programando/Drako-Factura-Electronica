	<?php
    class Session_Security
	{


        public  function Validate_Session( ){

          //md5(TOKEN_PASSWORDS . microtime().rand(1,9999999999999999999999999));
          $Ip       = $this->Get_Ip();
          $Session  = TOKEN_PASSWORDS .  $_SERVER['HTTP_USER_AGENT'] . $Ip ;
          $Session  = 'SES'.md5( $Session );

           return    $Session ;
		}






        private function Get_Ip(){

            if (isset($_SERVER["HTTP_CLIENT_IP"]))            {
                    return $_SERVER["HTTP_CLIENT_IP"];
                }
                elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
                {
                    return $_SERVER["HTTP_X_FORWARDED_FOR"];
                }
                elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
                {
                    return $_SERVER["HTTP_X_FORWARDED"];
                }
                elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
                {
                    return $_SERVER["HTTP_FORWARDED_FOR"];
                }
                elseif (isset($_SERVER["HTTP_FORWARDED"]))
                {
                    return $_SERVER["HTTP_FORWARDED"];
                }
                else
                {
                    return $_SERVER["REMOTE_ADDR"];
                }



        }

}


          // Debug::Mostrar( $_SERVER['HTTP_USER_AGENT'] );

          /*  $Nombre_Archivo = sys_get_temp_dir()."TRON.txt";
            if ( !file_exists($Nombre_Archivo)) {
                $Session = md5(TOKEN_PASSWORDS . microtime().rand(1,9999999999999999999999999));
                $File    = fopen($Nombre_Archivo, "w");
                fwrite( $File, $Session. PHP_EOL );
                fclose( $File );
            }

            $File    = fopen($Nombre_Archivo, "r");
            $Session =  fgets($File) ;
            fclose( $File );

            $Long = strlen( $Session );

            //if ( !isset( $Session ) || empty( $Session ) || ( $Long < 32) ){
              //  $this->Validate_Session();
           // }
*/

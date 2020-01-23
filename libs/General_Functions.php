<?php

	class General_Functions
	{

public static function Menor_Entre_2_Numeros ( $numero1 , $numero2){

			$Menor = $numero1;
			if ( $numero2 < $Menor && $numero2 > 0 ){
					$Menor = $numero2;
			}
			return $Menor ;
		}

		public static function Generar_Codigo_Unico($longitud=5)
	{
		$key     = '';
		$pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
		$max     = strlen($pattern)-1;
	 for($i=0;$i < $longitud;$i++)
	 	{
	 		 $key .= $pattern{mt_rand(0,$max)};
	 	}
	 return strtoupper($key);
	}

public static function Generar_Codigo_Confirmacion($longitud=6){
		$codigo              = General_Functions::Generar_Codigo_Unico();
		$numero              = mt_rand(123456789,999999999);
		$codigo_confirmacion = md5($codigo.$numero.TOKEN_PASSWORDS);
		return $codigo_confirmacion;
}


public static  function Eliminar_Acentos($cadena){

    //Codificamos la cadena en formato utf8 en caso de que nos de errores
    //$cadena = utf8_encode($cadena);

    //Ahora reemplazamos las letras
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä','´','`'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A','',''),
        $cadena   );

    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );

    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );

    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );

    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );

    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );

    return $cadena;
}


	public static function Validar_Entrada($Clave,$Tipo_Validacion)
			{
				/* SEPTIEMBRE 13 DE 2014
						Valida y depura la entrada recibida por POST
				*/
						if (isset($_POST[$Clave]))
						{
							$Clave_Recibida = $_POST[$Clave];
							$Tipo_Variable  = gettype($Clave_Recibida);

							if (!empty($Clave_Recibida))
							{
								switch ($Tipo_Validacion)
								{
										case 'EMAIL':

											$Email_Recibido = $Clave_Recibida;
											$Clave_Recibida =  filter_var($Clave_Recibida, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $Clave_Recibida);
											if ($Clave_Recibida == true)
													{
															$Clave_Recibida  = $Email_Recibido;
													}else
												 	{
												   $Clave_Recibida  = false ;
											   }
										break;

										case 'BOL':
													$Clave_Recibida = filter_var($Clave_Recibida,FILTER_VALIDATE_BOOLEAN);
													break;

									case 'TEXT':
													$Clave_Recibida =  General_Functions::Eliminar_Acentos( $Clave_Recibida );
												 //$Clave_Recibida =  trim(htmlspecialchars( strtoupper($Clave_Recibida), ENT_QUOTES));
													$Clave_Recibida =  trim(htmlspecialchars( ($Clave_Recibida), ENT_QUOTES));
													break;

									case 'TEXT-EMAIL':
													$Clave_Recibida = trim(htmlspecialchars( strtolower( $Clave_Recibida), ENT_QUOTES));
													break;

									case 'NUM':
													$Clave_Recibida  = filter_var($Clave_Recibida ,FILTER_VALIDATE_INT);
												 break;

									case 'DEC':
													$Clave_Recibida  = filter_var($Clave_Recibida ,FILTER_VALIDATE_FLOAT);
												 break;

									case 'FECHA':
													$valores								=  explode("/", $Clave_Recibida);
													$Clave_Recibida =  $valores[2].'-'.$valores[1].'-'.$valores[0];
												 $Clave_Recibida =  strtotime($Clave_Recibida );
												 $Clave_Recibida =  date('Y-m-d',$Clave_Recibida);
												 break;

									case 'FECHA-HORA':
													$valores          =  explode("/", $Clave_Recibida);
													$anio             = substr($valores[2], 0,4);
													$horas            = substr($valores[2], 5,2).':';
													$minutos          = substr($valores[2], 8,2).':';
													$segundos         ='00';
													$Clave_Recibida   =  $anio.'-'.$valores[1].'-'.$valores[0] .' '. $horas . $minutos . 	$segundos;
													$Clave_Recibida   =  strtotime($Clave_Recibida );
													$Clave_Recibida   =  date('Y-m-d H:i:s',$Clave_Recibida);
												 break;

									default:
										if ($Tipo_Variable=='N' )
										     { $Clave_Recibida =  0 ; }
										else { $Clave_Recibida = '' ;  }
										break;
								}
									 $_POST[$Clave] = $Clave_Recibida;
							}

							 return  $Clave_Recibida;
					}
		 }



public static function Datos_Navegador()
{
/**
		*$info=detect();
		*echo "Sistema operativo: ".$info["os"];
		*echo "Navegador: ".$info["browser"];
		*echo "Versión: ".$info["version"];
		*echo $_SERVER['HTTP_USER_AGENT'];
*/
$browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
	$os=array("WIN","MAC","LINUX");

	# definimos unos valores por defecto para el navegador y el sistema operativo
	$info['browser'] = "OTHER";
	$info['os'] = "OTHER";

	# buscamos el navegador con su sistema operativo
	foreach($browser as $parent)
	{
		$s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
		$f = $s + strlen($parent);
		$version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
		$version = preg_replace('/[^0-9,.]/','',$version);
		if ($s)
		{
			$info['browser'] = $parent;
			$info['version'] = $version;
		}
	}

	# obtenemos el sistema operativo
	foreach($os as $val)
	{
		if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
			$info['os'] = $val;
	}

	# devolvemos el array de valores
	return $info;
}



public static function urls_amigables($url) {

// Tranformamos todo a minusculas

			$url = strtolower($url);

			//Rememplazamos caracteres especiales latinos

			$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');

			$repl = array('a', 'e', 'i', 'o', 'u', 'n');

			$url = str_replace ($find, $repl, $url);

			// Añaadimos los guiones

			$find = array(' ', '&', '\r\n', '\n', '+','  ');
			$url = str_replace ($find, '-', $url);

			// Eliminamos y Reemplazamos demás caracteres especiales

			$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');

			$repl = array('', '-', ' ');

			$url = preg_replace ($find, $repl, $url);

			return 	$url;
}


}

?>

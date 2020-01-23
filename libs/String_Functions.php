<?php
	Class String_Functions
	{
				public static function Camel($value)
				{
					// Convierte cadena en array
					$segmentos = explode('-',$value);
					// array_walk -> Recorre secuencialmente un array y por cada llamada.... invoca una funcion (Anónima)
					// array_walk($segmentos, function (&$item)
					array_walk($segmentos, function (&$item)
					{
						// En cada iterracción convierte a mayúsculas la primera letra dela palabra
						$item = ucfirst($item);
					});
					// convierte un array en una cadena, en este caso sin espacios.
					return implode('',$segmentos);
				}

				// Convierte una cadena en minusculas
				public static function LowerCamel ($value)
				{
					return lcfirst(static::Camel($value));
				}

				Public static function Mayusculas($Variable)
				{
					$Variable =  trim(utf8_encode(htmlentities(strtoupper($Variable))));
						return $Variable;
				}


		public static function Formato_Texto($Variable)
			{
					$Variable = trim( htmlentities($Variable) );
					return 	$Variable ;
			}

			public static function Nombre_Mes ( $mes){
						if($mes == 1)	$mes = "Enero";
						if($mes == 2)	$mes = "Febrero";
						if($mes == 3)	$mes = "Marzo";
						if($mes == 4)	$mes = "Abril";
						if($mes == 5)	$mes = "Mayo";
						if($mes == 6)	$mes = "Junio";
						if($mes == 7)	$mes = "Julio";
						if($mes == 8)	$mes = "Agosto";
						if($mes == 9)	$mes = "Septiembre";
						if($mes == 10)	$mes = "Octubre";
						if($mes == 11)	$mes = "Noviembre";
						if($mes == 12)	$mes = "Diciembre";

				return $mes;
			}

				public static	function Sin_Acentos ($cadena){
		    $originales 	= 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕñ';
		    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRrn';
		    $cadena 					= utf8_decode ($cadena );
		    $cadena 					= strtr( $cadena, utf8_decode($originales), $modificadas);
		    $cadena 					= strtoupper( $cadena );
		    return utf8_encode( $cadena );
		}

}

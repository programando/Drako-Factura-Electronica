<?php

Class Debug
{

	public static function Mostrar($var=array()){
		echo '<pre>';
		print_r($var);
		echo '</pre>';
		echo '------';


	}

	public static function Archivo($texto,$valor,  $cerrar=FALSE){
		if ( !isset( $file )){
			$file = fopen("c:/revision_php.txt", "w");
		}
		fwrite($file,$texto . '  --->> ' . $valor . PHP_EOL);
		if ( $cerrar == TRUE ){
			fclose( $file  );
		}
	}

}

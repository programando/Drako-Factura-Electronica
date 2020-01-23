<?php
		class FacturaElectronicaModel extends Model
		{
				public $Cantidad_Registros;

				public function __construct()
				{
					parent::__construct();
				}

        public function fact_01_enc()   {
            /** JUNIO 11 2019
            *   CONSULTA FACTURAS GENERAS QUE NO SE HAN ENVIADO A LA DIAN   */
            $Facturas                 = $this->Db->Ejecutar_Sp("fact_01_enc_pndte_envio_dian()");
            //Debug::Mostrar ( $Facturas  );

            return    $Facturas   ;
        }

        public function fact_02_emi ( $_id_fact_elctrnca )   {
            $Facturas                 = $this->Db->Ejecutar_Sp("fact_02_emi_pndte_envio_dian( $_id_fact_elctrnca )");
            return    $Facturas   ;
        }
        public function checkDocumentsStatus (  )   {
            $Facturas                 = $this->Db->Ejecutar_Sp("fact_01_enc_status_check( )");
            return    $Facturas   ;
        }

        public function fact_01_Respuesta_Operador ( $_id_fact_elctrnca, $errorMessage, $transactionId, $documentNumber, $CUFE )   {
           $Facturas  = $this->Db->Ejecutar_Sp("fact_01_enc_respuesta_operador( $_id_fact_elctrnca, '$errorMessage', '$transactionId', '$documentNumber', '$CUFE' )");
        }

        public function updateUploadFile ( $_id_fact_elctrnca, $idTransaction, $uploadCode, $uploadError, $uploadSuccess )   {
           $Facturas  = $this->Db->Ejecutar_Sp("fact_01_enc_upload_update ( $_id_fact_elctrnca, '$idTransaction',  '$uploadCode', '$uploadError', '$uploadSuccess')");
        }

        public function updateDocumentStatus (  $idTransaction, $statusCode, $statusSuccess, $statusError )   {
           $Facturas  = $this->Db->Ejecutar_Sp("fact_01_enc_status_update ( '$idTransaction',  '$statusCode', '$statusSuccess', '$statusError')");
        }

        public function fact_01_UpdateErroresLayout ( $_id_fact_elctrnca, $errorMessage )   {
           $Facturas  = $this->Db->Ejecutar_Sp("fact_01_enc_respuesta_operador_errores( $_id_fact_elctrnca, '$errorMessage')");
        }

        public function fact_03_adq ( $_id_fact_elctrnca )   {
            $Facturas                 = $this->Db->Ejecutar_Sp("fact_03_adq_pndte_envio_dian( $_id_fact_elctrnca )");
            return    $Facturas   ;
        }
        public function fact_04_tot ( $_id_fact_elctrnca )   {
            $Facturas                 = $this->Db->Ejecutar_Sp("fact_04_tot_pndte_envio_dian( $_id_fact_elctrnca )");
            return    $Facturas   ;
        }
        public function fact_05_imp ( $_id_fact_elctrnca )   {
            $Facturas                 = $this->Db->Ejecutar_Sp("fact_05_imp_pndte_envio_dian( $_id_fact_elctrnca )");
            return    $Facturas   ;
        }
        public function fact_06_dsc ( $_id_fact_elctrnca )    {
            $Facturas                 = $this->Db->Ejecutar_Sp("fact_06_dsc_pndte_envio_dian( $_id_fact_elctrnca )");
            return    $Facturas   ;
        }
        public function fact_07_drf ( $_id_fact_elctrnca )    {
            $Facturas                 = $this->Db->Ejecutar_Sp("fact_07_drf_pndte_envio_dian ( $_id_fact_elctrnca )");
            return    $Facturas   ;
        }
				public function fact_08_ttd ( $_id_fact_elctrnca )		{
						$Facturas                 = $this->Db->Ejecutar_Sp("fact_08_ttd_pndte_envio_dian ( $_id_fact_elctrnca )");
						return 		$Facturas   ;
				}
        public function fact_09_not ( $_id_fact_elctrnca )    {
            $Facturas                 = $this->Db->Ejecutar_Sp("fact_09_not_pndte_envio_dian ( $_id_fact_elctrnca )");
            return    $Facturas   ;
        }
        public function fact_10_ref ( $_id_fact_elctrnca )    {
            $Facturas                 = $this->Db->Ejecutar_Sp("fact_10_ref_pndte_envio_dian ( $_id_fact_elctrnca )");
            return    $Facturas   ;
        }
        public function fact_11_fe1 ( $_id_fact_elctrnca )    {
            $Facturas                 = $this->Db->Ejecutar_Sp("fact_11_fe1_pndte_envio_dian ( $_id_fact_elctrnca )");
            return    $Facturas   ;
        }
        public function fact_12_ite ( $_id_fact_elctrnca )    {
            $Facturas                 = $this->Db->Ejecutar_Sp("fact_12_ite_pndte_envio_dian ( $_id_fact_elctrnca )");
            return    $Facturas   ;
        }


  }
?>

<?php

class FacturaElectronicaController extends Controller
{
   var  $id_fact_elctrnca, $EMI, $ADQ, $TOT, $IMP, $DRF, $ITE, $NOT, $REF ;
   var $xml, $TipoDocumento, $CadenaBase64, $idTransactionXml;
   var $statusCode, $statusError, $statusSuccess ;
   var $uploadCode, $uploadError, $uploadSuccess ;
   var $nombreDocumento, $nomDocCreado ;

    public function __construct() {
        parent::__construct();
        $this->Factura = $this->Load_Model('FacturaElectronica');
    }


    public function index(){}

        public function GenerarXML () {
            $this->facturasPendientes  () ;
        }


        private function facturasPendientes ()    {
          $this->id_fact_elctrnca = 0 ;
          $FacturasPendientes     = $this->Factura->fact_01_enc();

          foreach ( $FacturasPendientes as $Factura ) {
               $this->ENC    = $Factura;
               //Llamada de todos los datos de la factura almacencados en los diferentes archivos
               $this->consultaDatosFactura( $Factura['id_fact_elctrnca'] );
               //Generación de los datos de la factura en cada uno de los archivos
               $this->xmlInicioArchivo( $this->TipoDocumento, $Factura['_06_nro_fctra'] );
                  $this->ENC () ;
                  $this->EMI () ;
                  $this->ADQ () ;
                  $this->TOT () ;
                  $this->TIM () ;
                  $this->DRF () ;
                  $this->NOT () ;
                  $this->REF () ;
                  $this->MEP () ;
                  $this->CDN () ;
                  $this->ITE () ;
              $this->xmlFinalArchivo();
              $this->id_fact_elctrnca =  $Factura['id_fact_elctrnca'] ;

              if ( $this->id_fact_elctrnca  > 0 )  {
                $this->uploadFile          ();
                $this->updateUploadFile    () ;
              }
            } // Fin for each
        }


      private function consultaDatosFactura ( $id_fact_elctrnca ) {
          /* Octubre 23 2019
              Llamada de todos los datos de la factura almacencados en los diferentes archivos
          */
          $this->id_fact_elctrnca = $id_fact_elctrnca ;
          $this->EMI = $this->Factura->fact_02_emi ( $this->id_fact_elctrnca );
          $this->ADQ = $this->Factura->fact_03_adq ( $this->id_fact_elctrnca );
          $this->TOT = $this->Factura->fact_04_tot ( $this->id_fact_elctrnca );
          $this->IMP = $this->Factura->fact_05_imp ( $this->id_fact_elctrnca );
          $this->DRF = $this->Factura->fact_07_drf ( $this->id_fact_elctrnca );
          $this->ITE = $this->Factura->fact_12_ite ( $this->id_fact_elctrnca );
          $this->NOT = $this->Factura->fact_09_not ( $this->id_fact_elctrnca );
          $this->REF = $this->Factura->fact_10_ref ( $this->id_fact_elctrnca );

          $this->EMI = $this->EMI[0] ;
          $this->ADQ = $this->ADQ[0] ;
          $this->TOT = $this->TOT[0];
          $this->IMP = $this->IMP[0];
          $this->DRF = $this->DRF[0];
          if ( !empty($this->NOT )) {
            $this->NOT = $this->NOT[0];
          }
          if ( !empty($this->REF  ))  {
              $this->REF = $this->REF[0];
          }
          $this->TipoDocumento = $this->EMI['_01_tp_doc'] ;
        }


        private function ENC () {
          $this->xml->startElement('ENC');
            $this->CrearSiExite('ENC_1',  $this->ENC['_01_tp_doc']                 );
            $this->CrearSiExite('ENC_2',  $this->ENC['_02_nit_emprsa']             );
            $this->CrearSiExite('ENC_3',  $this->ENC['_03_nit_clinte']             );
            $this->CrearSiExite('ENC_4',  $this->ENC['_04_vrsion_equma']           );
            $this->CrearSiExite('ENC_5',  $this->ENC['_05_vrsion_frmto']           );
            $this->CrearSiExite('ENC_6',  $this->ENC['_06_nro_fctra']              );
            $this->CrearSiExite('ENC_7',  $this->ENC['_07_fcha_fctra']             );
            $this->CrearSiExite('ENC_8',  $this->ENC['_08_hra_fctra'] .'-05:00'    );
            $this->CrearSiExite('ENC_9',  $this->ENC['_09_tp_fctra']               );
            $this->CrearSiExite('ENC_10', $this->ENC['_10_mnda']                   );
            $this->CrearSiExite('ENC_15', $this->ENC['_15_nro_lineas']             );
            $this->CrearSiExite('ENC_16', $this->ENC['_16_fcha_vncmnto']           );
            $this->CrearSiExite('ENC_20', $this->ENC['_20_ambnte']                 );
            if (  $this->TipoDocumento === 'INVOIC') {
              $this->CrearSiExite('ENC_21', $this->ENC['_21_tp_oprcion']             );
            }
            if (  $this->TipoDocumento === 'NC') {
              $this->CrearSiExite('ENC_21', '22'            );
            }
            if (  $this->TipoDocumento === 'ND') {
              $this->CrearSiExite('ENC_21', '32'            );
            }
          $this->xml->endElement();
      }

      private function EMI () {
        $this->xml->startElement('EMI');
          $this->CrearSiExite('EMI_1',    $this->EMI['_01_tp_prsna']          );
          $this->CrearSiExite('EMI_2',    $this->EMI['_02_nit_emprsa']        );
          $this->CrearSiExite('EMI_3',    $this->EMI['_03_tp_doc']            );
          $this->CrearSiExite('EMI_4',    $this->EMI['_04_rgmen']             );
          $this->CrearSiExite('EMI_6',    $this->EMI['_06_emprsa']            );
          $this->CrearSiExite('EMI_7',    $this->EMI['_06_emprsa']            );
          $this->CrearSiExite('EMI_7',    $this->EMI['_07_nom_ccial']         );
          $this->CrearSiExite('EMI_10',   $this->EMI['_10_drccion']           );
          $this->CrearSiExite('EMI_11',   $this->EMI['_11_dpto']              );
          $this->CrearSiExite('EMI_13',   $this->EMI['_13_mcipio']            );
          $this->CrearSiExite('EMI_14',   '760001'                            );    // Código postal
          $this->CrearSiExite('EMI_15',   $this->EMI['_15_pais']              );
          $this->CrearSiExite('EMI_19',   $this->EMI['_19_dpto']              );
          $this->CrearSiExite('EMI_21',   $this->EMI['_21_pais']              );
          $this->CrearSiExite('EMI_22',   $this->EMI['_22_dv_emprsa']         );
          $this->CrearSiExite('EMI_23',   $this->EMI['_23_cod_mcipio']        );
          $this->CrearSiExite('EMI_24',   $this->EMI['_06_emprsa']            ); //_07_nom_ccial
          $this->TAC () ;
          $this->DFE () ;
          $this->ICC ();
          $this->CDE ();
          $this->GTE () ;
        $this->xml->endElement();
      }

      private function TAC () {
        if ( empty ( $this->EMI['_tac_01']  )) return ;
          $this->xml->startElement('TAC');
          $this->CrearSiExite('TAC_1',    $this->EMI['_tac_01']        );
          $this->xml->endElement();
      }

      private function DFE () {
        $this->xml->startElement('DFE');
        $this->CrearSiExite('DFE_1',    $this->EMI['_23_cod_mcipio']        );
        $this->CrearSiExite('DFE_2',    $this->EMI['_11_dpto']              );
        $this->CrearSiExite('DFE_3',    $this->EMI['_15_pais']              );
        $this->CrearSiExite('DFE_4',    $this->EMI['cod_postal']            );
        $this->CrearSiExite('DFE_5',    $this->EMI['_21_pais']              );
        $this->CrearSiExite('DFE_6',    $this->EMI['_19_dpto']              );
        $this->CrearSiExite('DFE_7',    $this->EMI['_13_mcipio']            );
        $this->CrearSiExite('DFE_8',    $this->EMI['_10_drccion']           );
        $this->xml->endElement();
      }

      private function ICC () {
        $this->xml->startElement('ICC');
        $this->CrearSiExite('ICC_1',    $this->EMI['num_mtrcla_mcntil']      );
        $this->CrearSiExite('ICC_9',    $this->DRF['_04_prfjo']              );
        $this->xml->endElement();
      }


      private function CDE () {
        $this->xml->startElement('CDE');
          $this->CrearSiExite('CDE_1',    '1'                               );
          $this->CrearSiExite('CDE_2',    'CONTACTO EMISOR'              );
          $this->CrearSiExite('CDE_3',    '4881616'                      );
          $this->CrearSiExite('CDE_4',    'contabilidadt@balquimia.com'         );
        $this->xml->endElement();
      }

      private function GTE () {
        $this->xml->startElement('GTE');
        $this->CrearSiExite('GTE_1',   '01'           );
        $this->CrearSiExite('GTE_2',    'IVA'         );
        $this->xml->endElement();
      }


      private function ADQ () {
        $this->xml->startElement('ADQ');
          $this->CrearSiExite('ADQ_1',     $this->ADQ['_01_tp_prsna']                       );
          $this->CrearSiExite('ADQ_2',     $this->ADQ['_02_nit_emprsa']                     );
          $this->CrearSiExite('ADQ_3',     $this->ADQ['_03_tp_doc']                         );
          $this->CrearSiExite('ADQ_4',     $this->ADQ['_04_rgmen']                          );
          $this->CrearSiExite('ADQ_6',     $this->ADQ['_06_emprsa']                         );
          $this->CrearSiExite('ADQ_7',     $this->ADQ['_07_nom_ccial']                      );
          $this->CrearSiExite('ADQ_8',     $this->ADQ['_08_nom_prsna_ntral']                );
          $this->CrearSiExite('ADQ_10',    utf8_encode( $this->ADQ['_10_drccion'] )         );
          $this->CrearSiExite('ADQ_11',    $this->ADQ['_11_dpto']                           );
          $this->CrearSiExite('ADQ_13',    $this->ADQ['_13_mcipio']                         );
          $this->CrearSiExite('ADQ_14',    $this->ADQ['_14_cod_postal']                     );
          $this->CrearSiExite('ADQ_15',    'CO'                                             );
          $this->CrearSiExite('ADQ_19',    $this->ADQ['_19_nom_dpto']                       );
          $this->CrearSiExite('ADQ_21',    'COLOMBIA'                                       );
          $this->CrearSiExite('ADQ_22',    $this->ADQ['_22_dv_adq']                         );
          $this->CrearSiExite('ADQ_23',    $this->ADQ['_23_cod_mcipio']                     );

          $this->TCR () ;
          $this->ILA () ;
          $this->DFA () ;
          $this->ICR () ;
          $this->CDA () ;
          $this->GTA () ;

        $this->xml->endElement();
      }


      private function TCR () {
       if ( empty(  $this->ADQ['tcr_01'] )) return ;
        $this->xml->startElement('TCR');
          $this->CrearSiExite('TCR_1',   $this->ADQ['tcr_01']                );
        $this->xml->endElement();
      }

      // Información legal del adquiriente
      private function ILA () {
          $this->xml->startElement('ILA');
          $this->CrearSiExite('ILA_1',   $this->ADQ['_06_emprsa']           );
          $this->CrearSiExite('ILA_2',   $this->ADQ['_02_nit_emprsa']       );
          $this->CrearSiExite('ILA_3',   $this->ADQ['_03_tp_doc']           );
          $this->CrearSiExite('ILA_4',   $this->ADQ['_22_dv_adq']           );
          $this->xml->endElement();
      }

      // Información fiscal adquiriente
      private function DFA () {
        $this->xml->startElement('DFA');
          $this->CrearSiExite('DFA_1',   'CO'                                 );
          $this->CrearSiExite('DFA_2',   $this->ADQ['cod_dpto']               );
          $this->CrearSiExite('DFA_3',   $this->ADQ['_14_cod_postal']         );
          $this->CrearSiExite('DFA_4',    $this->ADQ['_23_cod_mcipio']        );
          $this->CrearSiExite('DFA_5',   'COLOMBIA'                           );
          $this->CrearSiExite('DFA_6',   $this->ADQ['_19_nom_dpto']           );
          $this->CrearSiExite('DFA_7',   $this->ADQ['_13_mcipio']             );
          $this->CrearSiExite('DFA_8',   $this->ADQ['_10_drccion']            );
        $this->xml->endElement();
      }

      private function ICR () {
         if  ( $this->ADQ['_01_tp_prsna'] === '1'  && !empty( $this->ADQ['icr_num_mtrcla_mcntil_clnte']) ) {
          $this->xml->startElement('ICR');
            $this->CrearSiExite('ICR_1',   $this->ADQ['icr_num_mtrcla_mcntil_clnte']          );
          $this->xml->endElement();
         }
      }

      private function CDA () {
        $this->xml->startElement('CDA');
          $this->CrearSiExite('CDA_1',  $this->ADQ['cda_01_tp_cntcto']          );
          $this->CrearSiExite('CDA_2',   'NO INFORMADO'                         );
          $this->CrearSiExite('CDA_3',   $this->ADQ['cda_03_tlfno']             );
          $this->CrearSiExite('CDA_4',   $this->ADQ['cda_04_email']             );
        $this->xml->endElement();
        if ( !empty( trim($this->ADQ['cda_04_email_2']  ) )) {
          $this->xml->startElement('CDA');
          $this->CrearSiExite('CDA_1',   2         );
          $this->CrearSiExite('CDA_2',   'NO INFORMADO'           );
          $this->CrearSiExite('CDA_3',   $this->ADQ['cda_03_tlfno_2']             );
          $this->CrearSiExite('CDA_4',   $this->ADQ['cda_04_email_2']             );
          $this->xml->endElement();
        }
        $this->xml->startElement('CDA');
          $this->CrearSiExite('CDA_1',  '5'          );
          $this->CrearSiExite('CDA_2',   'CORREO BALQUIMIA'                         );
          $this->CrearSiExite('CDA_3',   '4881616'                                  );
          $this->CrearSiExite('CDA_4',  'facturaelectronica@balquimia.com'          );
        $this->xml->endElement();
      }


      private function GTA () {
        $this->xml->startElement('GTA');
          $this->CrearSiExite('GTA_1',   '01'           );
          $this->CrearSiExite('GTA_2',    'IVA'         );
        $this->xml->endElement();
      }

      private function TOT () {
        $this->xml->startElement('TOT');
          $this->CrearSiExite('TOT_1',   $this->TOT['_01_sub_total']            );
          $this->CrearSiExite('TOT_2',   $this->TOT['_02_mnda']                 );
          $this->CrearSiExite('TOT_3',   $this->TOT['_03_base_impsto']          );
          $this->CrearSiExite('TOT_4',   $this->TOT['_04_mnda']                 );
          $this->CrearSiExite('TOT_5',   $this->TOT['_05_tot_fctra']            );
          $this->CrearSiExite('TOT_6',   $this->TOT['_06_mnda']                 );
          $this->CrearSiExite('TOT_7',   $this->TOT['_07_tot_fctra']            );
          $this->CrearSiExite('TOT_8',   $this->TOT['_08_mnda']                 );

          if ( $this->TOT['_09_dsctos'] > 0 ){
            $this->CrearSiExite('TOT_9',   $this->TOT['_09_dsctos']           );
            $this->CrearSiExite('TOT_10',   $this->TOT['_10_mnda']            );
          }

          if ( $this->TOT['_11_tot_crgos'] > 0 ){
            $this->CrearSiExite('TOT_11',   $this->TOT['_11_tot_crgos']           );
            $this->CrearSiExite('TOT_12',   $this->TOT['_12_mnda']                );
          }
        $this->xml->endElement();
      }

      private function TIM() {
        $this->xml->startElement('TIM');
          $this->CrearSiExite('TIM_1',   'false'          );
          $this->CrearSiExite('TIM_2',   $this->IMP['imp_04_vr_impsto']           );
          $this->CrearSiExite('TIM_3',   $this->IMP['imp_05_mnda']                );
          $this->IMP ();
        $this->xml->endElement();
      }

      private function IMP ()  {
        $this->xml->startElement('IMP');
          $this->CrearSiExite('IMP_1',   $this->IMP['imp_01_tp_impsto']           );
          $this->CrearSiExite('IMP_2',   $this->IMP['imp_02_base']                );
          $this->CrearSiExite('IMP_3',   $this->IMP['imp_03_mnda']                );
          $this->CrearSiExite('IMP_4',   $this->IMP['imp_04_vr_impsto']           );
          $this->CrearSiExite('IMP_5',   $this->IMP['imp_05_mnda']                );
          $this->CrearSiExite('IMP_6',   $this->IMP['imp_06_pctje']               );
        $this->xml->endElement();
      }


      private function DRF () {
        $this->xml->startElement('DRF');
            $this->CrearSiExite('DRF_1',   $this->DRF['_01_num_rslcion']            );
            $this->CrearSiExite('DRF_2',   $this->DRF['_02_fcha_ini']               );
            $this->CrearSiExite('DRF_3',   $this->DRF['_03_fcha_fin']               );
            $this->CrearSiExite('DRF_4',   $this->DRF['_04_prfjo']                    );
            $this->CrearSiExite('DRF_5',   $this->DRF['_05_num_ini']                  );
            $this->CrearSiExite('DRF_6',   $this->DRF['_06_num_fin']                  );
        $this->xml->endElement();
      }

      private function MEP () {
        $this->xml->startElement('MEP');
          $this->CrearSiExite('MEP_1',   'ZZZ'                                      ); // Otro
          if ( $this->ENC['plazo_fctra'] >  0 ) {
              $this->CrearSiExite('MEP_2',   '2'                                    ); // Credito
              $this->CrearSiExite('MEP_3',   $this->ENC['_16_fcha_vncmnto']         ); //Fecha de vencimiento
            }else{
              $this->CrearSiExite('MEP_2',   '1'                                    ); // Contado
            }
        $this->xml->endElement();
      }

      private function CDN () {

        if ( $this->TipoDocumento === 'INVOIC') return ;

        $this->xml->startElement('CDN');
        $this->CrearSiExite('CDN_1',   '5'                                      );
        $this->CrearSiExite('CDN_2',   'NOTA APLICABLE A DOCUMENTO EMITIDO'     );
        $this->xml->endElement();
      }

      private function NOT () {
        if ( empty( $this->NOT )) return ;
        if ( empty( trim( $this->NOT['_01_notas'])) ) return ;
        $this->xml->startElement('NOT');
            $this->CrearSiExite('NOT_1',   $this->NOT['_01_notas']           );
        $this->xml->endElement();
      }

      private function OCR () {
        if ( empty(  $this->NOT['ord_cpra']  )) return ;
        $this->xml->startElement('ORC');
            $this->CrearSiExite('ORC_1',   $this->NOT['ord_cpra']           );
        $this->xml->endElement();
      }

      private function REF () {
        if ( empty( $this->REF )) return ;
        if ( $this->TipoDocumento ==='INVOIC') {
          $this->xml->startElement('REF');
              $this->CrearSiExite('REF_1',   $this->REF['_01_tp_doc']            );
              $this->CrearSiExite('REF_2',   $this->REF['_02_num_doc']           );
          $this->xml->endElement();
        }
      }

      private function ITE () {
          foreach ( $this->ITE as $Producto) {
            $Subtotal   = $Producto['_21_total_item'] ;
            $Pctaje_Iva = $Producto['pctaje_iva'] ;
            $CodItem    = $Producto['_01_consecutivo'] ;
            $Valor_Iva  = $Producto['valor_iva'] ;
            $this->xml->startElement('ITE');
              $this->CrearSiExite('ITE_1',   $CodItem                      );
              $this->CrearSiExite('ITE_2',   $Producto['_02_tp_reg']                            );
              $this->CrearSiExite('ITE_3',   $Producto['_03_cant']                              );
              $this->CrearSiExite('ITE_4',   $Producto['_04_und_med']                           );
              $this->CrearSiExite('ITE_5',   $Producto['_05_csto_total']                        );
              $this->CrearSiExite('ITE_6',   $Producto['_06_mnda']                              );
              $this->CrearSiExite('ITE_7',   $Producto['_07_vr_unit']                           );
              $this->CrearSiExite('ITE_8',   $Producto['_08_mnda']                              );
              $this->CrearSiExite('ITE_11',  utf8_encode(  $Producto['_11_nom_prdcto'] )        );
              $this->CrearSiExite('ITE_12',   $Producto['_12_nom_prdcto']                       );
              $this->CrearSiExite('ITE_14',   $Producto['_14_und_med']                          );
              $this->CrearSiExite('ITE_19',   $Producto['_19_total_item']                       );
              $this->CrearSiExite('ITE_20',   $Producto['_20_mnda']                             );
              $this->CrearSiExite('ITE_21',   $Producto['_21_total_item']                       );
              $this->CrearSiExite('ITE_22',   $Producto['_22_mnda']                             );
              $this->CrearSiExite('ITE_23',   $Producto['_21_total_item']                       );
              $this->CrearSiExite('ITE_27',   (int)$Producto['_27_cantidad']                    );
              $this->CrearSiExite('ITE_28',   $Producto['_28_unidad']                           );
              $this->IAE ( $CodItem ) ;
              $this->TII ( $Subtotal, $Pctaje_Iva, $Valor_Iva) ;
            $this->xml->endElement();

          }
      }

      private function IAE ( $CodigoProducto ) {
        $this->xml->startElement('IAE');
          $this->CrearSiExite('IAE_1',   $CodigoProducto                               );
          $this->CrearSiExite('IAE_2',   '999'                                         );
          $this->CrearSiExite('IAE_4',   'Estándar de adopción del contribuyente'      );
        $this->xml->endElement();
      }

      private function TII ( $Subtotal, $Pctaje_Iva, $Valor_Iva) {
        $this->xml->startElement('TII');
        $this->CrearSiExite('TII_1',   $Valor_Iva ) ;
          $this->CrearSiExite('TII_2',   'COP' ) ;
          $this->CrearSiExite('TII_3',   'false' ) ;
            $this->xml->startElement('IIM');
              $this->CrearSiExite('IIM_1',   '01' ) ;
              $this->CrearSiExite('IIM_2',   $Valor_Iva ) ;
              $this->CrearSiExite('IIM_3',   'COP' ) ;
              $this->CrearSiExite('IIM_4',   $Subtotal) ;
              $this->CrearSiExite('IIM_5',   'COP' ) ;
              $this->CrearSiExite('IIM_6',   $Pctaje_Iva ) ;
            $this->xml->endElement();
        $this->xml->endElement();
      }


        //========================================================================
        // Funciones utilitarias
        //========================================================================
        private function CrearSiExite ($Elemento, $Valor ) {
          if ( !empty( $Valor ) || trim($Valor) === '0') {
            $this->xml->writeElement( "$Elemento", $Valor );
          }
        }


        private function xmlInicioArchivo(  $TipoDocumento,  $NomDocumentoCreado ) {
          $this->xml = new XMLWriter();
          $this->xml->openMemory();
          $this->xml->setIndent(true);
          $this->xml->setIndentString("\t");
          $this->tipoDocumentoCreado ( $TipoDocumento, $NomDocumentoCreado  );
        }

        private function tipoDocumentoCreado ( $TipoDocumento, $NomDocumentoCreado ) {

          if ( $TipoDocumento === 'INVOIC')  {
                $this->xml->startElement('FACTURA');
                $this->nombreDocumento = FACTURAS_ELECTRONICAS . $NomDocumentoCreado.'.xml';
            }
            if ( $TipoDocumento === 'NC')     {
                $this->xml->startElement('NOTA');
                $this->nombreDocumento  = FACTURAS_ELECTRONICAS.  $NomDocumentoCreado.'.xml';
            }
            if ( $TipoDocumento === 'ND')      {
              $this->xml->startElement('NOTA');
              $this->nombreDocumento =  FACTURAS_ELECTRONICAS . $NomDocumentoCreado.'.xml';
            }
            $this->xml->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
            $this->xml->writeAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema');
        }


        private function xmlFinalArchivo() {
              $this->xml->endElement(); // Final del elemento factura
              $this->xml->endDocument();
              $stringXml = $this->xml->outputMemory(true);
              $this->xml->flush();
              unset(  $this->xml );
              file_put_contents( $this->nombreDocumento  , $stringXml);
        }


        private function uploadFile(){
            //Obtiene el path de su archivo
          $xmlCarvajal = file_get_contents( $this->nombreDocumento );
          $xmlBase64   = base64_encode($xmlCarvajal);
          $cliente     = new SoapClient( FACT_ELEC_URL);
          $params      = array(
            "username"  => FACT_ELEC_USU,
            "password"  => FACT_ELEC_PASS,
            "xmlBase64" => $xmlBase64
           );

           $response = $cliente->__soapCall("FtechAction.uploadInvoiceFile", $params);

         $this->uploadCode       = $response->code;
         $this->uploadError      = $response->error;
         $this->uploadSuccess      = $response->success;
         $this->idTransactionXml = $response->transaccionID ;

         Debug::Mostrar( $response ) ;


        }

        public function statusFile ( ) {
          $cliente          = new SoapClient( FACT_ELEC_URL);
          $Documentos       = $this->Factura->checkDocumentsStatus();

          foreach( $Documentos as $Doc ) {
              $idTransactionXml       = $Doc['transactionId'] ;
              $params                 = array( "username"      => FACT_ELEC_USU,  "password"      => FACT_ELEC_PASS,  "transaccionID" => $idTransactionXml  );
              $response               = $cliente->__soapCall("FtechAction.documentStatusFile", $params);
              $this->idTransactionXml = $idTransactionXml ;
              $this->statusCode       = $response->code;
              $this->statusError      = $this->textoError ( $response->error );
              $this->statusSuccess    = $response->success;
              $this->updateDocumentStatus () ;
          }
        }


        private function updateDocumentStatus () {
          $this->Factura->updateDocumentStatus ( $this->idTransactionXml, $this->statusCode, $this->statusSuccess , $this->statusError );
        }

        public function showPdf(){
          $params      = array(
            "username"      => FACT_ELEC_USU,
            "password"      => FACT_ELEC_PASS,
            "prefijo"       => 'SETT',
            "folio"         => '66'
           );
           $cliente  = new SoapClient( FACT_ELEC_URL);
           $response = $cliente->__soapCall("FtechAction.downloadXMLFile", $params);
           $xml      = $response->resourceData;
           $pdf      = base64_decode( $xml );
           $file     = 'invoice.xml';
           file_put_contents($file, $pdf);
        }

        private function updateUploadFile () {
          $this->Factura->updateUploadFile ( $this->id_fact_elctrnca, $this->idTransactionXml, $this->uploadCode, $this->uploadError, $this->uploadSuccess ) ;
        }

        private function textoError ( $error ) {
          if ( strlen(trim( $error)) <=31 ) {
              return $error;
          }
          $error      = str_replace("'","", $error );
          $error      = $string = preg_replace("/[\r\n|\n|\r]+/", " ", $error );
          $error      = substr ( $error ,200,250 );
          return $error ;
        }
     // ====================== Final Documento ====================================
    }



?>

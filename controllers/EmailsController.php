<?php

  class EmailsController extends Controller
  {
  	  private $Email ;

      public function __construct()
      {
          parent::__construct();
          $this->Terceros = $this->Load_Model('Terceros');
          $this->Mensajes = $this->Load_Model('Emails');
          $this->Email    = $this->Load_External_Library('class.phpmailer');
          $this->Email    = new PHPMailer();
      }

      public function Index() { }




      public function FacturaElectronicaError ( $TextoErrores, $IdFacturaElectronica ) {
          $email             = 'jhonjamesmg@hotmail.com';
          $nombre_usuario    = 'Jhon James';
          $this->Configurar_Cuenta(  "Error - Factura no enviada ". $IdFacturaElectronica );
          $this->Email->Body = $TextoErrores  ;
          $this->Email->AddAddress( $email  );
          $Respuesta         = $this->Enviar_Correo();
      }















    public function Configurar_Cuenta( $asunto ) {

       $this->Email->IsSMTP();
       $this->Email->SMTPDebug     =0;
       $this->Email->SMTPAuth      = true;
       $this->Email->IsHTML        = true;                      // enable SMTP authentication
       $this->Email->ContentType   = "text/html";
       $this->Email->CharSet       = "utf-8";
       $this->Email->SMTPSecure    = 'ssl';                     // sets the prefix to the servier
       $this->Email->Host          = 'smtp.gmail.com';         // sets GMAIL as the SMTP server
       $this->Email->Port          = 465;
       $this->Email->SMTPKeepAlive = true;
       $this->Email->Mailer        = "smtp";                   // set the SMTP port
       $this->Email->Username      = CORREO_CONTACTOS;         // GMAIL username
       $this->Email->Password      = PASS_CORREO_CONTACTOS;    // GMAIL password
       $this->Email->From          = 'contactos@balquimia.com';
       $this->Email->FromName      = 'TRON Entre amigos alcanzamos';
       $this->Email->Subject       = $asunto;
       $this->Email->AltBody       = ""; //Text Body
       $this->Email->WordWrap      = 50; // set word wrap                                // send as HTML

    }


    public function Enviar_Correo(){
        if ( $this->Email->Send()){
            $this->Email->ClearBCCs();
            $this->Email->clearAddresses();
            return "correo_OK";
        }else {
          $this->Email->ClearBCCs();
          $this->Email->clearAddresses();
          echo "Error: " . $this->Email->ErrorInfo;
         return "correo_No_OK";
        }

     }

   private function Unir_Partes_Correo (   $Body ){
       $Logo_Empresa       = BASE_IMG_EMPRESA .'logo.png';
       $Header             = file_get_contents(APPLICATION_SECTIONS . 'emails/header.php','r');
       $Footer             = file_get_contents(APPLICATION_SECTIONS . 'emails/footer.php','r');
       $Texto_Final_Correo = $Header.$Body.$Footer;

       return $Texto_Final_Correo ;
    }


/* PAGINAS QUE HABILITAN EL EVÍO DE CORREOS EN CUENTAS
    https://www.google.com/settings/u/1/security/lesssecureapps
    https://accounts.google.com/b/0/DisplayUnlockCaptcha
    https://security.google.com/settings/security/activity?hl=en&pli=1

    ndrryejncsgzycvs

*/
 }
?>




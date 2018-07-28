<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class IndexController extends AbstractActionController
{

    public function indexAction()
    {

    $request = $this->getRequest();

     if (! $request->isPost()) {
        return new ViewModel();
     }

     $values= $request->getPost()->getArrayCopy();

          $Mailer = new PHPMailer();

            	//Define que será usado SMTP
          $Mailer->IsSMTP();

          	//Enviar e-mail em HTML
          $Mailer->isHTML(true);

          	//Aceitar carasteres especiais
          $Mailer->Charset = 'UTF-8';

          	//Configurações
          $Mailer->SMTPAuth = true;
          $Mailer->SMTPSecure = 'ssl';

          	//nome do servidor
        	$Mailer->Host = 'host';
          	//Porta de saida de e-mail
          $Mailer->Port = 465;

          	//Dados do e-mail de saida - autenticação
          $Mailer->Username = $values['email'];
        	$Mailer->Password = 'senha';

          	//E-mail remetente (deve ser o mesmo de quem fez a autenticação)
          $Mailer->From = $values['email'];

          	//Nome do Remetente
          $Mailer->FromName = $values['name'];

          	//Assunto da mensagem
          $Mailer->Subject = 'Contato Pelo Site';

          	//Corpo da Mensagem
          $Mailer->Body = $values['comment'];

          	//Corpo da mensagem em texto
          $Mailer->AltBody = $values['comment'];

          	//Destinatario
          $Mailer->AddAddress('web@voxbrazil.com.br');

          if($Mailer->Send()){
            	echo "E-mail enviado com sucesso";
          	}else{
            	echo "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
        	}
    }
}

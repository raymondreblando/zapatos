<?php

namespace App\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Utils\Utilities;

class Email extends PHPMailer
{
  public function __construct()
  {
    parent::__construct(true);
  }

  public function sendEmail(array $params): bool
  {
    try {
      
      $this->SMTPDebug = 0;                   
      $this->isSMTP();                                       
      $this->Host       = $_ENV['EMAIL_HOST'];                   
      $this->SMTPAuth   = true;                                 
      $this->Username   = $_ENV['EMAIL_USERNAME']; 
      $this->Password   = $_ENV['EMAIL_SECRET']; 
      $this->SMTPSecure = $_ENV['EMAIL_SMTPS'];           
      $this->Port       = $_ENV['EMAIL_PORT']; 

      $this->setFrom($_ENV['EMAIL_USERNAME'], $_ENV['BRAND_NAME']);
      $this->addAddress($params['email'], $params['fullname']); 
  
      if(isset($params['attachment'])){
        foreach($params['attachment'] as $attachment){
          $this->addAttachment($attachment['path'], $attachment['name']);
        }
      }
  
      $this->isHTML(true);                                 
      $this->Subject = $params['subject'];
      $this->Body    = $params['body'];
      $this->AltBody = $params['altbody'];
  
      $this->send();
      
      return true;
    } catch (Exception $e) {
      return false;
    }
  }
}
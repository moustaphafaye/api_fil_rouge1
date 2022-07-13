<?php

namespace App\Services;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class EnvoieEmail {

    public function __construct(MailerInterface $mailer,Environment $twig)
    {
       $this->mailer=$mailer; 
       $this->twig=$twig; 
    }

    public function emailenvoie($utilisateur){

       
        
        $envoi=(new Email())
            ->from("moustaphafaye470@gmail.com")
            ->to($utilisateur->getLogin())
            ->subject('creation compte')
            ->html($this->twig->render("mail/envoie.html.twig",["utilisateur"=>$utilisateur]));

            $this->mailer->send($envoi);

            

     
        
            

        


    }















}
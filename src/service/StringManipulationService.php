<?php

namespace App\service;

use Psr\Log\LoggerInterface;

class StringManipulationService {

    private $logger;

    public function  __construct( LoggerInterface $logger){
        $this->logger = $logger;
    }



    public function cleanString(string $text):string{

        $this->logger->info('Recebemos o valor de '.$text);

        $text = str_replace('[', '',$text);
        $text = str_replace(']', '',$text);

        $this->logger->info('devolvemos o valor '.$text);
        return $text;
    }





    public function  removeHifem(string $string ): string {

        $string = str_replace('-',  ' ',$string);
        return $string;

    }
}
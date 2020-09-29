<?php

namespace Stilldistribuidora\Repository\Index;

use DateTime;
use DateTimeZone;


class Calendar{

    private $timeZoneDefault='America/Sao_Paulo';
    function __construct()
    {
        date_default_timezone_set('America/Sao_Paulo');
    }


    private $monthActive="";
    private $dayDefaut='01';
    private $dayAlias=[
        "Monday"=>"Segunda-feira",
        "Tuesday"=>"Terça-feira",
        "Wednesday"=>"Quarta-feira",
        "Thursday"=>"Quinta-feira",
        "Friday"=>"Sexta-feira",
        "Saturday"=>"Sábado",
        "Sunday"=>"Domingo",
        
    ];

    private $months=[
            '',
            'Janeiro',
            'Fevereiro',
            'Março', 
            'Abril', 
            'Maio', 
            'Junho', 
            'Julho', 
            'Agosto', 
            'Setembro', 
            'Outubro', 
            'Novembro', 
            'Dezembro'];
    
    public function limitOfThemonthToDays($moth,$year){
        $days=[];
       
       
        $this->monthActive=$this->months[intVal($moth)];
        
        $ultimo_dia = date("t", mktime(0,0,0,$moth,$this->dayDefaut,$year));  
        for($day=1;$day <= $ultimo_dia;$day++){
            $data=sprintf("%s-%s-%s",$year,$moth,$day);
            $dayInfo=[
                "day"=>$day,
                "name"=>$this->dayAlias[$this->fetchNameOfTheDay($data)]
            ];
            array_push($days,$dayInfo);
        }
        return $days;

    }
    
    private function fetchNameOfTheDay($data){
         $data =new DateTime($data,new DateTimeZone($this->timeZoneDefault));
         return $data->format('l');
    }

    public function getMonthActive(){
        return $this->monthActive;
    }


}


?>
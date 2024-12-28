<?php



namespace App\Service;

use DateTime;
use DateTimeImmutable;

class SpecificFunctionDate {

    public function __construct(?String $var = null) {
       // $this->var = $var;
    }



    //Ce service permet de retourner la différence entre la date de création de l'astuce et aujourd'hui
    //il sera mis dans un variable global dans twig.yml : date_ago: '@App\Service\SpecificFunctionDate'
    //et dans le twig il sera utilisé comme ceci : date_ago.timeAgo(trick.createdAt()
    public function timeAgo($madate){
    $datetime1=new DateTime("now");
        $diff=date_diff($datetime1, $madate);
        $timemsg='';
        if($diff->y > 0){
            $timemsg = $diff->y .' année'. ($diff->y > 1?"s":'');
    
        }
        else if($diff->m > 0){
         $timemsg = $diff->m . ' mois'. ($diff->m > 1?"s":'');
        }
        else if($diff->d > 0){
         $timemsg = $diff->d .' jour'. ($diff->d > 1?"s":'');
        }
        else if($diff->h > 0){
         $timemsg = $diff->h .' heure'.($diff->h > 1 ? "s":'');
        }
        else if($diff->i > 0){
         $timemsg = $diff->i .' minute'. ($diff->i > 1?"s":'');
        }
        else if($diff->s > 0){
         $timemsg = $diff->s .' seconde'. ($diff->s > 1?"s":'');
        }
    
    $timemsg = 'Il y\'a '.$timemsg;
    return $timemsg;
    }





}
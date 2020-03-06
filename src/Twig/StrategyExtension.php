<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use App\Entity\Strategy;

class StrategyExtension extends AbstractExtension{
    
    public function getFilters(){
        return [
            new TwigFilter('text', [$this, 'getText']),
        ];
    }
    
    public function getText(Strategy $strategy, $breakline = true){
        
        $text = "Ma stratégie est de louer en ";
        $text .= "<b>".implode(" et/ou en ", array_map(function($exploitation){ return $exploitation->getText(); }, $strategy->getExploitations()->toArray()))."</b>."; $breakline ? $text .= "<br>" : $text .= " ";
        $text .= "Le type de bien sera <b>".implode(" ou ", array_map(function($type){ return $type->getText(); }, $strategy->getTypes()->toArray()))."</b>."; $breakline ? $text .= "<br>" : $text .= " ";
        $text .= "Pour les travaux, <b>".$strategy->getTravaux()->getText()."</b> sera prévu(e)."; $breakline ? $text .= "<br>" : $text .= " ";
        $text .= "Le montant total de mon projet sera de <b>".$strategy->getPrice()."€</b>."; $breakline ? $text .= "<br>" : $text .= " ";
        $text .= "Avec cet investissement, je souhaite dégager <b>".$strategy->getCashflow()."€</b> de cashflow mensuel.";
        
        return $text;
    }
    
}

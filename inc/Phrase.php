<?php

class Phrase
{
    public $currentPhrase;
    public $selected = array();
    public $phrases = [
        'Julio is the best',
        'Banana Sandwich',
        'Cheese and crackers',
        'Dance with me',
        'Boombox'
        ];

    public function __construct($currentPhrase = "", $selected = [])
    {
        if (!empty($currentPhrase)){
            $this->currentPhrase = $currentPhrase;
        } else {
            $this->currentPhrase = $this->phrases[rand(0,count($this->phrases)-1)];
        }

        if (!empty($selected)){
            $this->selected = $selected;
        }
    }

    public function addPhraseToDisplay()
    {
        $letters = str_split(strtolower($this->currentPhrase));
        $html = '<div id="phrase" class="section"><ul>';
        foreach($letters as $letter){

            if(isset($_SESSION['selected']) && in_array($letter, $_SESSION['selected'])){
                $html .='<li class="show letter' . $letter . '">';
                $html .= $letter;
                $html .= '</li>';
            } elseif ($letter === " "){
                $html .= '<li class="space"> </li>';
            } else {
                $html .= '<li class=" hide letter"' . $letter . '">';
                $html .= $letter;
                $html .= '</li>';
            }
        }
        $html .= "</ul></div>";
        return $html;
    }

    public function getLetterArray()
    {
        return array_unique(str_split(str_replace(
            ' ', 
            '', 
            strtolower($this->currentPhrase)
        )));
    }

    public function checkLetter($letter)
    {
        $phrase = $this->getLetterArray();
        if (in_array($letter, $phrase)){
            return true;
        } else {
            return false;
        }
    }

    public function numberLost()
    {
        $selected = $_SESSION['selected'];
        $phrase = $this->getLetterArray();
        return count(array_diff($selected, $phrase));
    }
}
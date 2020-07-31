<?php

class Game 
{
    public $phrase;
    public $lives = 5;

    public function __construct($phrase)
    {
        $this->phrase = $phrase;
    }

    public function constructKeyrow($row, $gamePhrase){
        $html = '';
        $html .= '<div class="keyrow">';
        foreach($row as $letter){
            $html .= '<button class="key ';
            if(isset($_SESSION['selected'])){
                if(in_array($letter, $_SESSION['selected'])){
                    if($gamePhrase->checkLetter($letter)){
                        $html .= 'right';
                    } else {
                        $html .= 'wrong';
                    }
                }
            }
            $html .= '" name="key" value = "';
            $html .= $letter;
            $html .= '">';
            $html .= $letter;
            $html .= '</button>';
        }
        $html.= '</div>';
        return $html;
    }

    public function displayKeyboard($gamePhrase)
    {
        $topRow = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p'];
        $middleRow = ['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l'];
        $bottomRow = ['z', 'x', 'c', 'v', 'b', 'n', 'm'];
        $html = '<form action="play.php" method="post">';
        $html .= '<div id="qwerty" class="section">';
        $html .= $this->constructKeyrow($topRow, $gamePhrase);
        $html .= $this->constructKeyrow($middleRow, $gamePhrase);
        $html .= $this->constructKeyrow($bottomRow, $gamePhrase);
        $html.= '</div></form>';
        return $html;
    }

    public function displayScore($phrase)
    {
        $html = '<div id="scoreboard" class="section"><ol>';
        for ($i = 1; $i <= $this->lives; $i++){
            if($i <= ($this->lives - $phrase->numberLost())){
                $html .= '<li class="tries"><img src="images/liveHeart.png" height="35px" widght="30px"></li>';
            } else {
                $html .= '<li class="tries"><img src="images/lostHeart.png" height="35px" widght="30px"></li>';
            }
        }
        $html .= '</ol></div>';
        return $html;
    }

    public function checkForLose($phrase)
    {
        if (($this->lives - $phrase->numberLost()) <= 0){
            return true;
        } 
        return false;
    }

    public function checkForWin($gamePhrase)
    {
        $selected = $_SESSION['selected'];
        $phrase = $gamePhrase->getLetterArray();
        $matched = count(array_intersect($selected, $phrase));
        if ($matched >= count($phrase)){
            return true;
        }
        return false;
    }

    public function gameOver($phrase)
    {
        if ($this->checkForLose($phrase)){
            $html = '<h1 id="game-over-message overlay">The phrase was: "';
            $html .= $phrase->currentPhrase;
            $html .= '." Better luck next time!</h1>';
            return $html;
        } elseif ($this->checkForWin($phrase)){
            $html = '<h1 id="game-over-message">Congratulations on guessing: "';
            $html .= $phrase->currentPhrase;
            $html .= '!"</h1>';
            return $html;
        }
        return false;
    }
}
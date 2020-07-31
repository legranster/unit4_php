<?php
include "inc/Game.php";
include "inc/Phrase.php";
session_start();
if(isset($_POST['key'])){
    $_SESSION['selected'][] = $_POST['key'];
    $gamePhrase = new Phrase($_SESSION['gamePhrase'], $_SESSION['selected']);
    $game = new Game($gamePhrase);
} elseif(isset($_POST['start'])){
    session_unset();
    $gamePhrase = new Phrase();
    $_SESSION['selected'] = array();
    $_SESSION['gamePhrase'] = $gamePhrase->currentPhrase;
    $game = new Game($gamePhrase);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Phrase Hunter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>

<body>
<div class="main-container 
<?php 
    if($game->checkForLose($gamePhrase)){
        echo 'lose" id="overlay"';
    } elseif($game->checkForWin($gamePhrase)){
        echo 'win" id="overlay"';
    }
?>">
    <div id="banner" class="section">
        <h2 class="header">Phrase Hunter</h2>
        <?php
            if ($game->gameOver($gamePhrase)){
                echo $game->gameOver($gamePhrase);
                echo '<form action="play.php" method = "post">';
                echo '<input id="btn__reset" type="submit" name = "start" value="start" />';
                echo '</form>';
            } else {
                echo $gamePhrase->addPhraseToDisplay();
                echo $game->displayKeyboard($gamePhrase);
                echo $game->displayScore($gamePhrase);
            }
            
        ?>
    </div>
</div>
</body>
</html>

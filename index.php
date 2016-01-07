<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html: charset=UTF-8">
        <title>Lab 01</title>
    </head>
    <body>
        <h1>You are player 'o'</h1>
        <?php
        $position;
        if(isset($_GET['board'])){
            $position = $_GET['board'];
        }
        $game = new Game($position);
        $game->display();
        if ($game->winner('x')) echo "You win";
        else if ($game->winner('o')) echo "I win";
        else echo "No winner yet";
        ?>
    </body>
</html>

<?php

class Game {
    
    var $position;
    
    function __construct($squares){
        $this->position = \str_split($squares);
    }
    function display() {
        echo '<table cols=”3” style=”font­size:large; font­weight:bold”>';
        echo '<tr>'; // open the first row
        for ($pos=0; $pos<9;$pos++) {
        echo $this->showCell($pos);
        if ($pos %3 == 2) echo '</tr><tr>'; // start a new row for the next square
        }
        echo '</tr>'; // close the last row
        echo '</table>';
    } 

    function showCell($pos){
          $token = $this->position[$pos];
            // deal with the easy case
            if ($token <> '­') return '<td>'.$token.'</td>';
            // now the hard case 
            $newposition = $this->position; // copy the original
            $newposition[$pos] = 'o'; // this would be their move
            $move = implode($newposition); // make a string from the board array
            $link = '/?board='.$move; // this is what we want the link to be
            // so return a cell containing an anchor and showing a hyphen
            return '<td><a href=”'.$link.'”>­</a></td>';
    }    
    function pick_move(){
        
    
    }
      
    function winner($token){
    $won = false;
    //checking rows
    for($row=0; $row < 3;$row++){
        //checking for 0, 1, 2 OR 3, 4, 5 OR 6, 7, 8
        if($this->position[3 * $row] == $token &&
           $this->position[(3 * $row) + 1] == $token &&
           $this->position[(3 * $row) + 2] == $token){
           $won = true;
        }
    }
    //checking cols
    for($col=0; $col < 3;$col++){
        //checking for 0, 3, 6 OR 1, 4, 7 OR 2, 5, 8
        if($this->position[$col] == $token &&
           $this->position[$col + 3] == $token &&
           $this->position[$col + 6] == $token){
           $won = true;
        }
    }
    //checking diagnols
    if(($this->position[0] == $token) &&
       ($this->position[4] == $token) &&
       ($this->position[8] == $token)){
        
        $won = true;
    }
    if(($this->position[6] == $token) &&
       ($this->position[4] == $token) &&
       ($this->position[2] == $token)){
        
        $won = true;
    }
     
    return $won;
}
}

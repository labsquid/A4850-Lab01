<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html: charset=UTF-8">
        <title>Lab 01</title>
    </head>
    <body>
        <?php
        if(ISSET($_GET['player'])){
            $player = $_GET['player'];
        }
        else $player = 'o';
        
        echo "<h1>You are player " . $player . "</h1>";
        
        if(isset($_GET['board'])){
            $position = $_GET['board'];
        }
        else $position = "---------";
        
        $game = new Game($position);
        $game->display();
        if ($game->winner('x')) echo "X wins";
        else if ($game->winner('o')) echo "O wins";
        else {
            echo "No winner yet. ";
            echo $game->pick_move($player);
        }

        ?>
        <h1><a href="?board=---------&player=o">Start a new game!</a></h1>
    </body>
</html>


<?php
//Game class, handles all the game functions
class Game {
    
    var $position;
    //Constructor requires the squares of the game in the format of a string
    //being either dashes or x/o
    function __construct($squares){
        $this->position = \str_split($squares);
    }
    //Shows the game board via echoing a table structure
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
    //returns a single cell of the table, with either a letter or an <a> with
    //an appropriate link for game logic
    function showCell($pos){ 
            if(ISSET($_GET['player'])){
                $player = $_GET['player'];
            }
            else $player = 'o';
            
            $token = $this->position[$pos];
            // deal with the easy case
            if ($token != "-") return '<td>'.$token.'</td>';
            // now the hard case 
            $newposition = $this->position; // copy the original
            $newposition[$pos] = $player; // this would be their move
            $move = implode($newposition); // make a string from the board array
            //
            //If/else that makes the <a> link to either x or o making a move
            if($player === 'x')  $link = $_SERVER["PHP_SELF"] . '?board='.$move.'&player=o';
            else $link = $_SERVER["PHP_SELF"] . '?board='.$move.'&player=x';
            // so return a cell containing an anchor and showing a hyphen
            return "<td><a href=" .$link . ">&ndash;</a></td>";
    }
    
    //takes current player as arg and suggests a winning move
    function pick_move($player){
    //setting opposite character for the person not playing
    if($player == 'x'){
        $oppositePlayer = 'o';
    }
    else{
        $oppositePlayer = 'x';
    }
    //loop that checks if there are any horizontal winning moves
    $suggestedRow = 0;
    for($row=0; $row < 3;$row++){
        $count = 0;
        //Logic that requres 2 of 3 boxes to be the players letter, with any 
        //opposing characters in the row ruling that row out
        if($this->position[3 * $row] == $player) $count++;
        else if($this->position[3 * $row] == $oppositePlayer) $count--;
        if($this->position[(3 * $row) + 1] == $player) $count++;
        else if($this->position[(3 * $row) + 1] == $oppositePlayer) $count--;
        if($this->position[(3 * $row) + 2] == $player) $count++;
        else if($this->position[(3 * $row) + 2] == $oppositePlayer) $count--;
        //Only situation where count is 2 is where the player can make a winning move
        //Therefore, suggests it
        if ($count == 2){
            $suggestedRow = $row + 1;
        }
    }
    //loop that checks if there are any vertical winning moves
    $suggestedCol = 0;
    for($col=0; $col < 3;$col++){
        $count = 0;
        //Logic that requres 2 of 3 boxes to be the players letter, with any 
        //opposing characters in the column ruling that column out
        if($this->position[$col] == $player) $count++;
        else if($this->position[$col] == $oppositePlayer) $count --;
        if($this->position[$col + 3] == $player) $count++;
        else if($this->position[$col + 3] == $oppositePlayer) $count --;
        if($this->position[$col + 6] == $player) $count++;
        else if($this->position[$col + 6] == $oppositePlayer) $count --;
        //Only situation where count is 2 is where the player can make a winning move
        if($count == 2){
            $suggestedCol = $col + 1;
        }
    }
    //if either loop returns a non-zero value, suggests that row/col or nothing
    if($suggestedRow > 0){
        return 'I suggest row ' . $suggestedRow;
    }
    else if($suggestedCol > 0){
        return 'I suggest column ' . $suggestedCol;
    }
    else{
        return "Insufficient data for reccomendation. Go anywhere.";
    }
    
}
    //Function for checking if the provided token has a won
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

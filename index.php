<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html: charset=UTF-8">
        <title>Lab 01</title>
    </head>
    <body>
        <?php
        $position;
        if(isset($_GET['board'])){
            $position = $_GET['board'];
        }
        $squares = \str_split($position);
        if (winner('x', $squares)) echo "You win";
        else if (winner('o', $squares)) echo "I win";
        else echo "No winner yet";
        ?>
    </body>
</html>

<?php


function winner($token, $position){
    $won = false;
    //checking rows
    for($row=0; $row < 3;$row++){
        //checking for 0, 1, 2 OR 3, 4, 5 OR 6, 7, 8
        if($position[3 * $row] == $token &&
           $position[(3 * $row) + 1] == $token &&
           $position[(3 * $row) + 2] == $token){
           $won = true;
        }
    }
    //checking cols
    for($col=0; $col < 3;$col++){
        //checking for 0, 3, 6 OR 1, 4, 7 OR 2, 5, 8
        if($position[$col] == $token &&
           $position[$col + 3] == $token &&
           $position[$col + 6] == $token){
           $won = true;
        }
    }
    //checking diagnols
    if(($position[0] == $token) &&
       ($position[4] == $token) &&
       ($position[8] == $token)){
        
        $won = true;
    }
    if(($position[6] == $token) &&
       ($position[4] == $token) &&
       ($position[2] == $token)){
        
        $won = true;
    }
     
    return $won;
}
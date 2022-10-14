<?php
function passwordGenerator2($i){
  $uppercase = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'W', 'Y', 'Z');

$lowercase = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'w', 'y', 'z');

$number = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);

$special = array('!', '#', '%', '&');

$password = NULL;


    for ($i = 0; $i < $length; $i++) {

     $password .= $uppercase[rand(0, count($uppercase) - 1)];

      $password .= $lowercase[rand(0, count($lowercase) - 1)];

      $password .= $number[rand(0, count($number) - 1)];
      // $password .= $number[rand(0, count($chars) - 1)];

     // $password .= $chars[rand(0,count($special)-1)];

    }

    return $password;
}

    function passwordGenerator1($len) {

        //enforce min length 8
        if($len < 8)
            $len = 8;

        //define character libraries - remove ambiguous characters like iIl|1 0oO
        $sets = array();
        $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        $sets[] = '0123456789';
        $sets[]  = '~!@#$%^&*,./?';

        $password = '';

        //append a character from each set - gets first 4 characters
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }

        //use all characters to fill up to $len
        while(strlen($password) < $len) {
            //get a random set
            $randomSet = $sets[array_rand($sets)];

            //add a random char from the random set
            $password .= $randomSet[array_rand(str_split($randomSet))];
        }

        //shuffle the password string before returning!
        return str_shuffle($password);
    }

 ?>

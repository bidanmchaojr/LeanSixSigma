<?php
    session_start();

    echo session_id()."<br><br>";




    //Create a cookie named Keebler w/a value of Fudge_Stripe
    $name = 'keebler';
    $value = 'FS';
    setcookie($name, $value, time() + (86400 * 30), '/');

    // 86400 = 1 day, so this is set to expire in 30 days.
    // The “/” means cookie is available to the entire web application.
    //    Otherwise, specify a directory. 

    setcookie('chipahoy', 'tastycookie', time() + (86400 * 30), '/');

    if(!isset($_COOKIE['keebler'])) 
    {
        echo "Cookie named Keebler is not set!<br><br>";
    }
    else
    {
        echo "Cookie Keebler' is set!<br><br>";
        echo "Value is: ".unset($_COOKIE['keebler'])."<br><br>";
    }


    setcookie('PHPSESSID', '', time()-3600, '/');


?>

<?php 
    include 'User.php';

    $user = new User();

    $user->populate(1);

    echo $user->username."<br>"; 
    echo $user->createdate."<br>"; 

    echo "<br><br>User Validated: ".User::validate_user("mcdonough", "pass123");
?>

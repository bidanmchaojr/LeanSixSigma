<?php
    session_start();
    require_once('User.php');
    $username="";
    $password="";
    $error = 0; 

    if(isset($_POST['submit'])){
        if(isset($_REQUEST['username']) && !empty($_REQUEST['username'])){
            $username = $_REQUEST['username'];
        }else{
            $error = 1; 
        }

        if(isset($_REQUEST['password']) && !empty($_REQUEST['password'])){
            $password = $_REQUEST['password'];
        }else{
            $error = 1; 
        }

        if($error == 0){

            $tId = User::validate_user($username, $password);
            if($tId != 0){
                $_SESSION['userid'] = $tId;
                header("Location: profile.php");
            }else{
                $error = 2;
            }
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Message Board</title>
</head>
<body>
    <br><br>
    <div class="flex-container">    
        <div class="flex-item">
            <div style="width:100%;text-align:center;">
                <h2>To-Do App</h2><br>
                <h5>System Login</h5><br>
            </div>
            <?php
                if($error == 1){
                    echo " <font color=red>- Username or Password Missing!</font><br><br>";
                }else if($error == 2){
                    echo " <font color=red>- Invalid Credentials!</font><br><br>";
                }
            ?>
            <form action="index.php" method="post">
                <table border="0">
                    <tr>
                        <td>Username</td>
                        <td><input type="text" name="username" value="mcdonough"></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type="text" name="password" value="pass123"></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="submit" value="Submit"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><br>Click <a href="profile.php?action=create">here</a> to create an account.</td>
                    </tr>
                </table>
            </form> 
        </div>   
    </div> 
</body>
</html>
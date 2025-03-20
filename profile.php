<?php
    session_start();
    require_once('User.php');
    require_once('Task.php');

    $user = new User(); 

    if(!isset($_SESSION['userid'])){
        header("Location: index.php");
    }else{
        $user->populate($_SESSION['userid']); 
    }

    if($_SERVER['REQUEST_METHOD'] == "GET"){

        if(!empty($_GET['action']) && $_GET['action'] == "logout"){
            // Clear ALL global session data.
            $_SESSION = array();
            // Delete session cookie
            setcookie('PHPSESSID', '', time()-3600, '/');
            // Destroy ALL data associated w/current session.
            session_destroy();
            // Redirect to login page.
            header("Location: index.php");
        }else if(!empty($_GET['action']) && $_GET['action'] == "update"){
            
            
        }else if(!empty($_GET['action']) && $_GET['action'] == "delete"){
            if(!empty($_GET['taskid'])){
                Task::delete($_GET['taskid']); 
            }
        }
  
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="banner">
        <div class="banner-item1"><a href="profile.php" border="0"><img src="images/logo.jpg" height="100px"></a></div>
        <div class="banner-item2">
            <span class="banner-title">To-Do List Application</span><br>
            <span class="banner-text">Welcome, <?=$user->firstname." ".$user->lastname?></span><br><br>
            <span class="banner-text2">menu ::</span>&nbsp;&nbsp; <a href="edit_profile.php" class="banner-link">edit profile</a> <span class="banner-text2">|</span> <a href="profile.php?action=logout" class="banner-link2">logout</a>
        </div>
    </div>
    <div style="background-color: rgb(113, 127, 164);width:100%;height:5px;"></div>
    <br>
    <div class="task-container">
        <div class="task-item1"><span class="newtask-text">Task List</span></div>
        <div class="task-item2">&nbsp;&nbsp;<a href="am_task.php" class="newtask-link">Add New Task</a></div></div><br>
    <?php
        $task_array = Task::get_user_tasks($user->id); 
        
        foreach($task_array as $task){
        ?>
        <div class="task-container">
            <div class="task-item1"><img src="images/logo.jpg" width="60px"></div>
            <div class="task-item2">
                <span class="newtask-text2">
                    <?=$task->name?>  [ <a href="am_task.php?action=modify&id=<?=$task->id?>">update</a> | <a href="profile.php?action=delete&taskid=<?=$task->id?>">delete</a> ]<br>
                    Submitted On: <?=$task->timestamp?><br>
                    Description:<br>
                    <?=$task->description?>
                </span>
            </div>
        </div><br>
        <?php
        }
    ?>

</body>
</html>
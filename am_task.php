<?php
    session_start();
    require_once('User.php');
    require_once('Task.php');
    require_once('Category.php');

    $task = new Task(); 
    $category = new Category(); 
    $user = new User(); 

    // a for add, m for modify
    $mode = "a";

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
        }else if(!empty($_GET['action']) && $_GET['action'] == "modify"){
            
            if(!empty($_GET['id'])){
                $task->populate($_GET['id']); 
            }
            $mode = "m";

        }else{
            $task->id = 0; 
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(!empty($_POST['act']) && $_POST['act'] == "add"){
            // Add New Task
            $task->name = $_POST['name'];
            $task->description = $_POST['description'];
            $task->priority = $_POST['priority'];
            $task->category_id = $_POST['category_id'];
            $task->user_id = $_SESSION['userid'];
            $task->insert(); 
            
        }else{
            // Update Task
            $task->populate($_POST['id']);
            $task->name = $_POST['name'];
            $task->description = $_POST['description'];
            $task->priority = $_POST['priority'];
            $task->category_id = $_POST['category_id'];
            $task->update(); 
        }
        $mode = "m";
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
    <div class="am-form-container">
        <form action="am_task.php" method="post">  
            <?php
                if($mode == "m"){
                    ?><input type="hidden" name="id" value="<?=$task->id?>">
                    <input type="hidden" name="act" value="update"><?php
                }else{
                    ?><input type="hidden" name="id" value="0">
                    <input type="hidden" name="act" value="add"><?php
                }
            ?>
            
            <table border="0">
                <tr>
                    <td colspan="2">
                    <?php
                        if($mode == "m"){
                            ?><h2>Update Task</h2><br><?php
                        }else{
                            ?><h2>Add Task</h2><br><?php
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Click <a href="profile.php">HERE</a> to go back to profile page. <br><br></td>
                </tr>
                <tr>
                    <td align="right">Name:</td>
                    <td align="left"><input type="text" name="name" value="<?=$task->name?>"></td>
                </tr>
                <tr>
                    <td align="right">Description:</td>
                    <td align="left"><input type="text" name="description" value="<?=$task->description?>"></td>
                </tr>
                <tr>
                    <td align="right">Category:</td>
                    <td align="left">
                        <select name="category_id">
                        <?php
                            $cats = Category::get_categories();
                            foreach($cats as $cat){
                                if($cat->id == $task->category_id){
                                    ?><option value="<?=$cat->id?>" selected><?=$cat->category?></option><?php
                                }else{
                                    ?><option value="<?=$cat->id?>"><?=$cat->category?></option><?php
                                }
                            }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">Priority:</td>
                    <td align="left"><input type="number" name="priority" min="1" max="10" step="1" value="<?=$task->priority?>"></td>
                </tr>
                <tr>
                    <td align="right">TimeStamp:</td>
                    <td align="left"><?=date("Y/m/d h:i:sa")?></td>
                </tr>
                <tr>
                    <?php
                        if($mode == "m"){
                            ?>
                                <td align="right">&nbsp;</td>
                                <td align="left"><input type="submit" name="submit" value="Update"></td>
                            <?php
                        }else{
                            ?>
                                <td align="right">&nbsp;</td>
                                <td align="left"><input type="submit" name="submit" value="Add"></td>
                            <?php
                        }
                    ?>
                </tr>
                <?php
                    if($mode == "m"){
                        ?>
                        <tr>
                            <td colspan="2"><br><br>Click <a href="am_task.php">HERE</a> to add a new task.</td>
                        </tr>
                        <?php
                    }
                ?>
            </table>
        </form>
    </div>
</body>
</html>
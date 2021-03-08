<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="reset.css">

</head>
<body>
<?php 
      require_once 'helpers.php';
    session_start();
    // logout logic
    if(isset($_GET['action']) and $_GET['action'] == 'logout'){
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['logged_in']);
    }
            
            //loginas
    
            $msg = '';
    if (isset($_POST['login']) 
        && !empty($_POST['username']) 
        && !empty($_POST['password'])
    ) {	
        if ($_POST['username'] == '1111' && 
            $_POST['password'] == '2222'
        ) {
            $_SESSION['logged_in'] = true;
            $_SESSION['timeout'] = time();
        } else {
            $msg = 'Wrong username or password';
        }
    } 

    if($_SESSION['logged_in'] == true){
        print('<h2>Logged in!</h2>');
        $path = "." . $_GET['path'];

        
        
        

        //  delete & downlaod
       
        if (array_key_exists('action', $_GET)) {    
            if (array_key_exists('file', $_GET)) {
                $file = "./" . $_GET['path'] . "./" . $_GET['file'];
                // print_r($file);
                if ($_GET['action'] == 'delete') {
                    unlink($path ."/" . $_GET['file']);
                } elseif ($_GET['action'] == 'download') {     
                    $fileDown = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
                    print_r($fileDown);
                    print_r($file);
                    ob_clean();
                    ob_flush();
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: attachment; filename=' . basename($fileDown));
                    header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($fileDown));
                    ob_end_flush();
                    readfile($fileDown);
                    exit;
                }
            }
        }
    
        // table
        $dir_contents = scandir($path);
        echo ('<table class="main"><thead><tr>
                <th>Type</th>
                <th>Name</th>
                <th>Actions</th>
                </tr></thead>');
        echo ('<tbody><tr>');
        foreach ($dir_contents as $cont) {
        
            if ($cont == "." || $cont == "..") {
                continue;
            }
        
            echo ('<tr><td>' . (is_dir($path . "/" . $cont) ? 'Dir' : 'file') . '</td>');
            
            if (is_dir($path . "/" . $cont)) {
                echo ('<td>' . "<a href='./?path=" . $_GET['path'] . "/" . $cont . "'>" . $cont .  '</a></td>');
                
            } else {
                echo ('<td>' . $cont . '</td>');
            }
    
            if (is_file($path . "/" . $cont)) {
                if ($cont != 'index.php' && $cont != 'style.css' && $cont != 'helpers.php' && $cont != 'login.php') {
                    echo ("<td><button><a href='./?path=" . $_GET['path'] . "&file=" . $cont . "&action=delete" ."'>" . "Delete</a></button>
                        <button><a href='./?path=" . $_GET['path'] . "&file=" . $cont . "&action=download". "'>" . "Download</a></button>");
                } else {
                    echo ('<td></td>');
                }
            } else {
                echo ('<td></td>');
            }
        }
        echo ('</tbody>');
        echo('<tfoot>
                <tr>
                <td colspan="3">
                <div class="links">' . "<a href='./?path=" . "#" . "'>" . "&laquo; BACK" . "</a>" . '</div>
                </td>
                </tr>
                </tfoot>');
        echo ('</table>');
    ?> 
    
    
    
        
    <!-- // upload form -->
    
    <div class="newDirDiv">
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" id="fileInput" class="create_btn">
        <button type="submit" name="upload" class="create_btn">Upload file</button>
    </form>
    </div>
    <?php
           

        //logout 
    echo('<h4 class="log_out">Click here to <a href = "index.php?action=logout"> logout.</h4>');     
    } else {
    
        echo('
            <div class="log_div">
                <h1>Enter Username and Password</h1>
        
                <form action="index.php" method="post"> 
                <h4>'.$msg.'</h4>
                <div class="log_input">
                    <input type="text" name="username" placeholder="write: 1111" required autofocus></br>
                    <input type="password" name="password" placeholder="write: 2222" required>
                    <button class = "btn_login" type="submit" name="login">Login</button>
                </div>
                    </form> 
            </div>   ');
    }
?>
<div>
    

</div> 
</body>
</html>

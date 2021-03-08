<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>file browser</title>
    <link rel="stylesheet" type="text/css" href="./css/normalize.css>">
    <link rel="stylesheet" type="text/css" href="./css/style.css">

    <?php  
    
    session_start();  
    
    ?>

    <html>
    <head>
       <title> Home </title>
    </head>
<body>
<?php
      if(!isset($_SESSION['use']))
       {
           header("Location:log.php");  
       }

          echo $_SESSION['use'];

          echo "Login Success";

          echo "<a href='logout.php'> Logout</a> "; 
?>

<script src="main.js"></script>

</body>
</html>

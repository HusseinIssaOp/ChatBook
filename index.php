<?php 
if(isset($_COOKIE['email']) && isset($_COOKIE['user_id'])){
    header("location: users.php");
    die;
}else{
    
}
?>


<!-- in the inc folder -->


<!-- easy to add them to other php files -->
<?php require("inc/head.php"); ?>
<?php require("inc/nav.php"); ?>
<?php require("inc/header.php"); ?>
<?php require("inc/footer.php"); ?>


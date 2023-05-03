<?php
if (isset($_SESSION["alert_success"])) :
?>

<div class="alert" style="background-color: green;">
    <span class="alert_closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    <?php echo $_SESSION["alert_success"]; ?>
</div>

<?php
    unset($_SESSION["alert_success"]);
endif;
?>

<?php
if (isset($_SESSION["alert_fail"])) :
?>

<div class="alert">
    <span class="alert_closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    <?php echo $_SESSION["alert_fail"]; ?>
</div>

<?php
    unset($_SESSION["alert_fail"]);
endif;
?>
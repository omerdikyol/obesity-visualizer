<?php
$root = $_SERVER['DOCUMENT_ROOT'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
</head>

<body>
    <header>
        <h1 style="text-align: center;">Obesity Visualizer</h1>
        <nav>
            <a href="../../../obesity-visualizer/index.php"><button class="buttonHeader">Home</button></a>
            <a href="/obesity-visualizer/app/controllers/visualize.php"><button
                    class="buttonHeader">Visualize</button></a>
            <a href="../../../obesity-visualizer/app/views/personal.php"><button
                    class="buttonHeader">Personal</button></a>

            <?php if (!isset($_SESSION['user_id'])) : ?>
            <a href="../../../obesity-visualizer/app/views/login.php"><button class="buttonHeader">Login</button></a>
            <a href="../../../obesity-visualizer/app/views/register.php"><button
                    class="buttonHeader">Register</button></a>
            <?php else : ?>
            <a href="../../../obesity-visualizer/app/views/logout.php"><button class="buttonHeader">Logout</button></a>
            <?php endif; ?>
            <div style="clear: both;"></div>
    </header>
</body>

</html>
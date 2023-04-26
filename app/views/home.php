<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>


<?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/includes/header.php"; ?>

<body>
    <h1>Home</h1>

    <?php if (isset($user)) : ?>
    <p style="text-align: center;">Welcome, <?php echo $user['name']; ?>!</p>
    <?php else : ?>
    <p style="text-align: center;"><a href="login.php">Login</a> or <a href="register.php">Register</a></p>

    <?php endif; ?>
</body>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/includes/footer.php"; ?>

</html>
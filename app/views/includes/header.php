<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obesity Visualizer</title>
</head>

<body>
    <header>
        <h1 style="text-align: center;">Obesity Visualizer</h1>
        <p>A powerful tool for monitoring and understanding obesity trends in Europe</p>
        <nav>
            <a href="/obesity-visualizer/app/controllers/home.php"><button class="buttonHeader">Home</button></a>
            <a href="/obesity-visualizer/app/controllers/visualize.php"><button
                    class="buttonHeader">Visualize</button></a>
            <a href="/obesity-visualizer/app/controllers/bmi_calc.php"><button class="buttonHeader">Calculate
                    BMI</button></a>
            <a href="/obesity-visualizer/app/controllers/personal.php"><button
                    class="buttonHeader">Personal</button></a>

            <?php if (!isset($_SESSION['user_id'])) : ?>
            <a href="/obesity-visualizer/app/controllers/login.php"><button class="buttonHeader">Login</button></a>
            <a href="/obesity-visualizer/app/controllers/register.php"><button
                    class="buttonHeader">Register</button></a>
            <?php else : ?>
            <a href="/obesity-visualizer/app/controllers/logout.php"><button class="buttonHeader">Logout</button></a>
            <?php endif; ?>
            <div style="clear: both;"></div>
    </header>
</body>

</html>
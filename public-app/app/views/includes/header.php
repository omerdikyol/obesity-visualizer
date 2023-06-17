<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obesity Visualizer</title>
    <style>
    .logoContainer {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: row;
    }
    </style>
</head>

<body>
    <header>
        <div class="logoContainer">
            <img src="/obesity-visualizer/public-app/public/images/logoov.png" alt="Obesity Visualizer Logo" width="100"
                height="100" style="margin-right: 10px;">
            <h1 style="text-align: center;">Obesity Visualizer</h1>
        </div>
        <p style="color: white;">A powerful tool for monitoring and understanding obesity trends in Europe</p>
        <nav>
            <a href="/obesity-visualizer/home"><button class="buttonHeader">Home</button></a>
            <a href="/obesity-visualizer/visualize"><button class="buttonHeader">Visualize</button></a>
            <a href="/obesity-visualizer/calculate-bmi"><button class="buttonHeader">Calculate
                    BMI</button></a>
            <a href="/obesity-visualizer/personal"><button class="buttonHeader">Personal</button></a>

            <?php if (!isset($_SESSION['user_id'])) : ?>
            <a href="/obesity-visualizer/login"><button class="buttonHeader">Login</button></a>
            <a href="/obesity-visualizer/register"><button class="buttonHeader">Register</button></a>
            <?php else : ?>
            <a href="/obesity-visualizer/logout"><button class="buttonHeader">Logout</button></a>
            <?php endif; ?>
            <div style="clear: both;"></div>
    </header>
</body>

</html>
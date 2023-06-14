<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="/obesity-visualizer/public-app/public/css/style.css">
</head>



<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/header.php"; ?>
    </header>
    <div class="homeContainer">
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/alert.php"; ?>
        <div class="card">
            <p>Obesity is a ghomeRowing problem in many countries around the world, including Europe. It is a complex
                issue
                that is influenced by a variety of factors, including genetics, diet, physical activity levels, and
                social and environmental factors. At Obesity Visualizer, we aim to provide a way for people to better
                understand this problem and its impact on individuals and society as a whole.<br>

                Our website offers a range of features to help you explore and understand obesity in Europe. First and
                foremost, we offer a BMI calculator that allows you to easily and quickly calculate your own BMI based
                on your height and weight. This can be an important first step in understanding your own health status
                and identifying potential risks for obesity-related health problems.</p>
        </div>
        <div class="card">
            <h2>Calculate your BMI</h2>
            <p>Use our BMI calculator to find out your own body mass index (BMI) and learn about potential health risks
                associated with obesity.</p>
            <a href="/obesity-visualizer/calculate-bmi"><button class="homeBtn">Calculate
                    BMI</button></a>
        </div>
        <div class="card">
            <p>But our website goes beyond just calculating your BMI. We also provide detailed visualizations of obesity
                rates across Europe, broken down by pre-obese, obese, and overweight categories. You can explore this
                data using a range of visualization tools, including pie charts, bar charts, maps, line charts, and
                tables. This allows you to see trends in obesity over time and across different regions of Europe, and
                helps you to better understand the scope of the problem.</p>
        </div>
        <div class="card">
            <h2>Visualize obesity data</h2>
            <p>Explore obesity rates in Europe using a range of visualization tools, including pie charts, bar charts,
                maps, line charts, and tables.</p>
            <a href="/obesity-visualizer/visualize"><button class="homeBtn">Visualize
                    Data</button></a>
        </div>
        <div class="card">
            <p>Our website is designed to be user-friendly and accessible to a wide range of users, from healthcare
                professionals and researchers to policymakers and interested individuals. Whether you're looking to
                explore the latest research on obesity trends, or simply want to learn more about this important health
                issue, Obesity Visualizer has something for you.<br>

                So why wait? Sign up now and start exploring the world of obesity in Europe with Obesity Visualizer!
                With our powerful tools and easy-to-use platform, you'll be able to better understand this complex
                problem and take steps to improve your own health and wellbeing.</p>
        </div>
        <div class="homeRow">
            <div class="homeCol">
                <img src="https://via.placeholder.com/400x300" alt="Obesity chart">
            </div>
            <div class="homeCol">
                <img src="https://via.placeholder.com/400x300" alt="BMI calculator">
            </div>
        </div>
    </div>
</body>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/footer.php"; ?>

</html>
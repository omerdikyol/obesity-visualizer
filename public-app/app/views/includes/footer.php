<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        footer {
            padding: 20px;
            text-align: center;
            bottom: 0;
            background-color: #262626;
            color: #fff;
            font-family: Arial, sans-serif;
            margin-top: 100px;
        }

        .footer-columns {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .footer-column {
            flex: 1;
            margin-right: 40px;
            margin-bottom: 40px;
        }

        .footer-column:last-child {
            margin-right: 0;
        }

        .footer h4 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        footer ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        footer li {
            margin-bottom: 10px;
        }

        footer a {
            color: #fff;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        footer p {
            margin: 0 0 10px 0;
        }

        .social-icons {
            display: flex;
            justify-content: center;
        }

        .social-icons a {
            display: inline-block;
            width: 40px;
            height: 40px;
            margin-right: 10px;
            background-color: #fff;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            font-size: 20px;
            color: #262626;
            transition: background-color 0.2s;
        }

        .social-icons a:hover {
            background-color: #fff;
            color: #262626;
        }

        .fab {
            font-family: "Font Awesome 5 Brands";
        }
    </style>
</head>

<footer>
    <div class="footer-columns">
        <div class="footer-column">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="/obesity-visualizer/public-app/app/controllers/home.php">Home</a></li>
                <li><a href="/obesity-visualizer/public-app/app/controllers/visualize.php">Visualize</a></li>
                <li><a href="/obesity-visualizer/public-app/app/controllers/bmi_calc.php">Calculate BMI</a></li>
                <li><a href="/obesity-visualizer/public-app/app/controllers/personal.php">Personal</a></li>
                <li><a href="/obesity-visualizer/public-app/app/controllers/admin.php">Admin</a></li>
                <li><a href="/obesity-visualizer/public-app/app/views/projectReport.php">Project Report</a></li>

            </ul>
        </div>
        <div class="footer-column">
            <h4>Contact Us</h4>
            <p>Send us an email:</p>
            <a href="mailto:omerdikyol02@gmail.com">contact@obesity-visualizer.com</a>
        </div>
        <div class="footer-column">
            <h4>Connect with Us</h4>
            <p>Follow us on social media:</p>
            <div class="social-icons">
                <a href="#"><i class=" fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <p class="footer-text">&copy; 2023 Obesity Visualizer. All Rights Reserved.</p>
</footer>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>
    <!-- Fixed header -->
    <?php include('./app/views/includes/header.php'); ?>

    <!-- Main content of the page -->
    <article>
        <h1>1. Introduction</h1>
        <h3>1.1 Purpose</h3>
        <p>Obesity Visualizer is a software tool designed allow users to view worldwide
            obesity data, compare country-based datas, and export all the data in various ways.</p>

        <h3>1.2 Product Scope</h3>
        <p> Obesity Visualizer is a software tool designed to provide users with up-to-date information
            about obesity rates, trends, and contributing factors worldwide. The purpose of the website is to educate
            and inform users about the causes and consequences of obesity, and to help users make informed decisions
            about their health and wellness. The website will include interactive visualizations and data analytics
            tools to help users understand complex obesity-related data, as well as educational resources such as
            articles and videos.<br>

            The relevant benefits of Obesity Visualizer include increasing awareness of the global obesity
            epidemic, promoting healthy behaviors and lifestyle choices, and providing a centralized source of accurate
            and trustworthy information on obesity-related topics. The objectives of the website are to provide users
            with access to the most current and accurate obesity-related data, to promote evidence-based decision-making
            regarding obesity prevention and management, and to serve as a valuable resource for researchers,
            policymakers, and healthcare professionals.<br>

            Obesity Visualizer is aligned with the corporate goal of promoting healthy behaviors and
            improving overall wellness. The website supports the business strategy of developing technology solutions
            that leverage data and analytics to address complex public health issues. The website will be developed
            using the latest web technologies and will be designed to be responsive and accessible on a variety of
            devices. The website will be hosted on a secure server and will be available to users around the world.<br>
        </p>

        <h3>1.3 References</h3>
        <p>Obesity Visualizer uses public data provided by <a
                href="https://ec.europa.eu/eurostat/databrowser/view/sdg_02_10/default/table?lang=en"
                target="_blank">Eurostat</a></p>

        <h1>2. Overall Description</h1>
        <h3>2.1 Product Functions</h3>
        <p><strong>User</strong></p>
        <ul>
            <li>Register</li>
            <li>Login</li>
            <li>Add Personal BMI Data</li>
            <li>View Personal Data</li>
            <li>View Global Obesity Data</li>
            <li>View Country Obesity Data</li>
            <li>Compare Country Obesity Data</li>
            <li>Export Data</li>
        </ul>

        <p><strong>Admin</strong></p>
        <ul>
            <li>User's Functions</li>
            <li>Add Obesity Data</li>
            <li>View User Data</li>
            <li>View User BMI Data</li>
        </ul>

        <h3>2.2 User Classes and Characteristics</h3>
        <p><strong>Class 1: User</strong></p>
        <p>The user may or may not be logged in. Without registration, user can still view and export data.</p>
        <p>However, in order to be able to enter values such as height and weight and display these values in the
            current table of his/her country, user must be registered.
        <p>In addition, the user is grouped according to these values entered and the index is shown to the user.</p>
        <p><strong>Class 2: Admin</strong></p>
        <p>Admin can perform all functions that users can do.</p>
        <p>As an extra, it can view and edit the data entered by users.</p>

        <h3>2.3 Operating Environment</h3>
        <p>This system will be developed using PHP 8.1.10.</p>

        <h3>2.4 Assumptions and Dependencies</h3>
        <p>There may be no problem when displaying data in graph, line, chart etc., but dynamically integrating the
            world map without
            using a library may be a problem. If it cannot be dynamically integrated, it will be put as clickable SVG
            format.</p>

        <h1>3. External Interface Requirements</h1>
        <h3>3.1 User Interfaces</h3>
        <p>User can interact with different interfaces using buttons on the header.</p>
        <p>Currently, home page is report of the project. However, over time, the project report will become a separate
            file called "report.php" and will be accessible by simply entering the url.</p>
        <p>Visualize button is directing user to the visualizer of the page. On that page, user can change the data
            visualization type using buttons on the left, and can export data using buttons on the right.</p>
        <p>On personal page, user can see and update their personal data.</p>
        <p>User can login and register using Login and Register buttons. Once user is logged in, those buttons will be
            unvisible and Logout button will appear.</p>

        <h1>4. System Features</h1>
        <h3>Registering Users</h3>
        <p>Mandatory information such as name, surname, country, email, password are taken from the user. If the user
            wants to enter, he can also enter information such as height, weight, age (This information can be entered
            later on the user page). This information is then saved in the database and a session specific token is
            created.</p>

        <h3>Logging In</h3>
        <p>Email and password information are received from the user, and a response is sent according to the accuracy
            of the data. If the information is correct, the token will be created and redirected to the home page,
            otherwise an error message will be sent and you will stay on the login page.</p>

        <h3>Logging Out</h3>
        <p>When the user logs out, the session is destroyed and the user is redirected to the login page.</p>

        <h3>Adding Personal BMI Data</h3>
        <p>Height, weight, age information is received from the user and the BMI index is calculated. This information
            is then saved in the database.</p>

        <h3>Viewing Personal Data</h3>
        <p>Personal data is taken from the database and displayed on the personal page.</p>

        <h3>Visualize Obesity Data</h3>
        <p>Obesity data is taken from the database and displayed on the obesity page.</p>
        <p>By default, the data appears with no filters applied. If the user wants to filter data or view the relevant
            data in a different way, uses the buttons on the Visualize page.</p>
        <p>User can visualize data in 4 different ways: pie, graph, bar and map. On pie, graph and bar charts, user
            can't interact with graph but can filter the data and chart changes automatically. But on the map, in
            addition to the filtering, user can click all permitted countries and visualize that country's data.</p>

        <h3>Comparing Country Obesity Data</h3>
        <p>User can compare two different countries obesity data.</p>

        <h3>Exporting Data</h3>
        <p>User can export data in different formats: CSV, JSON, SVG, WEBP.</p>

    </article>
</body>

<?php include('./app/views/includes/footer.php'); ?>

</html>
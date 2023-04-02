<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>
    <!-- Fixed header -->
    <header>
        <h1>Obesity Visualizer</h1>
        <nav>
            <a href="about.html">About</a>
            <a href="contact.html">Contact</a>
            <a href="services.html">Services</a>
        </nav>
    </header>

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
        <p>Relevant pages can be accessed using the buttons in the header.</p>

        <h1>4. System Features</h1>
        <h3>Feature 1</h3>
    </article>
</body>

</html>
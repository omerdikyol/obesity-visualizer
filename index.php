<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <base href="./">
    <meta charset="UTF-8">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <style>
    h1 {
        text-align: left;
    }
    </style>
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
        <p>General Users are individuals who visit the website to access and explore the data and statistics provided by
            Eurostat. They may come from various backgrounds and professions, including students, researchers,
            journalists, policymakers, and the general public.<br>

            The characteristics of General Users include having basic computer skills and knowledge of how to use a web
            browser. They are typically looking for specific data or statistics related to their area of interest and
            expect the website to provide an intuitive and easy-to-use interface to access this information. They may
            also want to explore and compare data across different countries or regions.<br>

            General Users may have different levels of expertise in data analysis and may require different levels of
            guidance and support. Some may be experienced data analysts who are looking for advanced features and
            functionality, such as the ability to download raw data or to visualize data in different ways. Others may
            be less experienced and may require more guidance in understanding and interpreting the data presented on
            the website.<br>

            General Users may have different levels of trust and confidence in the data presented on the website. They
            may require clear and transparent information on the data sources and methodology used to collect and
            analyze the data, as well as any limitations or caveats to keep in mind when interpreting the results.<br>

            Overall, General Users are an important user class for the website, as they are the primary audience for the
            data and statistics provided by Eurostat. The website should be designed with their needs and expectations
            in mind, providing an intuitive and user-friendly interface, clear and transparent information on the data
            presented, and support for users with different levels of expertise and experience.<br>
        </p>
        <h4>Characteristics:</h4>
        <ul>
            <li>General users may not have advanced technical skills, and may require a user-friendly interface and
                clear instructions to navigate the website.</li>
            <li>General users may come from diverse backgrounds, with varying levels of education, cultural norms, and
                language proficiency. The website should be designed to accommodate these differences.</li>
            <li>General users may have a short attention span, and may quickly lose interest in the website if they
                cannot easily find the information they need.</li>
            <li>General users are typically goal-oriented, seeking specific information or services. The website should
                be designed to help them achieve their goals quickly and easily.</li>
            <li>General users may access the website from a variety of devices, including desktop computers, laptops,
                tablets, and smartphones. The website should be responsive and accessible across all devices.</li>
        </ul>
        <p><strong>Class 2: Admin</strong></p>
        <p>An admin is a user who has access to the administrative features of the system. They are responsible for
            managing user accounts, adding and removing content, and performing other tasks related to the operation of
            the website.
        </p>
        <h4>Characteristics:</h4>
        <ul>
            <li>Admins have the highest level of access and control over the system.</li>
            <li>They are responsible for managing user accounts and ensuring that only authorized users have access to
                the system.</li>
            <li>Admins can add, modify, or delete content on the website, including user-generated content.</li>
            <li>They are responsible for monitoring the website for inappropriate content or behavior and taking
                appropriate action to address any issues.</li>
            <li>Admins may have access to sensitive user information and must ensure that this information is kept
                confidential and secure.</li>

        </ul>

        <h3>2.3 Operating Environment</h3>
        <p>This system will be developed using PHP 8.1.10. The data will be stored in MySQL database.</p>

        <h3>2.4 Assumptions and Dependencies</h3>
        <h4>Assumptions:</h4>
        <ul>
            <li>Users have basic computer skills and know how to use a web browser.</li>
            <li>Users have access to a stable internet connection.</li>
            <li>Users will be able to provide accurate personal information when registering.</li>
            <li>The public data provided by Eurostat will be up-to-date and reliable.</li>
            <li>The MySQL database will be available and functional during the development and deployment of the
                project.</li>
        </ul>
        <h4>Dependencies:</h4>
        <ul>
            <li>The project relies on PHP 8.1.10 for development and execution.</li>
            <li>The project relies on the MySQL database for storing and managing data.</li>
            <li>The project is dependent on the availability and reliability of the Eurostat public data.</li>
            <li>The project may depend on a stable and secure web hosting service to deploy and serve the website
                to users.</li>
            <li>The project may depend on third-party libraries or APIs for specific functionalities, such as data
                visualization or data export.</li>
        </ul>

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

        <h3>Social Media Integration</h3>
        <p>Users can share content from the system on their social media profiles, or sign up/login using their
            social media accounts.

        <h3>Localization and Internationalization</h3>
        <p>Support for multiple languages and currencies to make the system accessible to a wider audience.</p>

    </article>
</body>

<?php include('./app/views/includes/footer.php'); ?>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Obesity Visualizer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
</head>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/includes/sidenav.php'; ?>

<body>
    <div class="main" id="main">
        <div class="dashboardWrapper">
            <div class="dashboard-content">
                <h1>Admin Dashboard</h1>
                <div class="adminButton-row">
                    <a href="/obesity-visualizer/app/controllers/admin/users.php" class="adminButton user-list">
                        <i class="fas fa-users"></i>
                        <span>User List</span>
                    </a>
                    <a href="/obesity-visualizer/app/controllers/admin/user_create.php" class="adminButton add-user">
                        <i class="fas fa-user-plus"></i>
                        <span>Add User</span>
                    </a>
                </div>
                <div class="adminButton-row">
                    <a href="/obesity-visualizer/app/controllers/admin/countries.php" class="adminButton country-data">
                        <i class="fas fa-globe"></i>
                        <span>Country Data</span>
                    </a>
                    <a href="/obesity-visualizer/app/controllers/admin/country_create.php"
                        class="adminButton add-country-data">
                        <i class="fas fa-plus"></i>
                        <span>Add Country Data</span>
                    </a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
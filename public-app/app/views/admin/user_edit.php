<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>OV Admin | Edit User</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='/obesity-visualizer/public-app/public/css/style.css'>
    <link rel="icon" href="/obesity-visualizer/public-app/public/images/logoov.ico">
</head>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/includes/sidenav.php'; ?>

<body>
    <div class="main">
        <h1 style="color: black;">Edit User</h1>

        <div class=" container" id="edit_container">

            <div class=" container">
                <form action="/obesity-visualizer/public-app/app/models/admin/user_edit.php" method="post" class="form">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $name ?>" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $email ?>" required>

                    <label for="country">Country</label>
                    <select id="country" name="country" required>
                        <option value="<?php echo $country ?>"><?php echo ucfirst($country) ?></option>
                        <?php
                        foreach ($countries as $key => $country) {
                            echo "<option value='$country'>$country</option>";
                        }
                        ?>
                    </select>

                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $date_of_birth ?>"
                        required>

                    <label for="height">Height (cm)</label>
                    <input type="number" id="height" name="height" value="<?php echo $height ?>">

                    <label for="weight">Weight (kg)</label>
                    <input type="number" id="weight" name="weight" value="<?php echo $weight ?>">

                    <input type="submit" value="Submit" class="button1" name="user_edit">
                </form>
                <a href="/obesity-visualizer/admin/user-list" style="text-decoration: none;">
                    <button class="button1" id="usersBtn">Back</button></a>
            </div>
        </div>
</body>

</html>
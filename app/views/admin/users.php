<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Admin</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='/obesity-visualizer/public/css/style.css'>
</head>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/includes/sidenav.php'; ?>

<body>
    <div class="main">

        <a href="/obesity-visualizer/app/controllers/admin/user_create.php">
            <button class="button1" id="usersBtn" style="float: right;">Add User</button>
        </a>
        <h1>Users</h1>

        <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/includes/alert.php"; ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Country</th>
                <th>Date Of Birth</th>
                <th>Height</th>
                <th>Weight</th>
                <th>BMI</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $key => $user) { ?>
            <tr>
                <td><?php echo $user['id'] ?></td>
                <td><?php echo $user['name'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo $user['country'] ?></td>
                <td><?php echo $user['date_of_birth'] ?></td>
                <td><?php echo $user['height'] ?></td>
                <td><?php echo $user['weight'] ?></td>
                <td><?php echo $user['bmi'] ?></td>
                <td>
                    <a
                        href="/obesity-visualizer/app/controllers/admin/user_edit.php?id=<?php echo $user['id'] ?>">Edit</a>
                    <a
                        href="/obesity-visualizer/app/controllers/admin/user_delete.php?id=<?php echo $user['id'] ?>">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>
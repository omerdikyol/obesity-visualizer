<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Admin</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='/obesity-visualizer/public-app/public/css/style.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/includes/sidenav.php'; ?>

<body>
    <div class="main">
        <a href="/obesity-visualizer/public-app/app/controllers/admin/user_create.php" class="adminButton adminSmall adminCreate" style="float: right; width: fit-content;">
            <i class="fas fa-plus"></i>
            <span>Add User</span>
        </a>
        <h1>Users</h1>

        <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/alert.php"; ?>
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
                        <a href="/obesity-visualizer/public-app/app/controllers/admin/user_edit.php?id=<?php echo $user['id'] ?>" class="adminButton adminSmall adminEdit">
                            <i class="fas fa-edit"></i>
                            <span>Edit</span>
                        </a>
                        <a href="/obesity-visualizer/public-app/app/controllers/admin/user_delete.php?id=<?php echo $user['id'] ?>" class="adminButton adminSmall adminDelete">
                            <i class="fas fa-trash-alt"></i>
                            <span>Delete</span>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>
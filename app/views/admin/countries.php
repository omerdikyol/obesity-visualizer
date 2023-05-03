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

        <a href="/obesity-visualizer/app/controllers/admin/country_create.php">
            <button class="button1" id="usersBtn" style="float: right;">Add Data</button>
        </a>
        <h1>Country Data</h1>

        <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/app/views/includes/alert.php"; ?>
        <table style=" overflow-y:scroll;">
            <tr>
                <th><a href="#">BMI</a></th>
                <th>Country Code</th>
                <th>Year</th>
                <th>Percentage</th>
                <th>Flag</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($countries as $key => $country) { ?>
            <tr>
                <td><?php echo $country['bmi'] ?></td>
                <td><?php echo $country['geo'] ?></td>
                <td><?php echo $country['year'] ?></td>
                <td><?php echo $country['value'] ?></td>
                <td><?php echo $country['flag'] ?></td>
                <td>
                    <a
                        href="/obesity-visualizer/app/controllers/admin/country_edit.php?bmi=<?php echo $country['bmi'] ?>&geo=<?php echo $country['geo'] ?>&year=<?php echo $country['year'] ?>">
                        Edit</a>
                    <a
                        href="
                        /obesity-visualizer/app/controllers/admin/country_delete.php?bmi=<?php echo $country['bmi'] ?>&geo=<?php echo $country['geo'] ?>&year=<?php echo $country['year'] ?>">
                        Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>
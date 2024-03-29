<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>OV Admin | Country List</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='/obesity-visualizer/public-app/public/css/style.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" href="/obesity-visualizer/public-app/public/images/logoov.ico">
</head>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/includes/sidenav.php'; ?>

<body>
    <div class="main">

        <a href="/obesity-visualizer/admin/country-create" class="adminButton adminSmall adminCreate"
            style="float: right; width: fit-content;">
            <i class="fas fa-plus"></i>
            <span>Add Data</span>
        </a>
        <h1>Country Data</h1>

        <?php include $_SERVER['DOCUMENT_ROOT'] . "/obesity-visualizer/public-app/app/views/includes/alert.php"; ?>
        <table style=" overflow-y:scroll;">
            <tr>
                <th>ID</th>
                <th>BMI</th>
                <th>Country Code</th>
                <th>Year</th>
                <th>Percentage</th>
                <th>Flag</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($countries as $key => $country) { ?>
            <tr>
                <td><?php echo $country['id'] ?></td>
                <td><?php echo $country['bmi'] ?></td>
                <td><?php echo $country['geo'] ?></td>
                <td><?php echo $country['year'] ?></td>
                <td><?php echo $country['value'] ?></td>
                <td><?php echo $country['flag'] ?></td>
                <td>
                    <a href="/obesity-visualizer/admin/country-edit/<?php echo $country['id'] ?>"
                        class="adminButton adminSmall adminEdit">
                        <i class="fas fa-edit"></i>
                        <span>Edit</span>
                    </a>
                    <a href="/obesity-visualizer/admin/country-delete/<?php echo $country['id'] ?>"
                        class="adminButton adminSmall adminDelete">
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
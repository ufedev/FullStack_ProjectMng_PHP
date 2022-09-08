<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css" />
    <title>Dashboard | <?php echo $titulo ?? ""; ?></title>
</head>

<body class="body_dashboard">


    <?php
    include __DIR__ . "/../components/header.php";
    ?>


    <div class="dashboard">
        <div class="dashboard_aside">
            <?php
            include __DIR__ . "/../components/lateral.php";
            ?>
        </div>
        <div class="dashboard_content">
            <?php
            echo $content;
            ?>
        </div>
    </div>
</body>
<script type="text/javascript" src="/js/app.js"></script>

</html>
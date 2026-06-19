<!DOCTYPE html>
<html lang="fr">
<head>

<meta charset="UTF-8">

<title>WonderPro</title>

<link href="src/bootstrap-5.3.8/css/bootstrap.min.css" rel="stylesheet">
<link href="src/bootstrap-5.3.8/bootstrap-icons-1.13.1/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    margin:0;
}

.wrapper{
    display:flex;
    min-height:100vh;
}

.content{
    flex:1;
    padding:25px;
    background:#f5f7fb;
    margin-left:250px;
    width: calc(100% - 250px);
}

@media (max-width: 768px) {
    .wrapper {
        flex-direction: column;
    }
    .content {
        margin-left: 0;
        width: 100%;
    }
    .sidebar-partial {
        width: 100% !important;
        min-height: auto;
        height: auto;
        position: relative;
    }
}

</style>

</head>

<body>

<div class="wrapper">

    <?php require_once "sidebar.php"; ?>

    <div class="content">

        <?php require_once $page; ?>

    </div>

</div>

<div id="localFlashData"
     data-success="<?= htmlspecialchars($_SESSION["success"] ?? '') ?>"
     data-error="<?= htmlspecialchars($_SESSION["error"] ?? '') ?>"
     hidden></div>

<script src="src/bootstrap-5.3.8/js/bootstrap.bundle.min.js"></script>
<script src="src/js/flash-notifications.js"></script>
<?php if(isset($_SESSION["success"])): ?>
    <?php unset($_SESSION["success"]); ?>
<?php endif; ?>
<?php if(isset($_SESSION["error"])): ?>
    <?php unset($_SESSION["error"]); ?>
<?php endif; ?>
</body>
</html>
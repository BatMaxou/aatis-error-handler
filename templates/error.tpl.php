<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $type.' '.($code ?? $level); ?></title>

    <style>
        <?php include __DIR__.'/../assets/css/style.css'; ?>
    </style>
</head>

<body>
    <div class="header">
        <div class="error-description">
            <div class="wrapper">
                <h1><?php echo $type.': '.$message; ?></h1>
                <p class="sub-text"><?php echo 'in '.$file.' (line '.$line.')'; ?></p>
            </div>
        </div>
        <div class="error-infos">
            <div class="wrapper">
                <p class="sub-text"><?php echo 'Code '.($code ?? $level); ?>
                <p class="sub-text"><?php echo $description; ?>
            </div>
        </div>
    </div>

    <div class="content">
        <?php foreach ($trace as $step) {
            include __DIR__.'/components/traceStep.tpl.php';
        } ?>
    </div>

    <script>
        <?php include __DIR__.'/../assets/js/script.js'; ?>
    </script>
</body>

</html>

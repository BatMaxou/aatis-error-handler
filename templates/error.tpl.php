<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $type . ' ' . ($code ?? $level) ?></title>
</head>

<body>
    <div class="header">
        <div class="errorDescription">
            <h1><?php echo $type . ': ' . $message ?></h1>
            <p class="subText"><?php echo 'in ' . $file . ' (line ' . $line . ')' ?></p>
        </div>
        <div class="errorInfos">
            <p class="subText"><?php echo 'Code' . ($code ?? $level) ?>
            <p class="subText"><?php echo 'Enum Category Error/Exception' ?>
        </div>
    </div>

    <div class="content">
        <?php foreach ($trace as $step) include __DIR__ . '/components/traceStep.tpl.php' ?>
    </div>
</body>

</html>

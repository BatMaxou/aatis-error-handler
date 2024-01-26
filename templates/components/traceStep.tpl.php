<div class="traceStep">
    <?php

    if (isset($step['isMain']) && $step['isMain']) {
        echo '<div class="traceTitle">
            <p class="detailText">'.($class ?? '').'</p>
            <p class="subText">'.($name ?? '').'</p>
        </div>';
    } else {
        echo '<div class="traceTitle">
            <p class="subText">in'.($step['file'] ?? '').' (line '.($step['line'] ?? '').')</p>
        </div>';
    }

    ?>

    <div class="traceContext">
        <?php foreach ($step['context'] as $lineNumber => $lineContent) {
            include __DIR__.'/tracesStepLine.php';
        } ?>
    </div>
</div>

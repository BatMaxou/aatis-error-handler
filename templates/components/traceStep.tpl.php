<?php $isMain = isset($step['isMain']) && $step['isMain']; ?>

<div class="trace-step <?php echo $isMain ? 'main' : ''; ?>">
    <div class="trace-header">
        <div class="title">
            <?php

            if ($isMain) {
                echo '
                    <p class="detail-text">'.($class ?? '').'</p>
                    <p class="sub-text">'.($name ?? '').'</p>';
            } else {
                echo '
                    <p class="sub-text">in'.($step['file'] ?? '').' (line '.($step['line'] ?? '').')</p>';
            }

?>
        </div>

        <div class="chevron <?php echo $isMain ? 'active' : ''; ?>">
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="60" height="60" fill="url(#pattern0)" />
                <defs>
                    <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_33_4" transform="scale(0.0166667)" />
                    </pattern>
                    <image id="image0_33_4" width="60" height="60" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAACXBIWXMAAAsTAAALEwEAmpwYAAAB1UlEQVR4nO2YsUoDQRCGN6RQC8E2EElzkP3/KYKF+gYWitZqo5WvYGurnS8g2ljb6RtoY2ljpZiolWAhERRPTiOoxGT3cpdbcD4YSBFm/rm7nflZYxRFURRFURRFURRFUf4NJJcA3AO4I7lqAofkSqI10Swii2kS3JKMv8WOMaZswqNMcvuX1pZ3Fv5M8BEAThqNxoQJhHq9Pk7yqJtW72TskqQTlyKCXDrw0xcBuPhLZ5YNxyQfU52TjBCROQAPvTRm3XBM8pXkZi4d9da1AeClnz7vxACuHZpO4qBWq42anElqANh31HTlXcBau0Cy7VjgzFpbyaXTTy0VkqeOWtoA5lMVAjDl8aZbAGazbtZXA8mZYT7dZ5LrWTVrrV0G8ORY+1xEJjMpHEXRCIA9x8JJ7A5oUkoAtki+udQDcFitVsdMUROSA5iUXmaikE0hDjswrUnpZyYK8wLMQVieDzITsvz0PI/KcZF+vtQZLnGa4VLAMCxufaRYd2smJERkmmTTsYGmz3+T3CZErN9bc/4aTMhE/ufS6bwHDz0mr89EDxrx262FXywM26QEcXU0FJNStJkYtkkJw0zkeWGe7FYAN8nv3AopiqIoiqIoiqIoimK+eAeDK6F6MDMYIAAAAABJRU5ErkJggg==" />
                </defs>
            </svg>
        </div>
    </div>

    <div class="trace-context <?php echo $isMain ? 'active' : ''; ?>">
        <?php foreach ($step['context'] as $lineNumber => $lineContent) {
            include __DIR__.'/tracesStepLine.php';
        } ?>
    </div>
</div>

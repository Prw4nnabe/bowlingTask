<?php

require_once('game.php');

$game = new Game();

for ($frame = 1; $frame <= 10; $frame++) {
    echo "Frame $frame:\n";

    echo "  Enter the number of pins knocked down in the first roll: ";
    $firstRoll = getValidNumericInput(0, 10);

    $game->roll($firstRoll);

    if ($firstRoll === 10 && $frame <= 9) {
        echo "\nStrike!\n";
        $game->addFrame("X");
        echo "Frame $frame: Strike!\n";
        echo "Frame Score: " . $game->getScore()[$frame - 1] . "\n\n";
        continue;
    }

    if ($frame === 10) {
        if ($firstRoll === 10) {
            echo "  Enter the number of pins knocked down in the second roll: ";
            $secondRoll = getValidNumericInput(0, 10);
            $game->roll($secondRoll);

            if ($secondRoll === 10) {
                echo "  Enter the number of pins knocked down in the bonus roll: ";
                $bonusRoll = getValidNumericInput(0, 10);
                $game->roll($bonusRoll);
            }
        } else {
            echo "  Enter the number of pins knocked down in the second roll: ";
            $secondRoll = getValidNumericInput(0, 10 - $firstRoll);
            $game->roll($secondRoll);

            if ($firstRoll + $secondRoll === 10) {
                echo "  Enter the number of pins knocked down in the bonus roll: ";
                $bonusRoll = getValidNumericInput(0, 10);
                $game->roll($bonusRoll);
            }
        }
    } else {
        echo "  Enter the number of pins knocked down in the second roll: ";
        $secondRoll = getValidNumericInput(0, 10 - $firstRoll);
        $game->roll($secondRoll);
    }

    $frameData = $firstRoll . " " . $secondRoll;
    $game->addFrame($frameData);

    $frameScore = $game->getScore()[$frame - 1];

    echo "\n";
    echo "  | " . $firstRoll . " | " . $secondRoll . " |\n";
    echo "  +--------+\n";
    echo "  | Score: " . $frameScore . " |\n\n";
}

$frameScores = $game->getScore();
$frames = $game->getFrames();

$lastFrameIndex = count($frameScores) - 1;
$lastFrameScore = $frameScores[$lastFrameIndex];

if ($lastFrameScore === 10) {
    if ($frame === 10) {
        echo "  Enter the number of pins knocked down in the bonus roll: ";
        $bonusRoll = getValidNumericInput(0, 10);
        $game->roll($bonusRoll);
        $lastFrameScore += $bonusRoll;
    }
}

echo "\nGame Over\n\n";
echo "Frames:\n";

foreach ($frames as $index => $frame) {
    $frameNumber = $index + 1;
    if ($frameNumber === 10 && isset($bonusRoll)) {
        echo "Frame $frameNumber: " . $frame . " " . $bonusRoll . "\n";
    } else {
        echo "Frame $frameNumber: " . $frame . "\n";
    }
}

echo "\nFinal Score: " . $lastFrameScore . "\n";

function getValidNumericInput($min, $max)
{
    $input = trim(fgets(STDIN));

    while (!is_numeric($input) || $input < $min || $input > $max) {
        echo "  Invalid input! Enter a number between $min and $max: ";
        $input = trim(fgets(STDIN));
    }

    return intval($input);
}

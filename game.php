<?php

class Game
{
    private $rolls = [];
    private $currentRoll = 0;
    private $frames = [];

    public function roll($pins)
    {
        $this->rolls[$this->currentRoll++] = $pins;
    }

    public function getScore()
    {
        $score = 0;
        $rollIndex = 0;
        $frameScores = [];

        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->isStrike($rollIndex)) {
                $score += 10 + $this->strikeBonus($rollIndex);
                $frameScores[$frame] = $score;
                $rollIndex += 1;
            } elseif ($this->isSpare($rollIndex)) {
                $score += 10 + $this->spareBonus($rollIndex);
                $frameScores[$frame] = $score;
                $rollIndex += 2;
            } else {
                $score += $this->sumOfBallsInFrame($rollIndex);
                $frameScores[$frame] = $score;
                $rollIndex += 2;
            }
        }

        return $frameScores;
    }

    public function addFrame($frame)
    {
        $this->frames[] = $frame;
    }

    public function getFrames()
    {
        return $this->frames;
    }

    private function isStrike($rollIndex)
    {
        return isset($this->rolls[$rollIndex]) && $this->rolls[$rollIndex] === 10;
    }

    private function isSpare($rollIndex)
    {
        return isset($this->rolls[$rollIndex]) && isset($this->rolls[$rollIndex + 1]) && $this->rolls[$rollIndex] + $this->rolls[$rollIndex + 1] === 10;
    }

    private function strikeBonus($rollIndex)
    {
        $bonus = 0;
        if (isset($this->rolls[$rollIndex + 1])) {
            $bonus += $this->rolls[$rollIndex + 1];
        }
        if (isset($this->rolls[$rollIndex + 2])) {
            $bonus += $this->rolls[$rollIndex + 2];
        }
        return $bonus;
    }

    private function spareBonus($rollIndex)
    {
        return isset($this->rolls[$rollIndex + 2]) ? $this->rolls[$rollIndex + 2] : 0;
    }

    private function sumOfBallsInFrame($rollIndex)
    {
        return isset($this->rolls[$rollIndex]) && isset($this->rolls[$rollIndex + 1]) ? $this->rolls[$rollIndex] + $this->rolls[$rollIndex + 1] : 0;
    }
}

<?php

/**
 * Class TenPinBowling
 */
class TenPinBowling
{
    /**
     * Number of frames per bowling game
     */
    const NUM_FRAMES_PER_GAME = 10;

    /**
     * Number of pins per round
     */
    const NUM_PINS = 10;

    /**
     * Character to represent a strike
     */
    const PIN_STRIKE = 'X';

    /**
     * Character to represent a spare
     */
    const PIN_SPARE = '/';

    /**
     * The rolls for the current game
     *
     * @var string
     */
    protected $_rolls = '';

    /**
     * Given a string of bowling rolls, produce a total score for the game.
     *
     * @param $rolls
     * @return int
     */
    public function scoreGame($rolls)
    {

        $score = 0;
        $this->_rolls = $rolls;

        // Keep a running tally of which frame number we're looking at
        $frameCount = 1;

        // Keep track of whether we need to advance to the next frame.  Necessary, since, for rounds
        // not containing spares and strikes, we need to advance every other time.
        $shouldAdvanceToNextFrame = false;

        // Iterate through the $rolls string, character-by-character
        for ($rollIndex = 0; $rollIndex < strlen($rolls); $rollIndex++) {
            $roll = $rolls[$rollIndex];

            // Stop when we've reached the maximum number of frames
            if ($frameCount > self::NUM_FRAMES_PER_GAME) {
                break;
            }

            // Add the number of pins knocked down to the score
            $score += $this->_getNumberOfPinsKnockedDown($rollIndex);

            // If roll is a strike, also add the number of pins knocked down for the new two rolls; if roll is
            // a spare, also add the number of pins knocked down for the next roll
            if ($roll === self::PIN_STRIKE) {
                $score += $this->_getNumberOfPinsKnockedDown($rollIndex + 1);
                $score += $this->_getNumberOfPinsKnockedDown($rollIndex + 2);
                $shouldAdvanceToNextFrame = true;
            } else if ($roll === self::PIN_SPARE) {
                $score += $this->_getNumberOfPinsKnockedDown($rollIndex + 1);
                $shouldAdvanceToNextFrame = true;
            }

            // Increase the frame count if we've determined that we should advance to the next frame
            if ($shouldAdvanceToNextFrame) {
                $frameCount++;
            }

            // Invert the $shouldAdvanceToNextFrame flag, because if we didn't advance this time, we need to advance
            // next time, and if we advanced this time, we need to start a whole new frame, and only advance if the
            // next iteration determines that we have a spare or strike
            $shouldAdvanceToNextFrame = !$shouldAdvanceToNextFrame;

        }

        return $score;
    }

    /**
     * Find the actual number of pins knocked down for the ${rollIndex}th roll
     *
     * @param $rollIndex
     * @return int
     */
    protected function _getNumberOfPinsKnockedDown($rollIndex)
    {
        $pins = 0;
        $currentRoll = substr($this->_rolls, $rollIndex, 1);

        if (ctype_digit($currentRoll)) {
            $pins = $currentRoll;
        } else if ($currentRoll === self::PIN_STRIKE) {
            $pins = self::NUM_PINS;
        } else if ($currentRoll === self::PIN_SPARE) {
            $prevPins = (int)substr($this->_rolls, $rollIndex - 1, 1);
            $pins = self::NUM_PINS - $prevPins;
        }

        return $pins;
    }
}

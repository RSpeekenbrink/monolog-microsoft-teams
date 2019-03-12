<?php

/*
 * This file is part of the Monolog Teams Handler package.
 *
 * (c) Remco Speekenbrink <remco@speekkie.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rspeekenbrink\MonologMicrosoftTeams;

use Monolog\Logger;
use Monolog\Formatter\FormatterInterface;

/**
 * Teams record utility helping to log to the webhook.
 *
 * @author Remco Speekenbrink <remco@speekkie.nl>
 * @see    https://docs.microsoft.com/en-us/outlook/actionable-messages/message-card-reference
 */
class MicrosoftTeamsRecord
{
    const COLOR_DANGER = '#E81123';

    const COLOR_WARNING = '#FF8C00';

    const COLOR_GOOD = '#498205';

    const COLOR_DEFAULT = '#881798';

    /**
     * Title of the card
     * @var string|null
     */
    private $context;
    
    /**
     * Title of the card
     * @var string|null
     */
    private $title;

    /**
     * Title of the card
     * @var string|null
     */
    private $type;

    /**
     * @var FormatterInterface
     */
    private $formatter;

    public function __construct(
        $title = null,
        FormatterInterface $formatter = null,
        $type = "MessageCard",
        $context = "https://schema.org/extensions"
    ) {
        $this->title = $title;
        $this->formatter = $formatter;
        $this->type = $type;
        $this->context = $context;
    }

    /**
     * Convert the given record into a teams data array
     */
    public function getTeamsData(array $record)
    {
        $dataArray = array();

        if ($this->context) {
            $dataArray['@context'] = $this->context;
        }

        if ($this->type) {
            $dataArray['@type'] = $this->type;
        }

        if ($this->title) {
            $dataArray['title']  = $this->title;
        }

        if ($this->formatter) {
            $message = $this->formatter->format($record);
        } else {
            $message = $record['message'];
        }

        $dataArray['text'] = $message;

        return $dataArray;
    }

    /**
     * Returned a Teams theme color associated with
     * provided level.
     *
     * @param  int    $level
     * @return string
     */
    public function getThemeColor($level)
    {
        switch (true) {
            case $level >= Logger::ERROR:
                return self::COLOR_DANGER;
            case $level >= Logger::WARNING:
                return self::COLOR_WARNING;
            case $level >= Logger::INFO:
                return self::COLOR_GOOD;
            default:
                return self::COLOR_DEFAULT;
        }
    }

    /**
     * Sets the formatter
     *
     * @param FormatterInterface $formatter
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }
}

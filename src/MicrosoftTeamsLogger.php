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

class MicrosoftTeamsLogger extends Logger
{
    /**
     * @param $url
     * @param int $level
     * @param bool $bubble
     */
    public function __construct($url, $title = null, $level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct('microsoft-teams-logger');

        $handler = new MicrosoftTeamsHandler($url, $title, $level, $bubble);
        $handler->setFormatter(new MicrosoftTeamsFormatter());

        $this->pushHandler($handler);
    }
}

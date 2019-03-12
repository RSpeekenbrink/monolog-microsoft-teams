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

class MicrosoftTeamsChannel
{
    /**
     * @param array $config
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function __invoke(array $config)
    {
        return new MicrosoftTeamsLogger(
            $config['url'],
            $config['title'] ?? 'Monolog',
            $config['level'] ?? Logger::DEBUG,
            $config['bubble'] ?? true
        );
    }
}

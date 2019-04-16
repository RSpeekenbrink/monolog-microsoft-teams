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
use Monolog\Formatter\LineFormatter;

/**
 * Teams record utility helping to log to the webhook.
 *
 * @author Remco Speekenbrink <remco@speekkie.nl>
 * @see    https://docs.microsoft.com/en-us/outlook/actionable-messages/message-card-reference
 */
class MicrosoftTeamsFormatter extends LineFormatter
{
    public const SIMPLE_FORMAT = "[%datetime%] %level_name%: %message%\n";
}

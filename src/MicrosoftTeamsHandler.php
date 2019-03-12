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

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\Curl;
use Monolog\Formatter\FormatterInterface;
use Monolog\Logger;

/**
 * Sends notifications through Microsoft Teams Incoming Webhooks
 *
 * @author Remco Speekenbrink <remco@speekkie.nl>
 * @see    https://docs.microsoft.com/en-us/microsoftteams/platform/concepts/connectors/connectors-using
 */
class MicrosoftTeamsHandler extends AbstractProcessingHandler
{
    /**
     * Microsoft Teams Incoming Webhook token
     * @var string
     */
    private $webhookUrl;

    /**
     * Instance of the TeamsRecord util class preparing data for Teams Webhook.
     * @var MicrosoftTeamsRecord
     */
    private $teamsRecord;

    /**
     * @param  string      $webhookUrl             Microsoft Teams Webhook URL
     * @param  string      $title                  Title of the message card
     * @param  bool        $includeContextAndExtra Whether the attachment should include context and extra data
     * @param  int         $level                  The minimum logging level at which this handler will be triggered
     * @param  bool        $bubble                 Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct($webhookUrl, $title = null, $level = Logger::CRITICAL, $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->webhookUrl = $webhookUrl;

        $this->teamsRecord = new MicrosoftTeamsRecord(
            $title,
            $this->formatter
        );
    }

    public function getTeamsRecord()
    {
        return $this->teamsRecord;
    }

    public function getWebhookUrl()
    {
        return $this->webhookUrl;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $record
     */
    protected function write(array $record)
    {
        $postData = $this->teamsRecord->getTeamsData($record);
        $postString = json_encode($postData);

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $this->webhookUrl,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            CURLOPT_POSTFIELDS => $postString
        );
        if (defined('CURLOPT_SAFE_UPLOAD')) {
            $options[CURLOPT_SAFE_UPLOAD] = true;
        }

        curl_setopt_array($ch, $options);

        Curl\Util::execute($ch);
    }

    public function setFormatter(FormatterInterface $formatter)
    {
        parent::setFormatter($formatter);
        $this->teamsRecord->setFormatter($formatter);

        return $this;
    }

    public function getFormatter()
    {
        $formatter = parent::getFormatter();
        $this->teamsRecord->setFormatter($formatter);

        return $formatter;
    }
}

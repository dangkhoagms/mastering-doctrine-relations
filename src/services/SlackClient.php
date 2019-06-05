<?php


namespace App\services;


use Nexy\Slack\Client;
use Psr\Log\LoggerInterface;

class SlackClient
{
    /**
     * @var Client
     */
    private $slack;
    /**
     * @var LoggerInterface | null
     */
    private $logger;
    public function __construct(Client $slack)
    {
        $this->slack = $slack;
    }

    /**
     * @required
     */
    public function setLogger(LoggerInterface $logger){
        $this->logger  = $logger;
    }
    public function sendMessage(string $from, string $message){
        if($this->logger){
            $this->logger->info('Begin a message to Slack!!');
        }
        $slackMessage = $this->slack->createMessage()
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($message);
        $this->slack->sendMessage($slackMessage);

    }

}
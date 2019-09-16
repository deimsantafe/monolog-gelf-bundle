<?php

namespace STG\Bundle\MonologGELFBundle\Handler;

use Gelf\Message;
use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Monolog\Handler\AbstractHandler;
use Symfony\Component\HttpFoundation\RequestStack;

class MonologGELFHandler extends AbstractHandler
{

    private $gelfHost;
    private $gelfPort;
    private $requestStack;
    private $application;
    private $environment;
    private $gelfLevel;

    /**
     * MonologGELFHandler constructor.
     * @param $gelfHost
     * @param $gelfPort
     * @param $requestStack
     */
    public function __construct($gelfHost, $gelfPort, RequestStack $requestStack,
                                $application, $environment, $gelfLevel)
    {
        $this->gelfHost = $gelfHost;
        $this->gelfPort = $gelfPort;
        $this->requestStack = $requestStack;
        $this->application = $application;
        $this->environment = $environment;
        $this->gelfLevel = $gelfLevel;

        parent::__construct($gelfLevel);
    }


    /**
     * @param array $record
     * @return bool
     */
    public function handle(array $record)
    {
        try {
	    if (!$this->isHandling($record)) {
            	return false;
            }
            
            $dateTime = $record['datetime'];
            $message = $record['message'];
            $levelName = $record['level_name'];
            $channel = $record['channel'];
            $context = json_encode($record['context']);
            $file = array_key_exists('file', $record['context']) ? $record['context']['file'] : '';
            $line = array_key_exists('line', $record['context']) ? $record['context']['line'] : '';

            return $this->logMessage($dateTime, $message, $levelName, $channel, $context, $file, $line);

        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param $dateTime
     * @param $logMessage
     * @param $levelName
     * @param $channel
     * @param $context
     * @param string $file
     * @param string $line
     * @return bool
     */
    private function logMessage(\DateTime $dateTime, $logMessage, $levelName, $channel, $context, $file = '', $line = '')
    {

        $message = new Message();

        $message->setShortMessage("[$channel.$levelName] $logMessage")
            ->setLevel($this->getLogLevel($levelName))
            ->setFullMessage('[' . $channel . ']' . $logMessage . '[' . $context . ']')
            ->setFacility('')
            ->setFile($this->application . ' ' . $file)
            ->setLine($line)
            ->setHost($this->getRequestHost())
            ->setTimestamp($dateTime->getTimestamp())
            ->setVersion('1.1')
            ->setFile($file)
            ->setAdditional('environment', $this->environment)
            ->setAdditional('application', $this->application);

        $this->getPublisher()->publish($message);

        return true;
    }

    /**
     * @return Publisher
     */
    private function getPublisher()
    {
        $transport = new UdpTransport($this->gelfHost, $this->gelfPort, UdpTransport::CHUNK_SIZE_LAN);
        $publisher = new Publisher();

        $publisher->addTransport($transport);

        return $publisher;
    }

    /**
     * @param $levelName
     * @return string
     */
    private function getLogLevel($levelName)
    {
        return strtolower($levelName);
    }

    /**
     * @return string
     */
    private function getRequestHost()
    {
        try {

            if(!$this->getRequestStack()->getCurrentRequest()){
                throw new \Exception();
            }

            return $this->getRequestStack()->getCurrentRequest()->getHost();
            
        }catch (\Exception $exception){
            return $this->application;
        }
    }

    /**
     * @return RequestStack
     */
    public function getRequestStack()
    {
        return $this->requestStack;
    }
}

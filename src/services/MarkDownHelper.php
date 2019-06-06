<?php


namespace App\services;


use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkDownHelper
{
    private $markdown;
    private $adapter;
    private $logger;
    public function __construct(MarkdownInterface $markdown,AdapterInterface $adapter,LoggerInterface $markdownLogger)
    {

        $this->adapter = $adapter;
        $this->markdown = $markdown;
        $this->logger = $markdownLogger;
    }

    public  function parse(string $source):string
    {
        $this->logger->info("test logger");
        $item = $this->adapter->getItem('markdown_'.md5($source));
        if(!$item->isHit()){
            $item->set($this->markdown->transform($source));
            $this->adapter->save($item);
        }
        return $item->get();
    }
}

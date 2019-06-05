# symfony-fundamentals
# Symfony 4 Fundamentals: Services, Config & Environments Tutorial
# NOTE
### AdapterInterface
##### get data from cache: 
    $item = $adapter→getItem('markdown_'.md5($articleContent));
    $item→get() : return data.
##### Save data to cache: 
    $item->set($markdown->transform($articleContent)); $adapter->save($item);
### Change cache.yaml
enabled cache.adapter.apcu
config .env :APP_ENV=prod
=> cache no rebuild 
### Create service
 create folder container [Services]
 create class [service] have __construct
 create function
### working LoggerInterface: 
### Register with create file log
##### add code before block main in file dev/monolog.yaml
    
    markdown_loggin: 
	    type: stream path: "%kernel.logs_dir%/markdown.log" l
	    level: debug 
	    channels: ["markdown"]


#### create monolog.yaml and paste code
    monolog: 
	    channels: ['markdown'
#### register with services.yaml
#### 1
    App\services\MarkDownHelper:
	    arguments:
		    $logger: '@monolog.logger.markdown'

#### other #2: using bind block _defaults:
    bind: 
	    $markdownLogger: '@monolog.logger.markdown'
    
#### important: 
    file [service] change LoggerInterface variable to  $markdownLogger
### Parameter in yaml file
    parameters: 
	    cache_adapter: 'cache.adapter.apcu'
using  ‘%cache_adapter%’
### Bind no working controller
    https://symfonycasts.com/screencast/symfony-fundamentals/controller-constructor#play
in video, it’s work through __contruct() .
But now it’s working good.!!!  
### Env global
Yaml file using %env(name)%
Php file using $_SERVER[‘name’])
### LoggerTrait & Setter Injection
    /** * @var LoggerInterface | null */ 
    private $logger;
    /** 
    * @required
    */ 
    public function setLogger(LoggerInterface $logger){ 
	    $this->logger = $logger; 
    }
### Fun with Commands
    $input → getArgument(‘name’);
# SCRIPT
### clear cache:
    bin/console cache:clear
### view config:dump
    bin/console config:dump KnpMarkdownBundle
### debug:container
    bin/console debug:container –show-private
### debug:container log
    bin/console debug:container monolog.logger
### Make:command
    bin/console make:command
### Install lib knp-markdown-bundle
    composer require knplabs/knp-markdown-bundle

#DOCUMENT
link
    https://github.com/KnpLabs/KnpMarkdownBundle	

### Group webhook
    https://cta-55o1219.slack.com/messages/DKBDU8DB9/files/UK388UA7K/
### Git code
##### HTTPS: 
    https://github.com/dangkhoagms/symfony-fundamentals.git
##### SSH: 
    git@github.com:dangkhoagms/symfony-fundamentals.git
       
### Fix errror APCU no enabled

    sudo add-apt-repository ppa:ondrej/php 
    sudo apt-get update 
    sudo apt-get install php-apcu-bc

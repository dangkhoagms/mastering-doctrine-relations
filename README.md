# symfony-fundamentals
       Symfony 4 Fundamentals: Services, Config & Environments Tutorial
    I. NOTE
1. AdapterInterface
get data from cache: 
$item = $adapter→getItem('markdown_'.md5($articleContent));
$item→get() : return data.
Save data to cache: 
$item->set($markdown->transform($articleContent)); $adapter->save($item);
2. change cache.yaml
enabled cache.adapter.apcu
config .env :APP_ENV=prod
=> cache no rebuild 
3. create service
 create folder container [Services]
 create class [service] have __construct
 create function
4.  working LoggerInterface: 
5. Register with create file log:
    (1) add code before block main in file dev/monolog.yaml:
markdown_loggin: 
	type: stream path: "%kernel.logs_dir%/markdown.log" l
	level: debug 
	channels: ["markdown"]


    (2) create monolog.yaml and paste code
monolog: 
	channels: ['markdown'
    (3) register with services.yaml
#1: 
 App\services\MarkDownHelper:
	arguments:
		$logger: '@monolog.logger.markdown'

other #2: using bind block _defaults:
bind: 
	$markdownLogger: '@monolog.logger.markdown'
important: file [service] change LoggerInterface variable to  $markdownLogger
6. Parameter in yaml file
parameters: 
	cache_adapter: 'cache.adapter.apcu'
using  ‘%cache_adapter%’
7. Bind no working controller
https://symfonycasts.com/screencast/symfony-fundamentals/controller-constructor#play
in video, it’s work through __contruct() .
But now it’s working good.!!!  
8. Env global
Yaml file using %env(name)%
Php file using $_SERVER[‘name’])
9.LoggerTrait & Setter Injection
/** * @var LoggerInterface | null */ 
private $logger;
/** 
* @required
*/ 
public function setLogger(LoggerInterface $logger){ 
	$this->logger = $logger; 
}
11.Fun with Commands
$input → getArgument(‘name’);
    II. SCRIPT
1. clear cache:
bin/console cache:clear
2. view config:dump
bin/console config:dump KnpMarkdownBundle
3. debug:container
bin/console debug:container –show-private
4.debug:container log
bin/console debug:container monolog.logger
5.Make:command
bin/console make:command
6.Install lib knp-markdown-bundle
composer require knplabs/knp-markdown-bundle

    III. DOCUMENT
       https://github.com/KnpLabs/KnpMarkdownBundle	

    1. Group webhook
https://cta-55o1219.slack.com/messages/DKBDU8DB9/files/UK388UA7K/
    2. Git code
HTTPS: https://github.com/dangkhoagms/symfony-fundamentals.git
       SSH: git@github.com:dangkhoagms/symfony-fundamentals.git

       

    3. Fix errror APCU no enabled

sudo add-apt-repository ppa:ondrej/php 
       sudo apt-get update 
       sudo apt-get install php-apcu-bc

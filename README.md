### Symfony 4 learning - Different series:

- First series is https://knpuniversity.com/screencast/symfony
- Second series is https://knpuniversity.com/screencast/symfony-fundamentals

### FIRST TUTORIAL SERIES
- Stellar Development with Symfony 4
- https://knpuniversity.com/screencast/symfony

### 1) Setup project

- To create the skeleton symfony framework:

```$ composer create-project symfony/skeleton symfony-4-learning```

- After the installation of my dependencies (which includes several symfony 'recipes'), I was informed:

```$ Run composer require server --dev for a better web server.```

- So I did. To launch the 'better' web server, run

```$ php -S 127.0.0.1:8000 -t public```

### 2) Create a route via routes.yaml

- Went to config > routes.yaml and configured:

```
    index:
       path: /
       controller: App\Controller\PlayersController::getPlayerAction
```
       
- Above says - 'when someone goes to the homepage (/), symfony should execute a 'getPlayerAction' function in the PlayersController class
- So then created a PlayersController class and in it, a 'getPlayerAction' function
- NOTE - All controllers must return an HTTP Foundation Response
- So when I then launched the web server and hit '127.0.0.1:8000/', the code within that function was called.

- There's probably a nicer way to configure routing, without having to use the config > routes.yaml.
- That is by using annotations

### 3) Create a route with annotations

- First, install it:

```$ composer require annotations```

- Interestingly, this require of 'annotations' actually installs 'sensio/framework-extra-bundle'...more on that later
- Next, I will comment out the route I added above (in the config > routes.yaml file)
- And then I'll add the @Route annotation in my PlayersController and try to load the page again.
- Boom, works

### 4) Flex aliases and recipes

- We are now going to install a new library, not so much to use it in here, but to demonstrate the recipe system:

```$ composer require sec-checker --dev```

- Of course, 'sec-checker' does not follow the standard pattern of installing a library with composer.
- Normally, it would look something like... 'composer require sensiolabs/security-checker'
- So how is 'sec-checker' working then?

- If we take a look in the composer.json, within the 'require' section there is a library called 'symfony/flex'. 
- This was there when we created the skeleton project right at the beginning.
- Flex is a composer plugin with 2 super powers:
    1) The alias system. Let's go to symfony.sh in a web browser and search for security. See the 'Aliases' of each library...
    So based on the alias 'sec-check', we are actually installing 'sensiolabs/security-checker'
    2) Recipes. So when we ran the 'composer install sec-checker --dev' above...composer outputted in the console:
    
    ```
        Symfony operations: 1 recipe (<SHA_ID>)
        Configuring sensiolabs/security-checker (>=4.0): From github.com/symfony/recipes:master
    ```

    - What does that mean? What's a recipe?
    - Run 'git status'...along with changes to the composer.json and composer.lock files, there is also a 'symfony.lock' file
    and we suddenly have a brand new config file 'config/packages/security_checker.yaml'.
    - 'symfony.lock' is managed by flex and keeps track of which recipes have been installed.
    - the second file, 'config/packages/security_checker.yaml', was added by the recipe and this will now allow us to run a new bin/console command - 'bin/console security:check'
    - So to summarise - whenever you install a package, flex will execute the recipe for that package if one exists. 
    Recipes can add configuration files, create directories or even modify files (e.g. gitignore) so that the library 
    instantly works without any other setup. Pretty cool.
    - And one other thing about the sec-checker (and recipes in general)...if we look in the composer.json file, 
    as well as the addition of the security-checker package, there is also a new script! The recipe added a new script!
    
    ```
        "scripts": {
            "auto-scripts": {
                "cache:clear": "symfony-cmd",
                "assets:install --symlink --relative %PUBLIC_DIR%": "symfony-cmd",
                "security-checker security:check": "script"
            }...
    ```
    
    - So when we next run a composer install, when it finishes, it runs the security-check script automatically.
    - Note - flex is also clever enough to uninstall recipe(s) when you remove a package

- Where do the recipes live? All in github. Go back to symfony.sh and click on the 'Recipe' icon for a given package.

### 5) Twig tutorials

- Not going to make too many notes on this.
- Twig is used to return HTML
- Ran a 'composer require twig' and several files were added / modified. One that was modified was 'config>bundles.php'
- Bundles are the plugin system for symfony. Whenever we install a third party bundle, flex adds it into 'config>bundles.php'
so that it is used automatically
- Created a very basic TwigDemoController

### 6) Profiler (aka the web debug toolbar)

- Ran a 'composer require profiler --dev' and a few things were installed
- Run the web server and go to 'http://127.0.0.1:8000/twig/demo' (which renders an HTML template)
- When the page loads, I can see a little toolbar at the bottom of the page - each icon in the toolbar is packed with info
- When you click on one of the icons, you can go into it even further and view more detailed analysis
- This web debug toolbar / profiler is automatically injected at the bottom of any valid HTML page during development
- The profiler also installed symfony's 'var dumper' component
- So now, instead of using var_dump during development, you can instead use dump(). 
- Pretty nice, adds coloured output (I've added to the twig demo controller + also in the base.html.twig template)

### 7) Debugging and Packs

- Symfony has even more debugging tools
- Easiest way to get all of them ```$ composer require debug --dev```
- Installs one 'pack' that consists of a composer.json (which will then in turn install another e.g. 5 packages)
- An example - https://packagist.org/packages/symfony/debug-pack (https://github.com/symfony/debug-pack)
- But packs have a downside too. If you want to control the version of one of the 5 packages, how do you do this? 
- The only way to date is to 'unpack' the pack and then configure each package separately
- To do this, run ```$ composer unpack debug```
- This command removes the 'debug-pack' from the composer files but you can then see that the debug-pack's 6 packages have been 
 added to the composer files. So now if you want to customise the version of one of those packages, you can. 

### 8) Assets: CSS & JavaScript

- Not making notes on this.

### 9) Route names

- Running a ```bin/console debug:router``` will give you a list of all the routes in your application:

```
 -------------------------- -------- -------- ------ ----------------------------------- 
  Name                       Method   Scheme   Host   Path                               
 -------------------------- -------- -------- ------ ----------------------------------- 
  app_players_getplayer      ANY      ANY      ANY    /players/{name}                    
  app_twigdemo_gettwigdemo   ANY      ANY      ANY    /twig/demo                         
  _twig_error_test           ANY      ANY      ANY    /_error/{code}.{_format}           
  _wdt                       ANY      ANY      ANY    /_wdt/{token}                      
  _profiler_home             ANY      ANY      ANY    /_profiler/                        
  _profiler_search           ANY      ANY      ANY    /_profiler/search                  
  _profiler_search_bar       ANY      ANY      ANY    /_profiler/search_bar              
  _profiler_phpinfo          ANY      ANY      ANY    /_profiler/phpinfo                 
  _profiler_search_results   ANY      ANY      ANY    /_profiler/{token}/search/results  
  _profiler_open_file        ANY      ANY      ANY    /_profiler/open                    
  _profiler                  ANY      ANY      ANY    /_profiler/{token}                 
  _profiler_router           ANY      ANY      ANY    /_profiler/{token}/router          
  _profiler_exception        ANY      ANY      ANY    /_profiler/{token}/exception       
  _profiler_exception_css    ANY      ANY      ANY    /_profiler/{token}/exception.css   
 -------------------------- -------- -------- ------ ----------------------------------- 
```

- The 2 routes I've created so far are at the top (along with a load of other profiler ones)
- Each route has an internal name which is never shown to the user
- These exist so that we can refer to them in our code
- e.g. app_players_getplayer and app_twigdemo_gettwigdemo
- In the 'generating urls' video, he adds the internal name to the twig template. ```href="{{ path('app_players_getplayer') }}"```
- For annotation routes, the internal name is created automatically for us
- However, if we want to configure the name ourselves, we can add a 'name' key in the annotation (I've done so in the PlayersController)
- The internal name now changes from app_players_getplayer to app_players

### 10) JavaScript API video

- Using the PHP annotations, you can also specify the method type of a route, e.g. GET, POST etc.
- Take a look in PlayersController for an example - getPlayerAction - I've added a GET method in the annotation
- So now, when I run a ```bin/console debug:router```, I see that the Method column now has GET for that particular route

```
 -------------------------- -------- -------- ------ ----------------------------------- 
  Name                       Method   Scheme   Host   Path                               
 -------------------------- -------- -------- ------ ----------------------------------- 
  app_players                GET      ANY      ANY    /players/{name}                    
  app_twigdemo_gettwigdemo   ANY      ANY      ANY    /twig/demo                         
  _twig_error_test           ANY      ANY      ANY    /_error/{code}.{_format}           
  _wdt                       ANY      ANY      ANY    /_wdt/{token}                      
  _profiler_home             ANY      ANY      ANY    /_profiler/                        
  _profiler_search           ANY      ANY      ANY    /_profiler/search                  
  _profiler_search_bar       ANY      ANY      ANY    /_profiler/search_bar              
  _profiler_phpinfo          ANY      ANY      ANY    /_profiler/phpinfo                 
  _profiler_search_results   ANY      ANY      ANY    /_profiler/{token}/search/results  
  _profiler_open_file        ANY      ANY      ANY    /_profiler/open                    
  _profiler                  ANY      ANY      ANY    /_profiler/{token}                 
  _profiler_router           ANY      ANY      ANY    /_profiler/{token}/router          
  _profiler_exception        ANY      ANY      ANY    /_profiler/{token}/exception       
  _profiler_exception_css    ANY      ANY      ANY    /_profiler/{token}/exception.css   
 -------------------------- -------- -------- ------ ----------------------------------- 
```

### 11) Services

- Going to start by looking at logging.
- Run ```tail -f var/log/dev.log```
- Then, when I call the getPlayerAction route, 'http://127.0.0.1:8000/players/harrykane'..., some logs are added in the console (and also to var/log/dev.log):

```
[2018-06-14 07:51:51] request.INFO: Matched route "app_players". {"route":"app_players","route_parameters":{"_controller":"App\\Controller\\PlayersController::getPlayerAction","name":"harrykane","_route":"app_players"},"request_uri":"http://127.0.0.1:8000/players/harrykane","method":"GET"} []
```

- So somewhere, symfony has some magic (out of the box) that logs some info when we call a route.
- Next, let's add some of our own custom logging.
- So, I have added a LoggerInterface as an argument into the 'getPlayerAction' controller function (different to symfony 3 I think), 
and then logged some more information. When I called the route again, I saw the below in the logs:

```
[2018-06-14 07:59:59] app.INFO: Someone is calling the getPlayerAction endpoint [] []
```

- Before symfony executes our controller, it looks at each argument. 
- So for '$logger', symfony looks at the type hint (LoggerInterface) and realises that we want symfony to pass us a logger object.
- The order of the arguments does not matter.
- **This concept is known as autowiring.**
- So if you need a service object in the controller, you just need to know the correct type hint to use
- So how do I know which services are available to me then?
- Run:

```
bin/console debug:autowiring
```

- The following is outputted:

```
Autowirable Services
====================

 The following classes & interfaces can be used as type-hints when autowiring:

 --------------------------------------------------------------------------
  App\Controller\PlayersController
  App\Controller\TwigDemoController
  App\Services\PlayerService
  Doctrine\Common\Annotations\Reader
      alias to annotations.cached_reader
  EasyCorp\EasyLog\EasyLogHandler
  Psr\Cache\CacheItemPoolInterface
      alias to cache.app
  Psr\Container\ContainerInterface
      alias to service_container
  Psr\Log\LoggerInterface
      alias to monolog.logger
  SensioLabs\Security\Command\SecurityCheckerCommand
  SensioLabs\Security\SecurityChecker
  SessionHandlerInterface
      alias to session.handler
  Symfony\Bundle\FrameworkBundle\Controller\RedirectController
  Symfony\Bundle\FrameworkBundle\Controller\TemplateController
  Symfony\Component\Cache\Adapter\AdapterInterface
      alias to cache.app
  Symfony\Component\DependencyInjection\ContainerInterface
      alias to service_container
  Symfony\Component\EventDispatcher\EventDispatcherInterface
      alias to debug.event_dispatcher
  Symfony\Component\Filesystem\Filesystem
      alias to filesystem
  Symfony\Component\HttpFoundation\RequestStack
      alias to request_stack
  Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface
      alias to session.flash_bag
  Symfony\Component\HttpFoundation\Session\SessionInterface
      alias to session
  Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface
      alias to session.storage.native
  Symfony\Component\HttpKernel\Config\FileLocator
      alias to file_locator
  Symfony\Component\HttpKernel\Debug\FileLinkFormatter
      alias to debug.file_link_formatter
  Symfony\Component\HttpKernel\HttpKernelInterface
      alias to http_kernel
  Symfony\Component\HttpKernel\KernelInterface
      alias to kernel
  Symfony\Component\Routing\Generator\UrlGeneratorInterface
      alias to router.default
  Symfony\Component\Routing\Matcher\UrlMatcherInterface
      alias to router.default
  Symfony\Component\Routing\RequestContext
      alias to router.request_context
  Symfony\Component\Routing\RequestContextAwareInterface
      alias to router.default
  Symfony\Component\Routing\RouterInterface
      alias to router.default
  Symfony\Component\Stopwatch\Stopwatch
      alias to debug.stopwatch
  Twig\Environment
      alias to twig
  Twig_Environment
      alias to twig
 --------------------------------------------------------------------------
```

- Along with a load of default services (e.g. LoggerInterface, UrlMatcherInterface), I can also access PlayerService too (my own custom service class)


### SECOND TUTORIAL SERIES
- Symfony 4 Fundamentals - Services, Config & Environments
- https://knpuniversity.com/screencast/symfony-fundamentals

### 1) Bundles give you services

- A service is an object that does work.
- When we do an e.g. LoggerInterface in the getPlayerAction function...where does it come from? Where do the service objects come from?
- Every service is stored in the container
- And what puts these services into the container? The answer is bundles (check out the config>bundles.php)
- Bundles are symfony's plugin system
- Symfony is really nothing more than a collection of services
- Bundles are what actually prepare those service objects and put them into the container
- Bundles have 1 main job - they give you services

### 2) KNP Markdown bundle and its services

- In the videos, he loads a page
- His goal - he wants the article body to be processed through markdown
- He installs the KNP markdown bundle:

```
composer require knplabs/knp-markdown-bundle
```

(At this point, I switched from watching the videos to reading the documentation / transcript that came with the course)

- This automatically adds a row within bundles.php

```
Knp\Bundle\MarkdownBundle\KnpMarkdownBundle::class => ['all' => true]
```

- Then when I run a...

```bin/console debug:autowiring```

...I can see 2 new services available to me:

```
  Knp\Bundle\MarkdownBundle\MarkdownParserInterface                         
      alias to markdown.parser.max                                          
  Michelf\MarkdownInterface                                                 
      alias to markdown.parser.max   
```

- He then injects the 'MarkdownInterface' into a controller - autowiring
- Things to take away from this section:
1. Everything in Symfony is done by a service
2. Bundles give us these services... and installing new bundles gives us more services.

### 3) The Cache Service

- Comes with symfony out of the box
- Run:

```bin/console debug:autowiring```

- We can see:

```
Psr\Cache\CacheItemPoolInterface                                          
      alias to cache.app  
      
      and further down...
      
Symfony\Component\Cache\Adapter\AdapterInterface                          
      alias to cache.app 
```

- Both are aliases to cache.app
- Internally, each service has a unique name, or "id", just like routes. The internal id for Symfony's cache service is 
cache.app. If you see two entries that are both aliases to the same service, it means that you can use either type 
hint (for autowiring) to get the exact same object. Both CacheItemPoolInterface and AdapterInterface will cause the 
exact same object to be passed to you.

- I've created a CacheController to give a little demo...nice and simple :-)
- Next question - where is it saving the cache files? And more importantly, what if I need to change the cache service 
to save the cache somewhere else, like Redis? That's coming next...

### 4) Configuring a Bundle

- Every bundle is configurable within yaml files
- But how do I find out all the configuration options for a bundle (without having to trawl through all the documentation)?
- Run:

```bin/console config:dump <bundle_name>```
```bin/console config:dump KNPMardownBundle```

- The below is printed to the console:

```
# Default configuration for "KnpMarkdownBundle"
knp_markdown:
    parser:
        service:              markdown.parser.max
    sundown:
        extensions:
            fenced_code_blocks:   false
            no_intra_emphasis:    false
            tables:               false
            autolink:             false
            strikethrough:        false
            lax_html_blocks:      false
            space_after_headers:  false
            superscript:          false
        render_flags:
            filter_html:          false
            no_images:            false
            no_links:             false
            no_styles:            false
            safe_links_only:      false
            with_toc_data:        false
            hard_wrap:            false
            xhtml:                false
```

- Boom! Say hello to a big YAML example of all of the config options for this bundle. Sometimes, the keys are self-explanatory. 
But other times - you'll want to cross-reference this with the bundle's docs to find out more. In this case, down 
below on the docs, it tells us that the bundle ships with a number of different parsers: it looks like it defaults 
to this "max" parser: fully-featured, but a bit slow.

- Let's try to change to the "light" parser
- Look in the config/ directory and then packages/ . Create a new file called knp_markdown.yaml. Then, copy the 
configuration, paste it here and change the service to the one from the docs: markdown.parser.light

```
knp_markdown:
  parser:
    service: markdown.parser.light
```

- After we've added new config, we must always run a:

```bin/console cache:clear```

- This...is a bummer. Normally, Symfony is smart-enough to rebuild its cache whenever we change a config file. But...
there's currently a bug in Symfony where it does not notice new config files. So, for now, we need to do this on the 
rare occasion when we add a new file to config. It should be fixed soon.

- So...what did this config change...actually...do? Well, because the purpose of a bundle is to give us services, 
the purpose of configuring a bundle is to change how those services behave. That might mean that a service will suddenly 
use a different class, or that different arguments are passed to a service object. As a user, it doesn't really matter 
to us: the bundle takes care of the ugly details.

- He does a little bit of magic in the video and can now see the markdown parser as an instance of Light and not Max.
- I.e. the configuration changes have worked.

- Now: why did I put this in a file named knp_markdown.yaml? Is that important? Actually, no! As we'll learn soon, 
Symfony automatically loads all files in packages/, and their names are meaningless, technically!
- The super important part is the root - meaning, non-indented - key: knp_markdown. 
- Each file in packages/ configures a different bundle. Any configuration under knp_markdown is passed to the 
KnpMarkdownBundle. Any config under framework configures FrameworkBundle, which is Symfony's one, "core" bundle (see framework.yaml)

- Every bundle has its own set of valid config.

### 5) debug:container & cache config

- Remember: all services live inside an object called the container. And each has an internal name, or id.
- The 'markdown.parser.light' key we have in our knp_markdown.yaml is the id of a service in the container.
- With this config, we're telling the bundle that when we ask for the Markdown parser e.g. in the controller, 
it should now pass us the service that has this id.

- Interesting - when we run a...

```bin/console debug:autowiring```

...this is not a full list of all of the services in the container...

- But when we run this...

```bin/console debug:container --show-private```

...this is actually the full list of the many services in the container. 

```

Symfony Container Services
==========================

 -------------------------------------------------------------------------- ----------------------------------------------------------------------------------------
  Service ID                                                                 Class name
 -------------------------------------------------------------------------- ----------------------------------------------------------------------------------------
  App\Controller\CacheController                                             App\Controller\CacheController
  App\Controller\PlayersController                                           App\Controller\PlayersController
  App\Controller\TwigDemoController                                          App\Controller\TwigDemoController
  App\Services\PlayerService                                                 App\Services\PlayerService
  Doctrine\Common\Annotations\Reader                                         alias for "annotations.cached_reader"
  EasyCorp\EasyLog\EasyLogHandler                                            EasyCorp\EasyLog\EasyLogHandler
  Knp\Bundle\MarkdownBundle\MarkdownParserInterface                          alias for "markdown.parser.light"
  Michelf\MarkdownInterface                                                  alias for "markdown.parser.light"
  Psr\Cache\CacheItemPoolInterface                                           alias for "cache.app"
  Psr\Container\ContainerInterface                                           alias for "service_container"
  
  ...

```

- Most of the time, the services you'll actually need to use will be shown after you run:

```bin/console debug:autowiring```

- But you can see EVERYTHING available to you (including the boring internal services that you might not use) after running:

```bin/console debug:container --show-private```

- Big takeaways:

1. There are many services in the container and each has an id.
2. The services you'll use 99% of the time show up in debug:autowiring and are easy to access.

###Configuring the cache object:

- If we were to var_dump the $cache variable in our CacheController, the below would be printed:

```
CacheController.php on line 23:
TraceableAdapter {#674 ▼
  #pool: FilesystemAdapter {#668 ▼
    -createCacheItem: Closure {#670 ▶}
    -mergeByLifetime: Closure {#673 ▶}
    -namespace: ""
    -namespaceVersion: ""
    -versioningIsEnabled: false
    -deferred: []
    #maxIdLength: null
    #logger: Logger {#513 ▶}
    -directory: "/Users/richardchernanko/Development/symfony-4-learning/var/cache/dev/pools/67C7vxtLAk/"
    -tmp: null
  }
  -calls: []
}
``` 

- The $cache object is something called a TraceableAdapter and, inside, a FileSystemAdapter...
- Our cache is being saved to the filesystem... and we can even see where in var/cache/dev/pools...
- So... how can we configure the cache service? Of course, the easiest answer is just to Google its docs. But, we don't 
even need to do that! The cache service is provided by the FrameworkBundle, which is the one bundle that came 
automatically with our app.

###Debugging your Current Config:
 
- So, first thing, if we run a...

```bin/console config:dump framework```

...this tells gives us all the possible config we could put in the framework bundle configuration file (framework.yaml).

- Now let's run a...

```bin/console debug:config framework```

- Instead of dumping example config, this is our current config.
- Under cache, there are 6 configured keys:
 
```
    cache:
        app: cache.adapter.filesystem
        system: cache.adapter.system
        directory: /Users/richardchernanko/Development/symfony-4-learning/var/cache/dev/pools
        default_redis_provider: 'redis://localhost'
        default_memcached_provider: 'memcached://localhost'
        pools: {  }
```

- But, you won't see all of these in framework.yaml - instead these are the bundle's default values. 
- And you can see that this app key is set to cache.adapter.filesystem

### Changing to an APCu Cache:

- The docs in framework.yaml tell us that if we want to change the cache system, app is the key we want. 
- Let's uncomment the last one to set app to use APCu: an in-memory cache that's not as awesome as Redis, but easier to 
install (i'm not actually going to do it but could do via the below):

```
    cache:
        # APCu (not recommended with heavy random-write workloads as memory fragmentation can cause perf issues)
        app: cache.adapter.apcu
```

- And just like with markdown, cache.adapter.apcu is a service that already exists in the container.
- Ok, go back and refresh! Yes! The cache is now using an APCuAdapter internally!

- Very useful - Running ```./bin/console cache:clear``` clears Symfony's internal cache that helps your app run. 
- But, it purposely does not clear anything that you store in cache. If you want to clear that, run:
 ```bin/console cache:pool:clear cache.app```.

### 6) Explore! Environments & Config Files

- We know that Symfony is really just a set of routes and a set of services. 
- And we also know that the files in config/packages configure those services. 
- But, who loads these files? And what is the importance - if any - of these sub-directories?

- The code that runs our app is like a machine. 
- The machine always does the same work, but... it needs some configuration in order to do its job. E.g. where to write 
log files or what the database name and password are.
- And there's other config too, like whether to log all messages or just errors, or whether to show a big beautiful 
- exception page - which is great for development - or something aimed at your end-users. 
- Key point - the behavior of your app can change based on its config.
- Symfony has an awesome way of handling this called 'environments'. 
- It has two environments out-of-the-box: dev and prod. 
- In the dev environment, Symfony uses a set of config that's... well... great for development: big errors, log 
everything and show me the web debug toolbar. 
- The prod environment uses a set of config that's optimized for speed, only logs errors, and hides technical info on error pages.

### How Environments Work:

- Let's have a look at public/index.php
- This is the front controller: a fancy word to mean that it is the first file that's executed for every page. 
- You don't normally worry about it, but... it's kind of interesting. It's looking for an environment variable called APP_ENV
- The $env variable is then passed into some Kernel class! 
- The APP_ENV variable is set in a .env file, and right now it's set to dev.
- Anyways, the string 'dev' - is being passed into a Kernel class. The question is... what does that do?

### Debugging the Kernel Class:

- That Kernel class is not some core part of Symfony. Nope, it lives right inside our app! 
- Open src/Kernel.php.
- Let's look at the registerBundles() function:

```
    public function registerBundles()
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                yield new $class();
            }
        }
    }
```

- The above is what loads the config/bundles.php file:

```

<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Symfony\Bundle\WebServerBundle\WebServerBundle::class => ['dev' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
    Symfony\Bundle\DebugBundle\DebugBundle::class => ['dev' => true, 'test' => true],
    Knp\Bundle\MarkdownBundle\KnpMarkdownBundle::class => ['all' => true],
];

```

- And check this out: some of the bundles are only loaded in specific environments.
- Like, the WebServerBundle is only loaded in the dev environment
- And the DebugBundle is similar. Most are loaded in all environments.

- The other two important functions in src/Kernel.php are configureContainer (which basically means "configure services")
and configureRoutes() 

### Package File Loading:

- Within configureContainer there is the following:

```
$loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
$loader->load($confDir.'/{packages}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
```

- This loads all the files that live within the packages folder
- Notice the second line in the above. It attempts to load files within e.g. the package/dev directory i.e. environment specific
- Note that any overlapping config in the environment-specific files override those from the main files in packages/

- Note that within the packages directory, the names of the files are not important...at all. 
- One could be called hal9000.yaml and not change a thing. 
- The important part is the root key, which tells Symfony which bundle is being configured.
- Usually, the filename matches the root key... but, it doesn't have to. 
- The organization of these files is subjective: it's meant to make as much sense as possible. 
- The routing.yaml file actually configures something under the 'framework' key.
- My big point is this: all of these files are really part of the same configuration system and, technically, their 
contents could be copied into one giant file called my_big_old_config_file.yaml

- Going back to the configureContainer function (within src/Kernel.php), the next few lines are:

```
$loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
$loader->load($confDir.'/{services}_'.$this->environment.self::CONFIG_EXTS, 'glob');
```

- So the last files that are loaded are the services file + again, just like the packages above, you can have 
environment-specific service files
- More on that later

### Route Loading:

- Within the src/Kernel.php file, there is also a configureRoutes function:

```
protected function configureRoutes(RouteCollectionBuilder $routes)
{
    $confDir = $this->getProjectDir().'/config';
    
    $routes->import($confDir.'/{routes}/*'.self::CONFIG_EXTS, '/', 'glob');
    $routes->import($confDir.'/{routes}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, '/', 'glob');
    $routes->import($confDir.'/{routes}'.self::CONFIG_EXTS, '/', 'glob');
}
```

- It's pretty much the same as packages and services: it automatically loads everything from the config/routes 
directory and then looks for an environment-specific subdirectory
- So, all of the files inside config/ either configure services or configure routes. No biggie.

### 7) Leveraging the prod Environment

- Up until this point, we've always been in the 'dev' envioronment.
- To change to prod, just modify the .env file 

```
APP_ENV=prod
```

- One big difference between the dev and prod environments is that in the prod environment, the internal Symfony 
cache is not automatically rebuilt. That's because the prod environment is wired for speed.
- In practice, this means that whenever you want to switch to the prod environment... like when deploying... 
you need to run the ```bin/console cache:clear``` command
- The bin/console file also reads the .env file, so it knows we're in the prod environment.
- And now when we refresh the browser, we no longer see the web debug toolbar. 
- And if you go to a fake page, you get a very boring error page (which can be customised). 
- The point is, this is not a big development exception page anymore.

###The dev and prod Cache Directories

- Check out the var/cache directory. 
- Each environment has its own cache directory: dev and prod. 
- When you run cache:clear, it basically just clears the directory and recreates a few files.
- But of course, when the first requests come in, the cache is cleared + so initial requests may be a little slower.
- There is another command that can be run, ```bin/console cache:warmup```
- This goes a step further and creates all of the cache files that Symfony will ever need. 
- By running this command when you deploy, the first requests will be much faster.
 
### 8) Creating Services!

- Have created a 'Service' directory within /src
- Have added a PlayerService class
- Because of our autowiring settings in config>services, the service class is automatically available for me
to use in e.g. the PlayersController
- When we run ```bin/console debug:autowiring```, we should see PlayerService available for us to use:

```
Autowirable Services
   ====================
   
    The following classes & interfaces can be used as type-hints when autowiring:
   
    --------------------------------------------------------------------------
     App\Controller\CacheController
     App\Controller\PlayersController
     App\Controller\TwigDemoController
     App\Services\PlayerService
```

- So that's how you create services and ensure they are available for autowiring
- Next, let's find out how we can access core services that CANNOT be autowired
 
### 9) Using Non-Standard Services: Logger Channels

- Within our PlayersController, we are using LoggerInterface as an argument in the action function.
- When you run a ```bin/console debug:autowiring```, the output says that LoggerInterface is an alias to monolog.logger
- 'monolog.logger' is the id of the service that is being passed to us
- You can actually get a little bit more info about a service by running:
```bin/console debug:container monolog.logger```

- The results:

```
Information for Service "monolog.logger"
========================================

 ---------------- ----------------------------------------------------
  Option           Value
 ---------------- ----------------------------------------------------
  Service ID       monolog.logger
  Class            Symfony\Bridge\Monolog\Logger
  Tags             -
  Calls            useMicrosecondTimestamps, pushHandler, pushHandler
  Public           no
  Synthetic        no
  Lazy             no
  Shared           yes
  Abstract         no
  Autowired        no
  Autoconfigured   no
 ---------------- ----------------------------------------------------
```

- Anyway, we normally use debug:container to list all of the services in the container. But we can also get a filtered 
list. Let's find all services that contain the word "log":

```bin/console debug:container --show-private log```

- The results:

```
 Select one of the following services to display its information:
  [0 ] monolog.logger
  [1 ] monolog.logger_prototype
  [2 ] monolog.activation_strategy.not_found
  [3 ] monolog.handler.fingers_crossed.error_level_activation_strategy
  [4 ] monolog.formatter.chrome_php
  [5 ] monolog.formatter.gelf_message
  [6 ] monolog.formatter.html
  [7 ] monolog.formatter.json
  [8 ] monolog.formatter.line
  [9 ] monolog.formatter.loggly
  [10] monolog.formatter.normalizer
  [11] monolog.formatter.scalar
  [12] monolog.formatter.wildfire
  [13] monolog.formatter.logstash
  [14] monolog.processor.psr_log_message
  [15] monolog.handler.main.not_found_strategy
  [16] monolog.handler.main
  [17] monolog.handler.nested
  [18] monolog.handler.console
  [19] monolog.logger.request
  [20] monolog.logger.console
  [21] monolog.logger.cache
  [22] monolog.logger.php
  [23] monolog.logger.router
  [24] monolog.handler.null_internal
  [25] logger
  [26] Psr\Log\LoggerInterface
```

- There are about 6 services that we're really interested in: these 'monolog.logger.{something}' services
e.g. monolog.logger.cache

###Logging channels

- Here's what's going on. Symfony uses a library called 'Monolog' for logging. And Monolog has a feature called channels, 
which are kind of like categories. Instead of having just one logger, you can have many loggers. 
- Each has a unique name - called a channel - and each can do totally different things with their logs - like write 
them to different log files.
- So, for example, if I hit the players controller action endpoint + check out the dev logs, I see the below:

```
[2019-03-15 08:32:09] request.INFO: Matched route "_wdt". {"route":"_wdt","route_parameters":{"_route":"_wdt","_controller":"web_profiler.controller.profiler::toolbarAction","token":"89ecc9"},"request_uri":"http://127.0.0.1:8000/_wdt/89ecc9","method":"GET"} []
[2019-03-15 08:32:11] request.INFO: Matched route "app_players". {"route":"app_players","route_parameters":{"_route":"app_players","_controller":"App\\Controller\\PlayersController::getPlayerAction","name":"harry"},"request_uri":"http://127.0.0.1:8000/players/harry","method":"GET"} []
[2019-03-15 08:32:11] app.INFO: Someone is calling the getPlayerAction endpoint [] []
[2019-03-15 08:32:11] app.INFO: This is a log with a specific message: checking that the autowiring for player service works [] []
```

- Here, we can see 2 channels - request and app.
- The 'app' ones are the logs I've added myself within the PlayersController and PlayerService.
- So it would appear that the main logger uses a channel called 'app'. 
- But other parts of Symfony are using other channels, like 'request' or 'event'.
- If you look in config/packages/dev/monolog.yaml, you can see different behavior based on the channel.
- Here's what the monolog.yaml file (within the dev directory) currently looks like:

```
monolog:
    handlers:
        main:
            type: stream
            path: "%kernel.logs_dir%/%kernel.environment%.log"
            level: debug
            channels: ["!event"]
            
        # uncomment to get logging in your browser
        # you may have to allow bigger header sizes in your Web server configuration
        
        #firephp:
        #    type: firephp
        #    level: info
        
        #chromephp:
        #    type: chromephp
        #    level: info
            
        console:
            type:   console
            process_psr_3_messages: false
            channels: ["!event", "!doctrine", "!console"]

```

- For example, most logs are saved to a dev.log file. 
- But, thanks to this channels: ["!event"] config, which means "not event", anything logged to the "event" logger is not saved to this file.
- This is a really cool feature. But mostly... I'm telling you about this because it's a great example of a new problem: 
how could we access one of these other Logger objects? I mean, when we use the LoggerInterface type-hint, it gives us 
the main logger. But what if we need a different Logger, like the "event" channel logger?

###Creating a new Logger Channel

- Let's create a new channel called 'players'.
- Because I want this channel to be available in ALL environments, I can't simply just add the config to the monolog.yaml
file within the 'dev' directory.
- Instead, I will create a new file at the root level (within config>packages), entitled 'monolog.yaml', and add a new channel:

```
monolog:
    channels: ['players']
```

- Now, when I run a ```bin/console debug:container --show-private log```, I can see my new ```monolog.logger.players``` channel

- UP TO PAGE 45 


### Libraries to become more familiar with

- sec-check (sensiolabs/security-checker) plugin.
- twig
- annotations (https://symfony.com/doc/master/bundles/SensioFrameworkExtraBundle/index.html) - other than 'name' and 'method',
what can i do with the other options?

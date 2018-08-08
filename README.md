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



### Libraries to become more familiar with

- sec-check (sensiolabs/security-checker) plugin.
- twig
- annotations (https://symfony.com/doc/master/bundles/SensioFrameworkExtraBundle/index.html) - other than 'name' and 'method',
what can i do with the other options?

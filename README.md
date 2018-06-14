### Symfony 4 learning:

- Watching https://knpuniversity.com/screencast/symfony

### Setup project

- To create the skeleton symfony framework:

```$ composer create-project symfony/skeleton symfony-4-learning```

- After the installation of my dependencies (which includes several symfony 'recipes'), I was informed:

```$ Run composer require server --dev for a better web server.```

- So I did. To launch the 'better' web server, run

```$ php -S 127.0.0.1:8000 -t public```

### Create a route via routes.yaml

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

### Create a route with annotations

- First, install it:

```$ composer require annotations```

- Interestingly, this require of 'annotations' actually installs 'sensio/framework-extra-bundle'...more on that later
- Next, I will comment out the route I added above (in the config > routes.yaml file)
- And then I'll add the @Route annotation in my PlayersController and try to load the page again.
- Boom, works

### Flex aliases and recipes

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

### Twig tutorials

- Not going to make too many notes on this.
- Twig is used to return HTML
- Ran a 'composer require twig' and several files were added / modified. One that was modified was 'config>bundles.php'
- Bundles are the plugin system for symfony. Whenever we install a third party bundle, flex adds it into 'config>bundles.php'
so that it is used automatically
- Created a very basic TwigDemoController

### Profiler (aka the web debug toolbar)

- Ran a 'composer require profiler --dev' and a few things were installed
- Run the web server and go to 'http://127.0.0.1:8000/twig/demo' (which renders an HTML template)
- When the page loads, I can see a little toolbar at the bottom of the page - each icon in the toolbar is packed with info
- When you click on one of the icons, you can go into it even further and view more detailed analysis
- This web debug toolbar / profiler is automatically injected at the bottom of any valid HTML page during development
- The profiler also installed symfony's 'var dumper' component
- So now, instead of using var_dump during development, you can instead use dump(). 
- Pretty nice, adds coloured output (I've added to the twig demo controller + also in the base.html.twig template)

### Debugging and Packs

- Symfony has even more debugging tools
- Easiest way to get all of them ```$ composer require debug --dev```
- Installs one 'pack' that consists of a composer.json (which will then in turn install another e.g. 5 packages)
- An example - https://packagist.org/packages/symfony/debug-pack (https://github.com/symfony/debug-pack)
- But packs have a downside too. If you want to control the version of one of the 5 packages, how do you do this? 
- The only way to date is to 'unpack' the pack and then configure each package separately
- To do this, run ```$ composer unpack debug```
- This command removes the 'debug-pack' from the composer files but you can then see that the debug-pack's 6 packages have been 
 added to the composer files. So now if you want to customise the version of one of those packages, you can. 

### Assets: CSS & JavaScript

- Not making notes on this.

### Route names

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

### JavaScript API video

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

### Services



### Libraries to become more familiar with

- sec-check (sensiolabs/security-checker) plugin.
- twig
- annotations (https://symfony.com/doc/master/bundles/SensioFrameworkExtraBundle/index.html) - other than 'name' and 'method',
what can i do with the other options?
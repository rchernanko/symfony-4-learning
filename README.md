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
- And then I'll add the @Route annotation in my PlayersController.
- Boom, works

### Flex aliases

- We are now going to install a new library, not so much to use it in here, but to demonstrate the recipe system:

```$ composer require sec-checker --dev```

- Of course, 'sec-checker' does not follow the standard pattern of installing a library with composer.
- To install a package with composer, it would normally be something like... 'composer require sensiolabs/security-checker'
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

- Where do the recipes live? All in github. Go back to symfony.sh and click on the 'Recipe' icon. This takes you directly to the codebase


### Things to follow up on:

- Few things I've noticed that are different to previous versions of symfony (I think so anyway).
    1) config > bundles is automatically updated with the new library I've installed

- Get more comfortable with the annotations library - https://symfony.com/doc/master/bundles/SensioFrameworkExtraBundle/index.html

- Check out the sec-check (sensiolabs/security-checker) plugin.
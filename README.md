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





### Things to follow up on:

- Few things I've noticed that are different to previous versions of symfony (I think so anyway).
    1) As well as the composer.json and composer.lock files changing, there is now a symfony.lock file. What is this? How is it used?
    2) config > bundles is automatically updated with the new library I've installed

- Get more comfortable with the annotations library - https://symfony.com/doc/master/bundles/SensioFrameworkExtraBundle/index.html
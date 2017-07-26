Executer
===========
This extension works with files both locally and remotely. It can run commands in console mode. 
There are two different flags for execution with a response from the command and without (then the script will not wait for execution, an imitation of asynchronous execution).

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist gud3/yii2-executer "*"
```

or add

```
"gud3/yii2-executer": "*"
```

to the require section of your `composer.json` file.


Usage local
-----
To execute the command locally in the system where the script is located:

```
$console = (new gud3\Local())->exec('command');
```

The variable in the console will be the result of executing the command line. For asynchronous execution (mostly used to run PHP or other scripts), you must pass the second parameter to true.

```
$console = (new gud3\Local())->exec('command', true);
```

Also, to execute a number of commands, you can pass an array to a function. And they are executed one after another.

```
$console = (new gud3\Local())->exec(['command1', 'command2']);
```


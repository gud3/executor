Executor
===========
This extension works with files both locally and remotely. It can run commands in console mode. 
There are two different flags for execution with a response from the command and without (then the script will not wait for execution, an imitation of asynchronous execution).
There are three public methods for working with the class: `exec(), getFile(), setFile()`. Each of the functions has a number of input parameters from which you can see below.
To connect to the ssh2 in the constructor of the object, you need to transfer the data for the connection.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Enter run

```
php composer.phar require --prefer-dist gud3/executor "*"
```

or add

```
"gud3/executor": "*"
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

Usage Ssh2 protocol
-----
To connect via the protocol, you must enter the IP address, login and password.

```
$connect = new gud3\Ssh2($ip, $login, $password, $port);
$console = $connect->exec(['command1', 'command2', 'command3']);
```

You can get the contents of the file as follows:
-----
```
$local = new gud3\Local();
$file = $local->getFile($path_to_file, $file_name);
```
or remotely
```
$local = new gud3\Ssh2($ip, $login, $password, $port);
$file = $local->getFile($path_to_file, $file_name);
```

Overwrite the file if it exists. If the file does not exist then it will be created
-----
```
$result = $local->setFile($path_to_file, $file_name, $content);
```
## Laravel.IO Community Portal

This is the Laravel.IO community portal site. The site is entirely open source and community involvement is not only encouraged, but required in order to ensure the future success of the project.

### Requirements

1. PHP 5.4

### Recommended

1. Vagrant - Our entire workflow is built into a Vagrant setup. Those looking to
   contribute to the project should use the Vagrant configuration for a number
   of reasons. These include ease of configuration and ensuring that the
   environments used are compatible.

### Local Installation

Here are the steps for installation on a local machine using the officially endorsed workflow.

1. install Vagrant, Chef and VirtualBox from their websites. NOT from package managers. If you install any of these from package managers, please do not ask for help or support when things break, which will VERY likely happen. Additionl information can be found here: https://github.com/ShawnMcCool/vagrant-chef
2. add "10.10.10.10 app.local" to your HOSTS file. Instructions below for Linux.
    ```
    echo "10.10.10.10 app.local" | sudo tee -a /etc/hosts
    ```
3. clone down this repository
    ```
    git clone git@github.com:LaravelIO/laravel-io.git
    ```
4. run the install vagrant script
    ```
    bash ./install_vagrant.sh
    ```
5. ssh into the vagrant box and run the update environment script
    ```
    vagrant ssh

    cd /vagrant

    bash ./update_environment.sh
    ```

Now, we must install the oauth configuration.

1. ssh into the vagrant box (vagrant ssh) and cd /vagrant
2. create the configuration file below at app/config/packages/artdarek/oauth-4-laravel/config.php
3. Create an application in your github account called something like "Laravel IO Development" and add your GH application's client id and secret to this config file. Your GitHub Application should be set up as follows:
    a. Full URL: http://app.local

    b. Callback URL: http://app.local/login

```PHP
<?php

return [
    'storage' => 'Session',

    'consumers' => [
        'GitHub' => [
            'client_id'     => '',
            'client_secret' => '',
            'scope'         => ['user'],
        ],
    ],
];
```

### Workflow

When you'd like to work on the application, run vagrant up. When you're finished, run vagrant suspend.

Access the application at the URL: http://app.local/ (the trailing front-slash tends to be required for .local tlds in most browsers).

When you'd like to access the database, connect to host app.local port 3306 using the user/password root/password.

After pulling down changes, ssh into the vagrant box and run the update_environment.sh script.

### Contribution

Please consult [The Vision Document](VISION.md) which contains contribution standards and an outline of the general vision of the application.

### Troubleshooting

**I'm getting an error about running a 64bit VM on a 32bit machine**

You probably don't have hardware virtualization support enabled in your computer's BIOS.



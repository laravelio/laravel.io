## Laravel.IO Community Portal

This is the Laravel.IO community portal site. The site is entirely open source and community involvement is not only encouraged, but required in order to ensure the future success of the project.

### Requirements

1. PHP 5.4

### Recommended

1. Vagrant

### Local Installation

Here are the steps for installation on a local machine using the officially endorsed workflow.

1. install Vagrant, Chef and VirtualBox from their websites. NOT from package managers. If you install any of these from package managers, please do not ask for help or support when things break, which will VERY likely happen.
2. add "10.10.10.10 app.local" to your HOSTS file
3. clone down this repository
4. run the install vagrant script
5. ssh into the vagrant box (vagrant ssh), cd /vagrant, and run the update environment script

Now, we must install the oauth configuration.

1. ssh into the vagrant box (vagrant ssh) and cd /vagrant
2. create the configuration file at app/config/packages/artdarek/oauth-4-laravel/config.php

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

3. if you haven't already, create an application in your github account called something like "Laravel IO Development" and add your GH application's client id and secret to this config file.

### Workflow

When you'd like to work on the application, run vagrant up. When you're finished, run vagrant suspend.

When you'd like to access the database, connect to host app.local port 3306 using the user/password root/password.

### Troubleshooting

**I'm getting an error about running a 64bit VM on a 32bit machine**

You probably don't have hardware virtualization support enabled in your computer's BIOS.
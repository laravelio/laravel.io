## Laravel.IO Community Portal

This is the Laravel.IO community portal site. The site is entirely open source and community involvement is not only encouraged, but required in order to ensure the future success of the project.

### Requirements

1. PHP 5.4
2. Vagrant
3. Chef
4. Virtualbox
5. NodeJS

### Recommended

1. Vagrant - Our entire workflow is built into a Vagrant setup. Those looking to
   contribute to the project should use the Vagrant configuration for a number
   of reasons. These include ease of configuration and ensuring that the
   environments used are compatible.

### Local Installation

Here are the steps for installation on a local machine using the officially endorsed workflow.

1. Install [Vagrant][1], [Chef][2], and [VirtualBox][3] from their websites. **NOT** from package managers. If you install any of these from package managers, please do not ask for help or support when things break, which will VERY likely happen. Additional information can be found here: https://github.com/ShawnMcCool/vagrant-chef
   _Note_: If you are running OS X 10.9 Mavericks, you will need to modify the install.sh file for it to work properly. Run the following in your preferred terminal:

      
            wget https://raw.github.com/laravelIO/laravel-io/master/chef/chef-osx.sh

            chmod +x chef-osx.sh
            
            sudo ./chef-osx.sh

2. Add "10.10.10.10 app.local" to your HOSTS file. Instructions below for Linux.
    ```
    echo "10.10.10.10 app.local" | sudo tee -a /etc/hosts
    ```
3. Clone down this repository
    ```
    git clone git@github.com:LaravelIO/laravel-io.git
    ```
4. Run the install vagrant script
    ```
    bash ./install_vagrant.sh
    ```
5. SSH into the vagrant box and run the update environment script

```
$ vagrant ssh

$ cd /vagrant

$ bash ./update_environment.sh
```

Now, we must install the oauth configuration.

1. [Create an application][4] in your github account called something like "Laravel IO Development" and add your GH application's client id and secret to this config file. Your GitHub Application should be set up as follows:

    a. Full URL: http://app.local

    b. Callback URL: http://app.local/login
2. Create the configuration file below at ***app/config/packages/artdarek/oauth-4-laravel/config.php***

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

### Frontend

Because we keep the generated / minified css out of the repository, we must have a workflow for compiling the styles.
* Install the latest NodeJS
* Finally, run "compass watch" in your /public folder and the minified css will be generated and also your filesystem will watch for file changes (and overwrites the .css). You can also run "compass compile" as a single one-time command to generate the css and don't watch the filesystem.

### Contribution

Please consult [The Vision Document](VISION.md) which contains contribution standards and an outline of the general vision of the application.

### Troubleshooting

**I'm getting an error about running a 64bit VM on a 32bit machine**

You probably don't have hardware virtualization support enabled in your computer's BIOS.


  [1]: http://downloads.vagrantup.com/
  [2]: http://www.opscode.com/chef/install/
  [3]: https://www.virtualbox.org/wiki/Downloads
  [4]: https://github.com/settings/applications

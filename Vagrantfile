base_box = ENV['VAGRANT_BOX'] || 'bn-quantal64-lamp'
base_box_url = ENV['VAGRANT_BOX_URL'] || 'http://big-name.s3.amazonaws.com/bn-quantal64-lamp.box'

Vagrant::Config.run do |config|
    config.vm.box = base_box
    config.vm.box_url = base_box_url

    config.vm.network :hostonly, "10.10.10.10"

    config.vm.share_folder "vagrant-root", "/vagrant", ".", :owner => "vagrant", :group => "www-data"

    config.vm.provision :chef_solo do |chef|

        chef.cookbooks_path = "vagrant-chef/chef/cookbooks"
        chef.data_bags_path = "vagrant-chef/chef/data_bags"

        chef.add_recipe "apt"
        chef.add_recipe "git"
        chef.add_recipe "apache2"
        chef.add_recipe "apache2::mod_rewrite"
        chef.add_recipe "apache2::mod_ssl"
        chef.add_recipe "apache2::mod_php5"
        chef.add_recipe "mysql::server"
        chef.add_recipe "php"
        chef.add_recipe "php::module_mysql"
        chef.add_recipe "php::module_apc"
        chef.add_recipe "php::module_sqlite3"
        chef.add_recipe "php::module_gd"
        chef.add_recipe "php::module_curl"
        chef.add_recipe "chef-php-extra"
        chef.add_recipe "database::mysql"
        chef.add_recipe "apache-sites"
        chef.add_recipe "mysql-databases"

        chef.json.merge!({
            "mysql" => {
                "server_root_password" => "password",
                "server_debian_password" => "password",
                "server_repl_password" => "password",
                "bind_address" => "0.0.0.0"
            },
            "databases" => {
                "create" => [
                    "lio_development"
                ]
            },
            "sites" => ["default"]
        })

    end
end

Vagrant::Config.run do |config|
    # permissions for the application's storage folder
    config.vm.provision :shell do |shell|
        shell.inline = "sudo bash /vagrant/vagrant-chef/scripts/shell.sh"
    end
end

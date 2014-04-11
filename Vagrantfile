Vagrant.configure("2") do |config|

    config.vm.provider :virtualbox do |v|
        config.vm.box = "precise64"
        config.vm.box_url = "http://files.vagrantup.com/precise64.box"

        v.name = "Laravel IO VB"
        v.customize ["modifyvm", :id, "--memory", 512]
    end

    config.vm.network :private_network, ip: "10.10.10.10"
    config.ssh.forward_agent = true

    #############################################################
    # Ansible provisioning (you need to have ansible installed)
    #############################################################

    config.vm.provision "ansible" do |ansible|
        ansible.playbook = "ansible/playbook.yml"
    end

    config.vm.synced_folder "./", "/vagrant", id: "vagrant-root", :nfs => true
end

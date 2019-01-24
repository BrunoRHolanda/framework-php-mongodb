VAGRANTFILE_API_VERSION = "2"
Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    config.vm.box = "ubuntu/trusty64"
    config.vm.network "forwarded_port", guest: 80, host: 9010
    config.vm.provision "shell", path: "provisioner.sh"

    config.vm.provider "virtualbox" do |v|
        v.default_nic_type = "82543GC"
    end
end


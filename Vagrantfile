Vagrant.configure(2) do |config|

  config.vm.network :private_network, ip: "192.168.19.69"
  config.vm.synced_folder ".", "/vagrant", type: "nfs", nfs_udp: false, mount_options: ["actimeo=2", "nolock"]

  config.vm.hostname = "saa"


  config.vm.box = "debian/stretch64"

  config.ssh.forward_agent = true

  config.vm.provider "virtualbox" do |vb|
     vb.memory = "2048"
  end

  # Provision box with php and composer
  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get install -y ca-certificates apt-transport-https git zip vim curl
    wget -q https://packages.sury.org/php/apt.gpg -O- | apt-key add -
    echo "deb https://packages.sury.org/php/ stretch main" | tee /etc/apt/sources.list.d/php.list
    apt-get update
    apt-get install -y php8.0 php8.0-curl php8.0-xml php8.0-mbstring
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
  SHELL
end

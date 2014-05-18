# Set any variables here - override them by using VARIABLE="value" in the command line
VAGRANTENV = --env=vagrant
VAGRANTSSH = ssh vagrant@app.local
ARTISAN = php artisan

# Usage information
# Use: make all
all:
	@echo "A repository build and management tool."

	@echo "\nVagrant"
	@echo "  make up               - Start the vagrant virtual machine"
	@echo "  make ssh-config       - Configure SSH key"
	@echo "  make ssh              - SSH to the virtual machine"
	@echo "  make clean            - Removes Laravel files in the cache, session and view storage folders."
	@echo "  make install          - Update submodules, create vm, install composer, migrate and seed database.."
	@echo "  make vagrant-clean    - Halt the VM, destroy the box, and set it up again."

	@echo "\nComposer"
	@echo "  make composer-download        - Download and install composer."
	@echo "  make composer-setup           - Symlink composer.phar to /usr/bin/composer"
	@echo "  make composer-install         - Perform a 'php composer.phar install'"
	@echo "  make composer-install-dev     - Perform a 'php composer.phar install --dev'"

	@echo "\nMigrations and Database"
	@echo "  make migrate          - Launches a migration command on your vagrantbox. Called automatically with 'make vagrant'"
	@echo "  make rollback         - Launches a rollback command on your vagrantbox."
	@echo "  make seed             - Seed database. Called automatically with 'make vagrant'"

	@echo "\nMaintenance"
	@echo "  make submodules       - Update any submodules in the project"

	@echo "\nTesting"
	@echo "  make test                     - Run all unit tests on the vagrant box"
	@echo "  make unit Accounts/User       - Creates a unit test for class Accounts/User"

# Give help
# Use: make help
help: all

# Run almost everything from the ground up
# Update submodules, create vm, install composer, migrate and seed database..
# Use: make install
install: submodules up ssh-config composer-setup composer-install-dev migrate seed

# SSH to the virtual machine
# Use: make ssh
ssh:
	@$(VAGRANTSSH)

# Configure SSH key
# Use: make ssh-config
ssh-config:
	ssh-add ~/.vagrant.d/insecure_private_key

# Clean out laravel's cache, session and storage directories
# Use: make clean
clean:
	@rm app/storage/views/* app/storage/cache/* app/storage/sessions/*

# Update/sync submodules
# Use: make submodules
submodules:
	git submodule update --init --recursive

# Bring vagrant up
# Use: make up
up:
	vagrant up

# Destroy vagrant and reinstall
# Use: make vagrant-clean
vagrant-clean:
	vagrant destroy && make vagrant

# Setup composer
composer-setup:
	@$(VAGRANTSSH) "sudo ln -s /vagrant/composer.phar /usr/bin && chmod +x /vagrant/composer.phar"

# Download an install composer in this project
# Use: make composer-download
composer-download:
	@$(VAGRANTSSH) "cd /vagrant && curl -sS https://getcomposer.org/installer | php"

# Perform a composer install
# Use: make composer-install
composer-install:
	@$(VAGRANTSSH) "cd /vagrant && php composer.phar install --no-dev"

# Perform a composer install with --dev
# Use: make composer-install-dev
composer-install-dev:
	@$(VAGRANTSSH) "cd /vagrant && php composer.phar install --dev"

# Run migrations
# Use: make migrate
migrate:
	@$(VAGRANTSSH) "cd /vagrant && php artisan migrate"

# Seed database
# Use: make seed
seed:
	@$(VAGRANTSSH) "cd /vagrant && php artisan db:seed"

# Rollback a migration
# Use: make rollback
rollback:
	@$(VAGRANTSSH) "cd /vagrant && php artisan migrate:rollback $(VAGRANTENV)"

# Run unit tests through phpunit install via composer
# Use: make test
test:
	@$(VAGRANTSSH) "cd /vagrant && php codecept.phar run"

# Create unit test for Accounts/User
# Use: make unit class=Accounts/User
unit:
	@$(VAGRANTSSH) "cd /vagrant && php codecept.phar generate:phpunit unit $(class)"

run "cd #{release_path} && ([ -f tmp/composer.phar ] || curl -sS https://getcomposer.org/installer | php -- --install-dir=tmp)"
run "cd #{release_path} && php tmp/composer.phar --no-dev install"


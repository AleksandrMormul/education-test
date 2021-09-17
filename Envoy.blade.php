@servers(['web' => 'mormul_as@192.168.10.240'])

@setup

$releases_dir = $server_dir . '/releases/' . $remove_dir . '';
$releases_git_dir = $server_dir . '/releases/' . $remove_dir . '/.git';
$app_dir = $server_dir . '/app';

@endsetup

@story('deploy')

preparation
run_composer
update_symlinks
artisan_command
frontend_build
remove_old_releases

@endstory

@task('preparation')

echo 'Move Folder'
rm -rf {{$releases_git_dir}}
cd {{$server_dir}}
mkdir -p storage

@endtask

@task('run_composer')

echo "composer install"
echo "{{ $releases_dir }}"
cd {{ $releases_dir }} /
php74 -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php74 -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php74 composer-setup.php
php74 -r "unlink('composer-setup.php');"
php74 ./composer.phar install --prefer-dist -q -o

@endtask

@task('update_symlinks')

echo "Linking storage directory"
echo "server_dir {{$server_dir}}"
rm -rf {{$releases_dir}}/storage
ln -s {{$server_dir}}/storage {{$releases_dir}}/storage

echo 'Linking .env file'
cat {{$server_dir }}/.env
ln -s {{$server_dir}}/.env {{$releases_dir }}/.env
cat {{$releases_dir }}/.env

echo 'Linking current release'
rm -rf {{$app_dir}}
ln -s {{ $releases_dir }} {{ $app_dir }}

@endtask

@task('artisan_command')
echo 'Artisan Command'
php74 {{ $releases_dir }}/artisan view:clear --quiet
echo 'view:clear --quiet'
php74 {{ $releases_dir }}/artisan cache:clear --quiet
echo 'cache:clear --quiet'
php74 {{ $releases_dir }}/artisan config:cache --quiet
echo 'config:cache --quiet'
php74 {{ $releases_dir }}/artisan migrate --force
php74 {{ $releases_dir }}/artisan storage:link
php74 {{ $releases_dir }}/artisan queue:restart --quiet
echo "Cache cleared"

@endtask

@task('frontend_build')

echo 'Frontend Build'
curl -sL https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.0/install.sh -o install_nvm.sh
bash install_nvm.sh
source ~/.bash_profile
command -v nvm
nvm install 16
node -v
cd {{ $releases_dir }}
npm install && npm run dev

@endtask

@task('remove_old_releases')

echo 'Remove OLD release'
cd {{$server_dir}}/releases
rm -rf `ls -t | tail -n +2`

@endtask

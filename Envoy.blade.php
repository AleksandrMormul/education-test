@servers(['web' => 'mormul_as@192.168.10.240'])

@setup
$alias = [
'alias php='/var/www/mormul_as/data/php-bin-isp-php74/php',
];
$releases_dir = $server_dir . '/releases/' . $remove_dir . '';
$releases_git_dir = $server_dir . '/releases/' . $remove_dir . '/.git';
$app_dir = $server_dir . '/app';
@endsetup

@story('deploy')
alias
preparation
run_composer
update_symlinks
artisan_command
frontend_build
remove_old_releases
@endstory
@task('php')
alias php='/var/www/mormul_as/data/php-bin-isp-php74/php'
php -v
@endtask
@task('preparation')
@task('alias')

@foreach ($alias as $alia)
    LINE='{{$alia}}'
    FILE=.profile
    grep -qF "$LINE" "$FILE" || echo "$LINE" >> "$FILE"
@endforeach
alias
echo "Done."
@endtask
echo 'Move Folder'
rm -rf {{$releases_git_dir}}
cd {{$server_dir}}
mkdir -p storage
@endtask

@task('run_composer')
php -v
echo "composer install"
echo "{{ $releases_dir }}"
cd {{ $releases_dir }} /
composer install
@endtask

@task('update_symlinks')
echo "Linking storage directory"
rm -rf {{$releases_dir}}/storage
ln -s {{$server_dir}}/storage {{$releases_dir}}/storage

echo 'Linking .env file'
ln -s {{$server_dir}}/.env {{$releases_dir }}/.env

echo 'Linking current release'
rm -rf {{$app_dir}}
ln -s {{ $releases_dir }} {{ $app_dir }}
@endtask

@task('artisan_command')
echo 'Artisan Command'
php {{ $releases_dir }}/artisan view:clear --quiet
php {{ $releases_dir }}/artisan cache:clear --quiet
php {{ $releases_dir }}/artisan config:cache --quiet
php {{ $releases_dir }}/artisan migrate --force
php {{ $releases_dir }}/artisan storage:link
php {{ $releases_dir }}/artisan queue:restart --quiet
echo "Cache cleared"
@endtask

@task('frontend_build')
echo 'Frontend Build'
cd {{ $releases_dir }}
npm install && npm run dev
@endtask

@task('remove_old_releases')
echo 'Remove OLD release'
cd {{$server_dir}}/releases
rm -rf `ls -t | tail -n +2`
@endtask

<?php
namespace Deployer;

require 'recipe/laravel.php';

// Configuration

set('repository', 'git@bitbucket.org:guescini-HU/vuelasticsearchjslaudatio.git');
set('git_tty', true); // [Optional] Allocate tty for git on first deployment
add('shared_files', ['.env','config/flysystem.php','config/filesystems.php','config/gitlab.php','config/laudatio.php']);
add('shared_dirs', ['storage', 'vendor']);
add('writable_dirs', ['releases','storage','vendor']);
set('ssh_type', 'native');
set('ssh_multiplexing', true);
set('http_user', 'www-data');
set('permission_method', 'chmod_777');
set('writable_use_sudo', true);
set('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/framework/views/gitLab',
    'storage/logs',]);


// Hosts
host('depot1-6.cms.hu-berlin.de')
    ->user('root')
    ->identityFile('/Users/rolfguescini/.ssh/deploy', '/Users/rolfguescini/.ssh/deploy', '')
    ->set('deploy_path', '/var/www/html/laravelaudatio')
    ->set('branch', 'visualizeheaders')
    ->user('rolfguescini');


// Tasks
task('environment', function () {
    run('cp /var/www/html/laravelaudatio/flysystem.php {{release_path}}/config/flysystem.php');
    run('cp /var/www/html/laravelaudatio/filesystems.php {{release_path}}/config/filesystems.php');
    run('cp /var/www/html/laravelaudatio/gitlab.php {{release_path}}/config/gitlab.php');
    run('cp /var/www/html/laravelaudatio/laudatio.php {{release_path}}/config/laudatio.php');
    run('cp /var/www/html/laravelaudatio/deployenv {{release_path}}/.env');
    //run('cp /var/www/html/laravelaudatio/Groups.php {{release_path}}/vendor/m4tthumphrey/php-gitlab-api/lib/Gitlab/Api/Groups.php');
})->desc('Environment setup');

task('makespace', function () {
    run('cd /var/www/html/laravelaudatio/releases');
    run('sudo -su www-data');
    run('rm -rf *');
    run('exit');
})->desc('Environment setup');

before('deploy','makespace');


desc('Execute artisan config:clear');
task('clearconfig', function () {
    run('{{bin/php}} {{release_path}}/artisan config:clear');
    run('{{bin/php}} {{release_path}}/artisan cache:clear');
});

after('deploy','environment');
after('deploy','clearconfig');
after('deploy:failed', 'deploy:unlock');
<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'travoy');

// Project repository
set('repository', 'git@gitlab.com:smarteksistem/project/travoy/api.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('production')
    ->hostname('10.14.3.58')
    ->user('travoy')
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent()
    ->set('deploy_path', '/var/www/api.{{application}}.id');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');
before('deploy:symlink', 'artisan:queue:restart');


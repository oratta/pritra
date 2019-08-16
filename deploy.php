<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'pritra');

// Project repository
set('repository', 'https://github.com/oratta/pritra.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys
add('shared_files', ["env_files/.env.staging", "env_files/.env.production"]);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('writable_mode', "chmod");

// 統計情報を送信しない
set('allow_anonymous_stats', false);

// Hosts
inventory('env_files/deployer_hosts.yml');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// shared/.envを.env.{stage}で上書きする
after('deploy:shared', 'overwrite-env');

// Migrate database before symlink new release.
//before('deploy:symlink', 'artisan:migrate');


// Tasks

task('deploy', function () {
    // 本番への反映は確認を挟む
    if (input()->hasArgument('stage') && (input()->getArgument('stage') === 'production')) {
        if (!askConfirmation('productionに反映して問題ありませんか？', true)) {
            writeln('deploy was stopped');
            return;
        }
    }
    invoke('deploy:laravel');
});

desc('shared/.envを.env.{stage}で上書き');
task('overwrite-env', function () {
    $stage = get('stage');
    $src = ".env.${stage}";
    $deployPath = get('deploy_path');
    $sharedPath = "${deployPath}/shared";
    $destination = "${sharedPath}/env_files/${src}";
    upload("env_files/$src", $destination);
    run("cp -f $destination ${sharedPath}/.env");
});

/**
 * Main task
 */
desc('Deploy your project');
task('deploy:laravel', [
    'laradock:test'
]);
task('deploy:laravel', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
//    'deploy:vendors',
    'deploy:writable',
//    'artisan:storage:link',
//    'artisan:view:clear',
//    'artisan:cache:clear',
//    'artisan:config:cache',
//    'artisan:optimize',
    'deploy:symlink',//この前にmigration
    'deploy:unlock',
    'cleanup',
]);
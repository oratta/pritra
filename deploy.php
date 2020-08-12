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

// Tasks
task('deploy', function () {
    // 本番への反映は確認を挟む
    if (input()->hasArgument('stage') && (input()->getArgument('stage') === 'production')) {
        if (!askConfirmation('productionに反映して問題ありませんか？', true)) {
            writeln('deploy was stopped');
            return;
        }
    }
    //ここで入ってもダメかもしれない
//    invoke('login:laradock');
    invoke('deploy:laravel');
});

desc('laradockに入る');
task('login:laradock', function(){

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

desc('copy .htaccess');
task('htaccess', function () {
    $src = ".htaccess";
    $deployPath = get('deploy_path');
    $destination = "${$deployPath}/current/public/${src}";
    upload("env_files/$src", $destination);
});

desc('nodeモジュールのインストールとコンパイル');
task('npm:run', function (): void {
    //TODO Laradockに入る必要がある
    run('cd {{release_path}} && chmod 707 public');
    run('cd {{release_path}} && npm install');

    if (input()->getArgument('stage') === 'production') {
        run('cd {{release_path}} && npm run production');
    } else {
        run('cd {{release_path}} && npm run development');
    }
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
    # deployerが動かないのでartisanで独自実装
//    'artisan:deploy:composer ' . get('deploy_path'), #動かない
    //TODO 自作のartisanコマンドを呼び出せるように
    'deploy:writable',
//    'artisan:storage:link',
//    'artisan:view:clear', //TODO 本番環境の管理サーバでphpが動いていない
//    'artisan:cache:clear', //TODO 本番環境の管理サーバでphpが動いていない
//    'artisan:config:cache', //TODO 本番環境の管理サーバでphpが動いていない
//    'artisan:optimize',//TODO 本番環境の管理サーバでphpが動いていない
    'deploy:symlink',//この前にmigration
    'deploy:unlock',
    'cleanup',
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// shared/.envを.env.{stage}で上書きする
after('deploy:shared', 'overwrite-env');

// npm:runの実行
//TODO 動かない
//after('deploy:shared', 'npm:run'); // deploy:sharedの後にTaskを実行

//TODO 動かない
// Migrate database before symlink new release.
//before('deploy:symlink', 'artisan:migrate');

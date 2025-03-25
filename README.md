job路径：E:\WWW\app\app\Jobs\ProcessDeduction.php
user_id保证同时只会有一个任务修改相同用户余额
numprocs=1保证supervisor只启动一个任务
supervisor配置如下
 
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php artisan queue:work --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=forge
numprocs=1
redirect_stderr=true
stdout_logfile=/home/service/app/logs/worker.log
stopwaitsecs=3600

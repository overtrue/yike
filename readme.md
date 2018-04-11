# 一刻

# 要求

1. PHP >= 7.1
2. MySQL >= 5.7
3. Redis
4. supervisor

# 软件安装信息

1. nginx 配置文件：`/etc/nginx/nginx.conf`
2. 站点配置文件：`/etc/nginx/sites-enabled/yike.io.conf`
3. php cli 模式配置文件：`/etc/php/7.0/cli/php.ini`
4. php fpm 模式配置文件：`/etc/php/7.0/fpm/php.ini`
5. php-fpm 服务配置文件：`/etc/php/7.0/fpm/pool.d/www.conf`
6. mysql 配置文件：`/etc/mysql/mysql.conf.d/mysqld.cnf`

# 系统软件重启

1. nginx: `service nginx restart`
2. php:  `service php7.0-fpm restart`
3. mysql: `service mysql restart`
4. supervisor: `service supervisor start`

# 项目安装

1. 创建数据库 `yike` (或者其它名称)
2. 修改目录权限：`chmod 777 ./storage ./bootstrap/cache -R`
3. 创建ENV文件：`copy .env.example .env`
4. 安装依赖： `composer install -vvv`
5. 修改 .env 中以下变量：

   ```
   # 数据库部分
   DB_HOST
   DB_PORT
   DB_DATABASE
   DB_USERNAME
   DB_PASSWORD

   # 支付宝
   ALIPAY_PARTNER
   ALIPAY_KEY
   ALIPAY_SELLER_EMAIL
   ALIPAY_CERT_PATH

   # 微信
   WEIXIN_APP_ID
   WEIXIN_SECRET
   WEIXIN_PAY_MERCHANT_ID
   WEIXIN_PAY_KEY
   WEIXIN_PAY_CERT_PATH
   WEIXIN_PAY_KEY_PATH
  
   # 有道智云翻译服务 `translug` 插件
   YOUDAO_APP_KEY
   YOUDAO_APP_SECRET
   ```

然后再执行一些初始化命令：

```
php artisan key:generate
php artisan jwt:secret
```

6. 建立数据表与默认数据：`./artisan migrate:refresh --seed --force`
7. 建立目录软链接：`./artisan storage:link`
8. 添加系统计划任务(如果没添加过的话)：

   ```shell
    $ crontab -e
    * * * * * php /www/yike/artisan schedule:run >> /dev/null 2>&1
   ```

9. 添加队列任务：`ln -s /www/yike/yike-worker.conf /etc/supervisor/conf.d/yike-worker.conf`
10. 启动队列任务：

   ```shell
    $ sudo supervisorctl reread
    $ sudo supervisorctl update
    $ sudo supervisorctl start yike-worker:*
   ```

   重启：`sudo supervisorctl restart all`

   > 任何与 app/Jobs 代码相关的修改都需要重启队列服务！


## 部署情况确认

1. 页面正常显示

2. supervisor 进程运行正常：`ps aux | grep supervisord | grep -v grep`

   ```
   能看到：/usr/bin/python /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
   ```

3. 确认队列任务正常运行：

   使用命令：`sudo supervisorctl status all`

   能看到类似以下信息：

   ```
   yike-worker:yike-worker_00   RUNNING   pid 30588, uptime 0:10:45
   yike-worker:yike-worker_01   RUNNING   pid 30589, uptime 0:10:45
   yike-worker:yike-worker_02   RUNNING   pid 30590, uptime 0:10:45
   yike-worker:yike-worker_03   RUNNING   pid 30591, uptime 0:10:45
   yike-worker:yike-worker_04   RUNNING   pid 30592, uptime 0:10:45
   yike-worker:yike-worker_05   RUNNING   pid 30593, uptime 0:10:45
   yike-worker:yike-worker_06   RUNNING   pid 30594, uptime 0:10:45
   yike-worker:yike-worker_07   RUNNING   pid 30595, uptime 0:10:45
   ```

# 静态文件

`css`, `js` 等文件在 `resources/assets` 下修改，修改完在项目根目录执行：

```shell
npm run production
```

完成编译，生成到 public。

# 日志

1. 系统日志：/www/yike/storage/logs/laravel.log
1. 队列日志：/www/yike/storage/logs/worker.log

# 统计实现

文章被阅读时：

1、写入所有用户的阅读历史: `post_views_${DAY}(HASH)` 结构：`IP: POST_ID`
2、同时写入用户阅读记录：`user_view_history_${UID}(HASH)` 结构：`POST_ID,timestamp`

每天晚上12点执行任务：

1、读取 `post_views_${DAY}` 记录，汇总到：`post_daily_views_${POST_ID}` 结构：`POST_ID,count`
2、读取 `post_daily_views_${POST_ID}` 得到本周热门写入缓存 用于首页显示
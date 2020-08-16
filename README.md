# 簡易縮址服務(請勿用於正式環境)

## 環境架設

### 建立環境
    git clone https://github.com/ceparadise168/sf-b2e-short-url.git

    cd sf-b2e-short-url

    composer install

    cp .env.example .env

    php artisan key:generate

    若使用 docker 需修改 .env 中的 mysql 及 redis host

    sed -i 's/REDIS_HOST=127.0.0.1/REDIS_HOST=redis/' .env

    sed -i 's/DB_HOST=127.0.0.1/DB_HOST=mysql/' .env


### 建立服務
    cd dnmp

    #為求方便, 在此 repo 已直接建立好 .env.test, 若仍與本地服務衝突請自行調整 port

    mv .env.test .env

    docker-compose up -d

### 檢查服務
    docker ps -a

    訪問 http://0.0.0.0/urls

## API 說明

### 建立短網址

#### Request
`curl -X POST '0.0.0.0:80/url' -d 'url=https://laravel.com/docs/7.x/controllers'`

#### Response
回傳短網址代號
`{"urlSequence":"3","url":"https:\/\/laravel.com\/docs\/7.x\/controllers","date":"date","creator":"john"}`

## 使用短網址
#### Request
`curl -X GET '0.0.0.0:80/3'`

#### Response
重新導向至對應網址
```
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="refresh" content="0;url='https://laravel.com/docs/7.x/controllers'" />

        <title>Redirecting to https://laravel.com/docs/7.x/controllers</title>
    </head>
    <body>
        Redirecting to <a href="https://laravel.com/docs/7.x/controllers">https://laravel.com/docs/7.x/controllers</a>.
    </body>
</html>
```

### 列出短網址
#### Request

`curl -X GET '0.0.0.0:80/urls'`
#### Response
```
[
{
"urlSequence":"2",
"url":"https:\/\/laravel.com\/docs\/7.x\/controllers",
"date":"date",
"creator":"john"
},
{
"urlSequence":"5",
"url":"https:\/\/laravel.com\/docs\/7.x\/controllers",
"date":"date",
"creator":"john"
},
{
"urlSequence":"1",
"url":"https:\/\/laravel.com\/docs\/7.x\/controllers",
"date":"date",
"creator":"john"
},
{
"urlSequence":"4",
"url":"https:\/\/laravel.com\/docs\/7.x\/controllers",
"date":"date",
"creator":"john"
},
{
"urlSequence":"3",
"url":"https:\/\/laravel.com\/docs\/7.x\/controllers",
"date":"date",
"creator":"john"
}
]
```

## TODO

- [x] 建立短網址
- [x] 使用短網址跳轉
- [x] 列出短網址
- [ ] 網址合法性檢查
- [ ] URL 相關操作獨立為 Service
- [ ] 調整 Redis key 結構
- [ ] 使用 ＣronJob 同步 queue 回 DB
- [ ] 可自訂短網址
- [x] 環境建置
- [ ] 加入測試
- [ ] 提供前台介面
- [ ] 提供後台審核功能

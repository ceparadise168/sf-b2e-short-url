## 簡易縮址服務

### 建立短網址

#### Request
`curl -X POST 'http://127.0.0.1:8000/url?url=https://laravel.com/docs/7.x/controllers'`

#### Response
回傳短網址代號
`{"urlSequence":"5","url":"https:\/\/laravel.com\/docs\/7.x\/controllers","date":"date","creator":"john"}`

## 使用短網址
#### Request
`curl -X GET 'http://127.0.0.1:8000/5'`

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

`curl -X GET 'http://127.0.0.1:8000/urls'`
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
- [ ] 環境建置
- [ ] 加入測試
- [ ] 提供前台介面
- [ ] 提供後台審核功能

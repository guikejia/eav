### 本仓库仅限企业内部使用
1. 在coding中[访问制品库](https://wk88.coding.net/p/vip/artifacts/24411637/composer/package/15298329/version/overview)
2. 在coding生成个人令牌作为凭据
3. 配置推送凭证
   请将下列配置添加到您的 ~/.netrc 文件中：
```
   machine wk88-composer.pkg.coding.net
   login zhangruolong@lweidu.com
   password <PASSWORD>
```
替换文本：
PASSWORD: 您的登陆密码
4. 配置拉取凭证
请进入 Composer 包文件目录，并将以下配置添加到 auth.json 文件中：
```
{
   "http-basic": {
       "wk88-composer.pkg.coding.net": {
           "username": "zhangruolong@lweidu.com",
           "password": "<PASSWORD>"
       }
   }
}
```
替换文本：
PASSWORD: 您的登陆密码
5. 请在项目根目录，执行以下命令设置仓库地址：
```
composer config repos.eav composer https://wk88-composer.pkg.coding.net/vip/eav
```
6. 请在项目根目录，执行以下命令进行拉取：
```
composer require guikejia/eav:1.0.0
```

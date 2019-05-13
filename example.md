
### TG 返回内容
```php
{"update_id":762553299,"message":{"message_id":94,"from":{"id":580152100,"is_bot":false,"first_name":"Oscar","username":"OscarHan","language_code":"en-US"},"chat":{"id":-316804829,"title":"\u673a\u5668\u4eba\u6d4b\u8bd5","type":"group","all_members_are_administrators":true},"date":1533803419,"text":"\/76","entities":[{"offset":0,"length":3,"type":"bot_command"}]}}
```
### 图灵请求
```php
$msg = '早上好';
$tu = new Tulin();
$data = $tu->TuLin($msg);
var_dump($data);die;
```
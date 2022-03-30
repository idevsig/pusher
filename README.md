# pusher
APP 推送通知

## 支持平台
|平台|官网|文档|案例|
|:---|:---|:---|:---|
|**PushDeer**|http://pushdeer.com/|-|[cases](tests/Channels/PushDeerTest.php)
|**Bark**(仅支持 `iOS`)|https://day.app/2021/06/barkfaq/|-|[cases](tests/Channels/BarkTest.php)
|**钉钉群机器人**|[https://open.dingtalk.com/](https://open.dingtalk.com/document/robots/customize-robot-security-settings)|-|[cases](tests/Channels/DingtalkTest.php)
|**企业微信群机器人**|[https://developer.work.weixin.qq.com](https://developer.work.weixin.qq.com/document/path/91770?notreplace=true)|-|[cases](tests/Channels/WeComTest.php)
|**Server酱**|[https://sct.ftqq.com/](https://sct.ftqq.com/)|-|[cases](tests/Channels/ServerChanTest.php)
|**电子邮件**|-|-|[case](tests/Channels/MailerTest.php)

## 环境
- **PHP**: `"^8.0 || ^8.1"`

## 使用
```bash
# 主线版
composer require jetsung/pusher:dev-main
```

## TODO
### 已开发
- Bark
- 钉钉群机器人
- PushDeer
- 企业微信群机器人
- Server酱
- 电子邮件

### 开发中

### 未开发
```bash
Chanify
Discord
飞书群机器人
Gitter
Google Chat
iGot
Logger
Mattermost
Now Push
PushBack
Push
PushPlus
QQ 频道机器人
Rocket Chat
Slack
Telegram
Webhook
息知
Zulip
```

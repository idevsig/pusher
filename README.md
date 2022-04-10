# pusher
APP 推送通知

## 支持平台
|状态|平台|官网|位置|文档|案例|
|:---|:---|:---|:---|:---|:---|
|✔|**Bark** (仅支持 `iOS`)|[https://day.app/2021/06/barkfaq/](https://day.app/2021/06/barkfaq/)|CN|-|[cases](tests/Channels/BarkTest.php)
|✔|**Chanify** (仅支持 `iOS`)|[https://www.chanify.net/](https://www.chanify.net/)|CN|-| [cases](tests/Channels/ChanifyTest.php)
|✔|**钉钉群机器人**|[https://open.dingtalk.com/](https://open.dingtalk.com/document/robots/customize-robot-security-settings)|CN|-|[cases](tests/Channels/DingtalkTest.php)
|✔|**飞书群机器人**|[https://open.feishu.cn/](https://www.feishu.cn/hc/zh-CN/articles/360024984973)|CN|-|[cases](tests/Channels/FeishuTest.php)
|✔|**电子邮件**|[https://github.com/phpmailer/phpmailer](https://github.com/phpmailer/phpmailer)|CN|-|[cases](tests/Channels/MailerTest.php)
|✔|**NowPush**|[https://www.nowpush.app/](https://nowpush.io/api-docs/)|US|-|[cases](tests/Channels/NowPushTest.php)
|✔|**PushBack**|[https://pushback.io/](https://pushback.io/docs/getting-started)|US|-|[cases](tests/Channels/PushBackTest.php)
|✔|**Pushover**|[https://pushover.net/](https://pushover.net/api#messages)|US|-|[cases](tests/Channels/PushoverTest.php)
|✔|**PushDeer**|http://pushdeer.com/|CN|-|[cases](tests/Channels/PushDeerTest.php)
|✔|**PushPlus**|[https://pushplus.hxtrip.com/](https://pushplus.hxtrip.com/)|CN|-|[cases](tests/Channels/PushPlusTest.php)
|✔|**QQ 频道机器人**|[https://bot.q.qq.com/wiki/](https://bot.q.qq.com/wiki/develop/api/openapi/message/post_messages.html)|CN|-|[cases](tests/Channels/QQBotTest.php)
|✔|**Server酱**|[https://sct.ftqq.com/](https://sct.ftqq.com/)|CN|-|[cases](tests/Channels/ServerChanTest.php)
|✔|**Showdoc**|[https://push.showdoc.com.cn/](https://push.showdoc.com.cn/)|CN|-|[cases](tests/Channels/ShowdocTest.php)
|✔|**Techulus**|[https://push.techulus.com/](https://docs.push.techulus.com/api-documentation)|US|-|[cases](tests/Channels/TechulusTest.php)
|✔|**Webhook**|-|CN|-|[cases](tests/Channels/WebhookTest.php)
|✔|**企业微信群机器人**|[https://developer.work.weixin.qq.com](https://developer.work.weixin.qq.com/document/path/91770?notreplace=true)|CN|-|[cases](tests/Channels/WeComTest.php)
|✔|**WxPusher**|[https://wxpusher.zjiecode.com/](https://wxpusher.zjiecode.com/)|CN|-|[cases](tests/Channels/WxPusherTest.php)
|✔|**息知**|[https://xz.qqoq.net/](https://xz.qqoq.net/)|CN|-|[cases](tests/Channels/XizhiTest.php)
|ING|**Zulip Chat**|[https://github.com/zulip/zulip](https://github.com/zulip/zulip)|self-hosting|-|[cases](#)
|ING|**Microsoft Teams**|[https://teams.microsoft.com/](https://docs.microsoft.com/en-us/microsoftteams/platform/webhooks-and-connectors/how-to/connectors-using?tabs=cURL#setting-up-a-custom-incoming-webhook)|US|-|[cases](#)

## 环境
- **PHP**: `"^8.0 || ^8.1"`

## 使用
- https://packagist.org/packages/jetsung/pusher
```bash
# 主线版
composer require jetsung/pusher:dev-main
```

## TODO
```bash
Pushbullet

Discord
Gitter
Google Chat
Mattermost
Rocket Chat
Telegram
xmpp


Slack Chat
```

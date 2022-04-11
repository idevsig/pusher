# pusher
APP 推送通知

## 支持平台
|状态|**国内**平台|官网|文档|案例|备注|
|:---|:---|:---|:---|:---|:---|
|✔ **荐**|**Bark**|[https://day.app/2021/06/barkfaq/](https://day.app/2021/06/barkfaq/)|-|[cases](tests/Channels/BarkTest.php)| (仅支持 `iOS`)
|✔ **荐**|**Chanify**|[https://www.chanify.net/](https://www.chanify.net/)|-| [cases](tests/Channels/ChanifyTest.php)|(仅支持 `iOS`)
|✔ **荐**|**钉钉群机器人**|[https://open.dingtalk.com/](https://open.dingtalk.com/document/robots/customize-robot-security-settings)|-|[cases](tests/Channels/DingtalkTest.php)
|✔ **荐**|**飞书群机器人**|[https://open.feishu.cn/](https://www.feishu.cn/hc/zh-CN/articles/360024984973)|-|[cases](tests/Channels/FeishuTest.php)
|✔ **荐**|**电子邮件**|[https://github.com/phpmailer/phpmailer](https://github.com/phpmailer/phpmailer)|-|[cases](tests/Channels/MailerTest.php)
|✔|**喵喵通知**|[https://apps.apple.com/cn/app/id1564699894](https://apps.apple.com/cn/app/id1564699894?l=zh)|-|[cases](tests/Channels/MiaomiaoTest.php)|仅支持 iOS。[点击查看此开源项目](https://github.com/vipheyue/pushpush)
|✔ **荐**|**PushDeer**|http://pushdeer.com/|-|[cases](tests/Channels/PushDeerTest.php)
|✔|**PushPlus**|[https://pushplus.hxtrip.com/](https://pushplus.hxtrip.com/)|-|[cases](tests/Channels/PushPlusTest.php)
|✔|**QQ 频道机器人**|[https://bot.q.qq.com/wiki/](https://bot.q.qq.com/wiki/develop/api/openapi/message/post_messages.html)|-|[cases](tests/Channels/QQBotTest.php)
|✔|**Server酱**|[https://sct.ftqq.com/](https://sct.ftqq.com/)|-|[cases](tests/Channels/ServerChanTest.php)
|✔|**Showdoc**|[https://push.showdoc.com.cn/](https://push.showdoc.com.cn/)|-|[cases](tests/Channels/ShowdocTest.php)
|✔|**Webhook**|-|-|[cases](tests/Channels/WebhookTest.php)
|✔ **荐**|**企业微信群机器人**|[https://developer.work.weixin.qq.com](https://developer.work.weixin.qq.com/document/path/91770?notreplace=true)|-|[cases](tests/Channels/WeComTest.php)
|✔|**WxPusher**|[https://wxpusher.zjiecode.com/](https://wxpusher.zjiecode.com/)|-|[cases](tests/Channels/WxPusherTest.php)
|✔|**息知**|[https://xz.qqoq.net/](https://xz.qqoq.net/)|-|[cases](tests/Channels/XizhiTest.php)
|ING|**Zulip Chat**|[https://github.com/zulip/zulip](https://github.com/zulip/zulip)|-|[cases](#)|**需自建**

|状态|**国外**平台|官网|文档|案例|备注|
|:---|:---|:---|:---|:---|:---|
|✔|**Techulus**|[https://push.techulus.com/](https://docs.push.techulus.com/api-documentation)|-|[cases](tests/Channels/TechulusTest.php)
|✔|**NowPush**|[https://www.nowpush.app/](https://nowpush.io/api-docs/)|-|[cases](tests/Channels/NowPushTest.php)
|✔|**PushBack**|[https://pushback.io/](https://pushback.io/docs/getting-started)|-|[cases](tests/Channels/PushBackTest.php)
|✔|**Pushover**|[https://pushover.net/](https://pushover.net/api#messages)|-|[cases](tests/Channels/PushoverTest.php)
|✔|**Pushbullet**|[https://www.pushbullet.com/](https://docs.pushbullet.com/#create-push)|-|[cases](tests/Channels/PushbulletTest.php)|(不支持 iOS。小米手机无法正常接收，但 Chrome 插件可用。)
|ING|**Microsoft Teams**|[https://teams.microsoft.com/](https://docs.microsoft.com/en-us/microsoftteams/platform/webhooks-and-connectors/how-to/connectors-using?tabs=cURL#setting-up-a-custom-incoming-webhook)|-|[cases](#)

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
Discord
Gitter
Google Chat
Mattermost
Rocket Chat
Telegram
xmpp


Slack Chat
```

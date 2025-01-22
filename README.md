# pusher

APP 推送通知

## 支持平台

| 状态     | **国内**平台         | 官网                                                                                                             | 文档 | 案例                                       | 备注                                                                   |
| :------- | :------------------- | :--------------------------------------------------------------------------------------------------------------- | :--- | :----------------------------------------- | :--------------------------------------------------------------------- |
| ✔ **荐** | **Bark**             | [https://day.app/2021/06/barkfaq/](https://day.app/2021/06/barkfaq/)                                             | -    | [cases](tests/Channels/BarkTest.php)       | 仅支持 `iOS`                                                           |
| ✔ **荐** | **Chanify**          | [https://www.chanify.net/](https://www.chanify.net/)                                                             | -    | [cases](tests/Channels/ChanifyTest.php)    | 仅支持 `iOS`                                                           |
| ✔ **荐** | **钉钉群机器人**     | [https://open.dingtalk.com/](https://open.dingtalk.com/document/robots/customize-robot-security-settings)        | -    | [cases](tests/Channels/DingtalkTest.php)   |
| ✔ **荐** | **飞书群机器人**     | [https://open.feishu.cn/](https://www.feishu.cn/hc/zh-CN/articles/360024984973)                                  | -    | [cases](tests/Channels/FeishuTest.php)     |
| ✔ **荐** | **电子邮件**         | [https://github.com/phpmailer/phpmailer](https://github.com/phpmailer/phpmailer)                                 | -    | [cases](tests/Channels/MailerTest.php)     |
| ✔ **荐** | **PushDeer**         | http://pushdeer.com/                                                                                             | -    | [cases](tests/Channels/PushDeerTest.php)   |
| ✔        | **PushPlus**         | [https://www.pushplus.plus/doc](https://www.pushplus.plus/)                                                      | -    | [cases](tests/Channels/PushPlusTest.php)   |
| ✔        | **QQ 频道机器人**    | [https://bot.q.qq.com/wiki/](https://bot.q.qq.com/wiki/develop/api/openapi/message/post_messages.html)           | -    | [cases](tests/Channels/QQBotTest.php)      |
| ✔        | **Server 酱**        | [https://sct.ftqq.com/](https://sct.ftqq.com/)                                                                   | -    | [cases](tests/Channels/ServerChanTest.php) |
| ✔        | **Showdoc**          | [https://push.showdoc.com.cn/](https://push.showdoc.com.cn/)                                                     | -    | [cases](tests/Channels/ShowdocTest.php)    |
| ✔        | **Webhook**          | -                                                                                                                | -    | [cases](tests/Channels/WebhookTest.php)    |
| ✔ **荐** | **企业微信群机器人** | [https://developer.work.weixin.qq.com](https://developer.work.weixin.qq.com/document/path/91770?notreplace=true) | -    | [cases](tests/Channels/WeComTest.php)      |
| ✔        | **WxPusher**         | [https://wxpusher.zjiecode.com/](https://wxpusher.zjiecode.com/)                                                 | -    | [cases](tests/Channels/WxPusherTest.php)   |
| ✔        | **息知**             | [https://xz.qqoq.net/](https://xz.qqoq.net/)                                                                     | -    | [cases](tests/Channels/XizhiTest.php)      |

| 状态     | **国外**平台   | 官网                                                                                    | 文档 | 案例                                       | 备注                                                                                   |
| :------- | :------------- | :-------------------------------------------------------------------------------------- | :--- | :----------------------------------------- | :------------------------------------------------------------------------------------- |
| ✔        | **Pushsafer**  | [https://www.pushsafer.com/](https://www.pushsafer.com/en/pushapi#api-message)          | -    | [cases](tests/Channels/PushsaferTest.php)  |
| ✔        | **Techulus**   | [https://push.techulus.com/](https://docs.push.techulus.com/api-documentation)          | -    | [cases](tests/Channels/TechulusTest.php)   | (付费)
| ✔ **荐** | **Telegram**   | [https://core.telegram.org/bots/](https://core.telegram.org/bots/api#sendmessage)       | -    | [cases](tests/Channels/TelegramTest.php)   |创建[Bot](https://t.me/BotFather)后，将Bot添加至群组或频道，再添加[获取ChatId的机器人进群组](https://t.me/getmyid_bot)(可移除)，即可获得`ChatId`|
| ✔        | **PushBack**   | [https://pushback.io/](https://pushback.io/docs/getting-started)                        | -    | [cases](tests/Channels/PushBackTest.php)   | (100条信息)
| ✔        | **Pushover**   | [https://pushover.net/](https://pushover.net/api#messages)                              | -    | [cases](tests/Channels/PushoverTest.php)   | (付费，试用期 30 天)                                                                   |
| ✔        | **Pushbullet** | [https://www.pushbullet.com/](https://docs.pushbullet.com/#create-push)                 | -    | [cases](tests/Channels/PushbulletTest.php) | 不支持 `iOS`。小米手机无法正常接收，但 Chrome 插件可用，长时间不登录账号，功能会失效。 |
| ✔        | **Zulip Chat** | [https://zulip.com/](https://zulip.com/api/send-message)                                | -    | [cases](tests/Channels/ZulipTest.php)      | **可[自建](https://zulip.readthedocs.io/en/stable/production/install.html)**           |

**TODO:**
>

## 环境

-   **PHP**: `"^8.2"`

## 使用

-   https://packagist.org/packages/jetsung/pusher

```bash
# 主线版
composer require jetsung/pusher:dev-main
```

## 仓库镜像

- https://git.jetsung.com/idev/pusher
- https://framagit.org/idev/pusher
- https://gitcode.com/idev/pusher
- https://github.com/idevsig/pusher

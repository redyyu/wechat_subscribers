=== WeChat Subscribers Lite 微信公众订阅号插件 ===
Name: WeChat Subscribers Lite 微信公众订阅号插件
Contributors: redyyu, HarrySG, AdamLBQ, robin-zhao
Tags: weixin,wechat,微信,subscribers,微信公众平台,wx,订阅号
Donate link: http://www.imredy.com/wp-wechat/
Requires at least: 3.7
Tested up to: 4.5.1
Stable tag: 4.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

=汉语=

感谢这些朋友为这个项目贡献过代码。
HarrySG, AdamLBQ, robin-zhao

微信群地址: http://imredy.com/wp-wechat

这回没怎么改，另外加了个设置里面可以给定默认的图片。
一些朋友和我说，他/她在文章中使用的是外链的图片，比如七牛的插件。
于是本微信插件无法取到文章里面的图片的问题。
为了不增加不同插件之间的耦合度，于是我还是保持依赖WP原生的图像资源库的做法。
如果有迫切需要的朋友，可以考虑选择一个能够自动保存"特色图片"的插件配合使用。

另外，我还修了一些Bug，可能也制造了一些新Bug :(。

如果发现任何bug或者有什么新功能需求，欢迎朝我发送电子邮件。<a href="mailto:redy.ru@gmail.com">redy.ru@gmail.com</a>

Github: <a href="https://github.com/Soopro/wechat_subscribers">https://github.com/Soopro/wechat_subscribers</a>.

这是一个简单通用的微信(weixin)公众平台订阅号专用插件。现在这个版本的插件只支持普通订阅号，任何人只要以个人身份免费注册微信公众平台就可以足以使用这个插件的全部功能。

这个插件将永久免费：）

特色：

1. 可设定默认回复为搜索关键字结果；
2. 可根据类型（Post-type）设定自动回复最新文章、随机文章、搜索结果等；
3. 可选择某篇文章内容，并将它同步到自动回复中；
4. 便捷管理多种weixin消息模版，可随时切换，数量不限；
5. 无需安装任何其他程序，完全使用Wordpress原生支持；
6. 带有接收消息的历史记录；
7. 多种消息模式，默认自动回复消息，关键词自动回复消息，weixin订阅自动回复欢迎消息；
8. 自动检测关键词冲突；
9. 自由设置纯文本消息、图文消息、最近消息，可随时切换消息类型，排序；
10. 图片上传管理都使用Wordpress原生图片管理器。


*** 使用作弊方法来解决一些服务器无法通过token验证的问题 ***

先按照攻略所说的步骤来，插件中设定好token，然后得到用于接受消息的url，带着这个token和url跑去微信的官方管理后台绑定，要是怎么搞都是无法验证通过，那么请你死马当活马医，把wordpress根目录中的index.php备份了，接着把插件包中的__wechatsucks__.php这文件改名成index.php，复制到wordpress根目录下。

这时候，再跑去验证试试看，还是用刚才的token和url，不是十分倒霉的话，这时候应该已经验证通过了。把那个假的index.php删掉，恢复之前备份的那个index.php。

搞这个需要一定的技术常识，不会的话找个懂事儿的去弄。（如果这样都不行，那么就只能换别的插件，或者别的服务器供应商试试看了。）

———————————————————————

=English=

This is a simple WeChat public platform plug-in for subscription accounts. Current version of the plug-in now supports ordinary subscription account only, anyone Register free WeChat public platform with subscription account can get full functionality of this plug-in, no need pay for a certified to upgrade your account.

Features:

1. Absolutely no need any other framework to install.
2. Easy to manage multiple weixin message template.
3. Set automatic response by "Search keyword", "Recent messages" and "Random messages".
4. Multiple message type, default reply message, trigger by keywords and new weixin subscriber join in. you can switch thier types any time.
5. Automatic check keywords conflict.
6. Free to set message type any time. both text message , graphic news message and recent news message.
7. Use native wordpress media manage tool to upload pitcures.

Github: <a href="https://github.com/Soopro/wechat_subscribers">https://github.com/Soopro/wechat_subscribers</a>.


*** Fix token can’t valid problem ***

First you have to follow the regular steps to setup this plugin, After you meet the problem can’t valid your token or time out… I provider a crack file __wechatsucks__.php, try use it to replace wordpres’s index.php temporary, and try to valid again. Good luck!

———————————————————————


== Installation ==
=汉语=

1. 下载走。
2. 复制到Wordpress的插件目录，例如: /wp-content/plugins
3. 玩儿者吧！

请访问 Github: <a href="https://github.com/Soopro/wechat_subscribers">https://github.com/Soopro/wechat_subscribers</a> 获得帮助.

=English=

1. Download it.
2. Copy to your wordpress plugins folder etc., /wp-content/plugins
3. Enjoy it.

Please visit Github: <a href="https://github.com/Soopro/wechat_subscribers">https://github.com/Soopro/wechat_subscribers</a> get more help.


== Frequently Asked Questions ==

请访问 Github: <a href="https://github.com/Soopro/wechat_subscribers">https://github.com/Soopro/wechat_subscribers</a> 获得帮助.

Please visit Github: <a href="https://github.com/Soopro/wechat_subscribers">https://github.com/Soopro/wechat_subscribers</a> get more help.


== Screenshots ==

1. 安装后激活插件，左侧的菜单中会出现一微信(weixin/Wechat)一栏。
2. 在Wordpress的设置菜单中多了微信(weixin/Wechat)一项，到这里设置你的Token，这个可以随便写，字母、符号、数字都可以，汉字的不要。插件会替你生成一个URL。URL和Token将在后面用到。
3. 然后去微信(weixin/Wechat)公众平台上绑定你所设置的Token和URL。
4. 回到插件的微信(weixin/Wechat)管理界面，在这里可以添加自定义回复消息，这些自定义消息会根据条件自动回复给向你的微信公众号发消息的订阅者。
5. 添加或者编辑一条新自定义回复消息时，首先设置基本项目。关键字可以多个，但是要用“,”逗号隔开。选择触发方式中除了关键词，还可以选择“默认”那么当没有任何关键字匹配的时候就会使用这条默认发送，而选择“订阅”则这条消息会在新订阅者加入以后触发。选择消息类型可以切换“纯文本”，“图文消息”或是“最近消息”。最后要记得勾选“发布”，这样保存以后系统就会按照设置的规则自动回复用户消息了。
6. 纯文本消息很简单，只要输入你的消息文字即可，也可以插入已有的文章或图片内容，标题会裁剪至80字，正文会裁剪至500字。
7. 编辑图文消息的时候，必要选择一张图片，第一组图文内容的图片尺寸是360x200，之后的为200x200，后面的消息简述则可以选填。
8. 编辑图文的时候也可以直接同步已有的文章或页面，插件会获取用户选择的文章或页面插入到图文编辑的表单中，消息描述会选择文章的摘要，如果没有则提取正文的前140个字符。
9. 上传图片的时候将使用Wordprss原生的图片上传工具。传完以后选一个即可，插件会自动裁剪这两张规格的图片，名称为微信大图和微信小图，可以在插入图片弹出框右下角尺寸选择栏里选择，如果没有显示，确保服务器安装了gd库。
10. 图文消息可以添加最多10组，点击右下角的按钮添加。
11. 单组图文消息可以点击右上角的箭头上下移动，依次来排列消息的顺序。点击每组图文消息右下角的移除按钮可以去掉这组内容。
12. 图文消息类型,可以直接同步已有的文章、页面或其它post_type的内容至图文表单中，只需点击同步按钮，在弹出窗口选择相应条目即可。其中如果同步的对象有特色图像，将会载入特色图像的合适尺寸到图像中，没有则会寻找文章中的第一张图片，都没则会自动插入插件提供的默认图片，用户也可以自行上传或选择媒体库的图片。（注：本地上传的图片会自动裁剪生成适合微信的尺寸，在插入图片弹出框右下角进行尺寸选择即可）也可以点击插入URL按钮，只插入选择对象的链接地址。
13. 最近消息类型，只需要选择自动回复的类型，分类和数量即可。
14. 用户用户发送的消息记录，点击左边消息统计进入页面进行查看管理。

== Changelog ==

=汉语=

2016年5月3日 更新到 1.6.6

1. 修正了一些自动回复搜索结果问题

2016年5月3日 更新到 1.6.5

1. 修正了一些JS问题

2016年4月29日 更新到 1.6.4

1. 在设置中增加了自定义默认图片
2. 修改检查冲突关键字的逻辑
3. 修正了一些bug

2015年5月4日 更新到 1.6.2

1. 忘了修正了什么。。。。

2015年5月2日 更新到 1.6.1

1. 修正了 Wordpress 4.2.1 以后列表无法显示的问题

2015年2月25日 更新到 1.60

1. 增加了回复“随机文章”
2. 修正了关键字搜索的设置

2014年9月28日 更新到 1.58

1. 修改了上传的JS接口，支持引入外链图片

2014年8月31日 更新到 1.57

1. 修改了插件使用的权限

2014年8月3日 更新到 1.56

1. 修改了返回消息的字数限制

2014年8月3日 更新到 1.55

1. 修正了同步文章时发生的AJAX错误
2. 增加了自动回复关键字搜索结果

2014年8月2日 更新到 1.53

1. 修正了一些版本PHP环境无法激活的问题

2014年8月2日 更新到 1.52

1. 修正了一些乌龙BUG

2014年8月2日 更新到 1.51

1. 修改了个吧命名错误。
2. 增加了一个用来解决一些服务器无法验证通过token的作弊文件

2014年7月30日 更新到 1.50

1. 增加了编辑自定义消息的时候选择已有的各种类型文章“同步”或者“插入”到微信回复中
2. 增加了最近消息回复回复类型
3. 增加了图片上传时自动裁剪至适合微信显示的尺寸
4. 增加了用户访问统计管理

2014年3月14日 更新到 1.04

1. 修正了微信接口参数排序修改导致了无法响应的问题

2014年3月12日 更新到 1.03

1. 修正了 “请求URL超时” 的问题。
2. 增加了Token最大字符数量限制。

2014年3月9日 更新到 1.02

1. 修正了一些文本错误。
2. 修正当输入图文消息后，中文转换编码错误的问题

2014年3月5日 更新到 1.01

1. 修正了设置TOKEN时候可能误输入奇葩字符导致接口URL错误的问题。

=English=

2016 May 3 Update to 1.6.6

1. Fixed search result bugs.


2016 May 3 Update to 1.6.5

1. Fixed some js bugs.

2016 April 29 Update to 1.6.4

1. Add custom default image on settings.
2. Change keywords conflict rules.
3. Fixed some bugs.

2015 May 4 Update to 1.6.2

1. Some bugs....

2015 May 2 Update to 1.6.1

1. Fixed Wordpress 4.2.1 WP_LIST_TABLE not display correctly.

2015 February 25 Update to 1.6.0

1. Add "Random messages".
2. Fixed "Search keyword" settings problem.

2014 September 28 Update to 1.5.8

1. Change the custom-upload.js to support online pictures.

2014 August 31 Update to 1.5.7

1. Change the permissions to use this plugin.

2014 August 3 Update to 1.5.6

1. Modify contents words limit.

2014 August 3 Update to 1.5.5

1. Fixed ajax error while sync a post.
2. Add automatic search by keywords.

2014 August 2 Update to 1.5.3

1. Fixed some php version unable to active problem.

2014 August 2 Update to 1.5.2

1. Fixed some stupid bugs.....

2014 August 2 Update to 1.51

1. Fixed some naming problem.
2. Add a crack file for “token no response” or “time out“ problem.

2014 July 30 Update to 1.5.0

1. Add multiple types Posts insert/sync to a custom Wexin/WeCchat reply message.
2. Increase the types of recent news Reply
3. Increased upload pictures automatically cropped to fit the Wexin/WeChat display size.
4. Increased user access statistics management

2014 March 14 Update to 1.0.4

1. Fixed WeChat callback sort parameter cause no response problem.


2014 March 12 Update to 1.0.3

1. Fixed URL Time Out problem.
2. Add Token character limited


2014 March 9 Update to 1.0.2

1. Fixed some text issues.
2. Fixed json_encode() Chinese text unicode issues.

2014 March 5 Update to 1.0.1

1. Fix strange symbol in 'token' will mass up interface url.

== Upgrade Notice ==
Update to 1.6.1
Update to 1.6.0
Update to 1.5.8
Update to 1.5.7
Update to 1.5.6
Update to 1.5.5
Update to 1.5.2
Update to 1.0.2
Update to 1.0.1

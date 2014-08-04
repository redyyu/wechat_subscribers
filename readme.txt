=== WeChat Subscribers Lite 微信公众订阅号插件 ===
Name: WeChat Subscribers Lite 微信公众订阅号插件
Contributors: redyyu, Gu Yue
Tags: weixin,wechat,微信,subscribers,微信公众平台,wx,订阅号
Donate link: http://www.imredy.com/wp_wechat/
Requires at least: 3.7
Tested up to: 3.9.1
Stable tag: 3.9.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

=汉语=

***增加了一个作弊文件，用来解决一些服务器无法通过token验证的问题***

使用方法：先按照攻略所说的步骤来，插件中设定好token，然后得到用于接受消息的url，带着这个token和url跑去微信的官方管理后台绑定，要是怎么搞都是无法验证通过，那么请你死马当活马医，把wordpress根目录中的index.php备份了，接着把插件包中的__wechatsucks__.php这文件改名成index.php，复制到wordpress根目录下。

这时候，再跑去验证试试看，还是用刚才的token和url，不是十分倒霉的话，这时候应该已经验证通过了。把那个假的index.php删掉，恢复之前备份的那个index.php。

搞这个需要一定的技术常识，不会的话找个懂事儿的去弄。（如果这样都不行，那么不是你的服务器和微信不合，就是微信和你的服务器不合。换供应商是唯一的途径了。）

———————————————————————

新版本最大的更新是支持了“可选关键字搜索模式（需默认触发）”，“同步文章内容”（支持图文和文字消息），“自动回复最新内容”（仅支持图文消息模式），“消息历史记录”，此版本由苦工－古月，担任全部php开发工作。

如果发现任何bug或者有什么新功能需求，欢迎朝我发送电子邮件。<a href="mailto:redy.ru@gmail.com">redy.ru@gmail.com</a>

这是一个简单通用的微信(weixin)公众平台订阅号专用插件。现在这个版本的插件只支持普通订阅号，任何人只要以个人身份免费注册微信公众平台就可以足以使用这个插件的全部功能，不需要专门为了这个插件去付费获得(weixin)公众号认证。

另外要感谢以下这些人的帮助这个插件成长：
Limit Lin


这个插件将永久免费：）

特色：

1. 可设定默认回复为搜索关键字结果；
2. 可根据类型（Post-type）设定自动回复最新文章；
3. 可选择某篇文章内容，并将它同步到自动回复中；
4. 便捷管理多种weixin消息模版，可随时切换，数量不限；
5. 无需安装任何其他程序，完全使用Wordpress原生支持；
6. 带有接收消息的历史记录；
7. 多种消息模式，默认自动回复消息，关键词自动回复消息，weixin订阅自动回复欢迎消息；
8. 自动检测关键词冲突；
9. 自由设置纯文本消息、图文消息、最近消息，可随时切换消息类型，排序；
10. 图片上传管理都使用Wordpress原生图片管理器。

访问插件主页获得更多帮助: <a href="http://www.imredy.com/wp_wechat">http://www.imredy.com/wp_wechat</a>.

=English=

***Fix token can’t valid problem***

First you have to follow the regular steps to setup this plugin, After you meet the problem can’t valid your token or time out… I provider a crack file __wechatsucks__.php, try use it to replace wordpres’s index.php temporary, and try to valid again. Good luck!

———————————————————————

New version support “Response by keyword search”,“synchronous Article contents" (supporting news and text messages), "Automatic Replies Recently Post” (news only), "Message History”, This release is develop by GuYue.

This is a simple WeChat public platform plug-in for subscription accounts. Current version of the plug-in now supports ordinary subscription account only, anyone Register free WeChat public platform with subscription account can get full functionality of this plug-in, no need pay for a certified to upgrade your account.

Features:

1. Absolutely no need any other framework to install. 
2. Easy to manage multiple weixin message template.
3. Multiple message type, default reply message, trigger by keywords and new weixin subscriber join in. you can switch thier types any time.
4. Automatic check keywords conflict.
5. Free to set message type any time. both text message , graphic news message and recently news message.
6. Use native wordpress media manage tool to upload pitcures.

Please visit <a href="http://www.imredy.com/wp_wechat">http://www.imredy.com/wp_wechat</a>.


== Installation ==
=汉语=

1. 下载走。
2. 复制到Wordpress的插件目录，例如: /wp-content/plugins
3. 玩儿者吧！

请访问 <a href="http://www.imredy.com/wp_wechat">http://www.imredy.com/wp_wechat</a> 获得帮助.

=English=

1. Download it.
2. Copy to your wordpress plugins folder etc., /wp-content/plugins
3. Enjoy it.

Please visit <a href="http://www.imredy.com/wp_wechat">http://www.imredy.com/wp_wechat</a> get full help.

== Frequently Asked Questions ==
请访问 <a href="http://www.imredy.com/wp_wechat">http://www.imredy.com/wp_wechat</a> 获得帮助.

Please visit <a href="http://www.imredy.com/wp_wechat">http://www.imredy.com/wp_wechat</a> get full help.

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

2014 August 3 Update to 1.56

1. Modify contents words limit.

2014 August 3 Update to 1.55

1. Fixed ajax error while sync a post.
2. Add automatic search by keywords.

2014 August 2 Update to 1.53

1. Fixed some php version unable to active problem.

2014 August 2 Update to 1.52

1. Fixed some stupid bugs.....

2014 August 2 Update to 1.51

1. Fixed some naming problem.
2. Add a crack file for “token no response” or “time out“ problem.

2014 July 30 Update to 1.50

1. Add multiple types Posts insert/sync to a custom Wexin/WeCchat reply message.
2. Increase the types of recent news Reply 
3. Increased upload pictures automatically cropped to fit the Wexin/WeChat display size. 
4. Increased user access statistics management

2014 March 14 Update to 1.04

1. Fixed WeChat callback sort parameter cause no response problem.


2014 March 12 Update to 1.03

1. Fixed URL Time Out problem.
2. Add Token character limited


2014 March 9 Update to 1.02

1. Fixed some text issues.
2. Fixed json_encode() Chinese text unicode issues.

2014 March 5 Update to 1.01

1. Fix strange symbol in 'token' will mass up interface url.

== Upgrade Notice ==
Update to 1.56
Update to 1.55
Update to 1.52
Update to 1.02
Update to 1.01

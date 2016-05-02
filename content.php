<?php
$content=array();


//English
$content['header']='<h1>'.__('WeChat Subscribers Lite','WPWSL').'</h1>
<p>This is a simple WeChat public platform plug-in for subscription accounts. Current version of the plug-in now supports ordinary subscription account only, anyone Register free WeChat public platform with subscription account can get full functionality of this plug-in, no need pay for a certified to upgrade your account.</p>';

$content['tips_phmsg']='<p>You can attach multiple picture and text item intro one Photo message, but only the first one will show up large photo. you can add 9 more item in this message, then use the arrow right top of the box to move up and move down the message item. The URL can link to any website, make sure your target website is available and safety.</p>';

$content['tips_content']='<p>If you find any problem with this plugin please <a href="mailto:redy.ru@gmail.com">contact me</a>. You can also <a href="http://imredy.com/wp-wechat/" target="_blank">click here</a> to get online help.</p><p><img src="'.WPWSL_PLUGIN_URL.'/img/qr_wp_wechat.png" /></p>';

$locale=get_locale();
if(stripos('-'.$locale,'zh')){

	$content['header']='<h1>'.__('WeChat Subscribers Lite','WPWSL').'</h1>
	<p>这是一个通用的微信公众平台订阅号专用插件。只支持普通订阅号，任何人只要以个人身份免费注册微信公众平台就可以足以使用这个插件的全部功能，不需要转门为了这个插件去付费获得公众号认证。</p>';

	$content['tips_phmsg']='<p>你可以在一个图文消息中，添加多组图文，但是只有第一组会显示大图。除去第一组图文，你还可以添加最多9组。你可以通过右侧的箭头上下移动附加图文。图文消息的URL可以直接链接到任何地址，但是为了保证正常使用，希望你填写地址前确认地址可以打开，尽可能使用简单的URL。</p><p>如果你连接过去的网站别人打不开，那么可能目标网址被墙了，或者目标网址是个淘宝支付宝地址。</p>';

	$content['tips_content']='<p>如果你使用这个插件遇到任何问题，<a href="mailto:redy.ru@gmail.com">请联系我</a>。也可以扫码加入我的<a href="http://imredy.com/wp-wechat/" target="_blank">在线支持</a>:</p><p><img src="'.WPWSL_PLUGIN_URL.'/img/qr_wp_wechat.png" /></p>';

}
?>
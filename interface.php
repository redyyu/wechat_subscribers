<?php
/**
  * WeChat Interface
  * 
  * 
  *   
  */
global $token;

define('IS_DEBUG', false);

$wechatObj = new wechatCallbackapi($token);

$valid=$wechatObj->valid();

if($valid){
	$wechatObj->responseMsg(get_data());
}else{
	header('Location: '.home_url());
}
exit;

class wechatCallbackapi{

	private $token;
	private $data;
	
	public function __construct($_token, $_data=null){
		$this->token=$_token;
		if($_data!=null){
			$this->load($_data);
		}
	}
	
	public function load($_data){
		$this->data=$_data;
	}
	
	public function valid(){
		if(isset($_GET["echostr"])){
	    	$echoStr = $_GET["echostr"];
	    }
	    //valid signature , option
	    if($this->checkSignature()){
	    	if(isset($echoStr) && $echoStr!=''){
	    		echo $echoStr;
	    		exit;
	    	}
	    	return true;
	    }else{
	    	return false;
	    }
	}

    public function responseMsg($_data=null){
    	if($_data!=null){
    		$this->load($_data);
    	}
    	
		//get post data, May be due to the different environments
		if(IS_DEBUG){
			$postStr="<xml>
						<ToUserName><![CDATA[toUser]]></ToUserName>
						<FromUserName><![CDATA[fromUser]]></FromUserName> 
						<CreateTime>1348831860</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[1]]></Content>
						<MsgId>1234567890123456</MsgId>
						</xml>";
		}else{
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		}
		
      	//extract post data
		if (!empty($postStr) && $this->checkSignature() && isset($this->data)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				$msgType=$postObj->MsgType;

				if($msgType=='event'){
					$msg=$this->eventRespon($postObj);
				}else{
					$msg=$this->sendAutoReply($postObj);
				}
				echo $msg;
        }else {
        	echo "";
        	exit;
        }
    }
	
	private function sendAutoReply($postObj){

        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
		$resultStr='';
		
		$is_match=false;
		
		if($keyword!=''){
			foreach($this->data as $d){
				if($d->trigger=='default' || $d->trigger=='subscribe'){
					continue;
				}
				$curr_key=$d->key;
				foreach($curr_key as $k){
					if(strtolower($keyword) == strtolower(trim($k))){
							$is_match=true;
					}
				}
				
				if($is_match){
					$resultStr =$this->get_msg_by_type($d, $fromUsername, $toUsername);
					break;
				}
				
			}
		}
		
		if(!$is_match){
			foreach($this->data as $d){
				if($d->trigger=='default' && !$is_match){
					$is_match=true;
					if($is_match){
						$resultStr =$this->get_msg_by_type($d, $fromUsername, $toUsername); 
						break;
					}
				}
			}
		}
		return $resultStr;
	}
	
	private function eventRespon($postObj){
		
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
		$eventType=$postObj->Event;
		$resultStr='';
		
		foreach($this->data as $d){
			if($d->trigger == $eventType){
				$resultStr =$this->get_msg_by_type($d, $fromUsername, $toUsername); 
				break;
			}
		}
		
		return $resultStr;
	}
	
	private function get_msg_by_type($d, $fromUsername, $toUsername){
		switch($d->type){
			case "news":
				$resultStr = $this->sendPhMsg($fromUsername, $toUsername, $d->phmsg);
			break;
			default: //text
				$resultStr = $this->sendMsg($fromUsername, $toUsername, $d->msg);
		}
		
		return $resultStr;
	}
	
	private function sendMsg($fromUsername, $toUsername, $contentData){

		if($contentData==''){
			return '';
		}
	
        $textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";

		$msgType = "text";
		$time = time();
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentData);
		return $resultStr;
	}
	
	private function sendPhMsg($fromUsername, $toUsername, $contentData){
		if($contentData==''){
			return '';
		}
		
        $headerTpl = "<ToUserName><![CDATA[%s]]></ToUserName>
			        <FromUserName><![CDATA[%s]]></FromUserName>
			        <CreateTime>%s</CreateTime>
			        <MsgType><![CDATA[%s]]></MsgType>
			        <ArticleCount>%s</ArticleCount>";
			        
		$itemTpl=  "<item>
					<Title><![CDATA[%s]]></Title> 
					<Description><![CDATA[%s]]></Description>
					<PicUrl><![CDATA[%s]]></PicUrl>
					<Url><![CDATA[%s]]></Url>
					</item>";
		$itemStr="";
		$mediaCount=0;
		foreach ($contentData as $mediaObject){
			$title=$mediaObject->title;
			$des=$mediaObject->des;
			$media=$mediaObject->pic;
			$url=$mediaObject->url;
			$itemStr .= sprintf($itemTpl, $title, $des, $media, $url);
			$mediaCount++;
		}
		
		$msgType = "news";
		$time = time();
		$headerStr = sprintf($headerTpl, $fromUsername, $toUsername, $time, $msgType, $mediaCount);
		$resultStr ="<xml>".$headerStr."<Articles>".$itemStr."</Articles></xml>";

		return $resultStr;
	}
	
	private function checkSignature(){
		if(IS_DEBUG){
			return true;
		}
		$signature =isset($_GET["signature"])?$_GET["signature"]:'';
		$timestamp =isset($_GET["timestamp"])?$_GET["timestamp"]:'';
        $nonce = isset($_GET["nonce"])?$_GET["nonce"]:'';	
        		
		$token = $this->token;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr,SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

function get_data(){
	$args = array(
			'post_type' => 'wpwsl_template',
			'posts_per_page' => -1,
			'orderby' => 'date',
			'post_status' => 'publish',
			'order'=> 'DESC'
	);
	
	$raw=get_posts($args);
	
	$data = array();
	
	foreach($raw as $p){
		$_gp=get_post_meta($p->ID,'_phmsg_item');
		$phmsg_group=array();
		
		foreach($_gp as $_item){
			$_tmp_item=json_decode($_item);
			
			$_tmp_item->title=urldecode($_tmp_item->title);
			$_tmp_item->pic=urldecode($_tmp_item->pic);
			$_tmp_item->des=urldecode($_tmp_item->des);
			$_tmp_item->url=urldecode($_tmp_item->url);
		
			$phmsg_group[]=$_tmp_item;
		}
		$tmp_key=trim(get_post_meta($p->ID,'_keyword',TRUE));
		$array_key=explode(',', $tmp_key);
		
		
		$tmp_msg=new stdClass();
		
		$tmp_msg->title=$p->post_title;
		$tmp_msg->type=get_post_meta($p->ID,'_type',TRUE);
		$tmp_msg->key=$array_key;
		$tmp_msg->trigger=get_post_meta($p->ID,'_trigger',TRUE);
		$tmp_msg->msg=get_post_meta($p->ID,'_content',TRUE);
		$tmp_msg->phmsg=$phmsg_group;
	
		$data[]=$tmp_msg;
	}
	
	return $data;
}
?>
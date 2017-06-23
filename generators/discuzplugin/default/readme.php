<?php
/**
 * This is the template for generating the ActiveQuery class.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $className string class name */
/* @var $modelClassName string related model class name */




$data = [
	'Title'=>'Discuz! Plugin',
	'version'=>'X3.2',
	'installfile'=>'install.php',
	'uninstallfile'=>'uninstall.php',
	'Data'=>[
		'plugin'=>[
			'available'=>'1',								//插件是否可用，1=是，0=否
			'adminid'=>'1',									//使用系统设置中插件接口自带的插件参数设置程序所需的最低权限等级要求，1=管理员，2=超级版主，3=版主
			'name'=>'扫描件app',							//插件名称
			'identifier'=>'myapp3',							//插件惟一标识符
			'description'=>'显示楼主最近安装过的应用。',	//插件简介
			'datatables'=>'',								//插件数据表，不包含前缀，多个表使用半角逗号“,”分隔
			'directory'=>'myapp2/',							//插件所在目录，例如设置为 comsenz_bank，则对应论坛目录的位置为 ./plugins/comsenz_bank/
			'copyright'=>'dream_zml@163.com',				//插件版权信息
			'version'=>'2.0',								//插件版本信息
			'__modules'=>[									//插件模块信息，数组格式，使用 serialize() 序列化后存放
				[
					'name'=>'myapp2',
					'menu'=>'',
					'url'=>'',
					'type'=>'11',
					'adminid'=>'0',
					'displayorder'=>'0',
					'navtitle'=>'',
					'navicon'=>'',
					'navsubname'=>'',
					'navsuburl'=>'',
				],
				[
					'name'=>'showactivity_setting',
					'menu'=>'上车',
					'url'=>'',
					'type'=>'3',
					'adminid'=>'0',
					'displayorder'=>'0',
					'navtitle'=>'',
					'navicon'=>'',
					'navsubname'=>'',
					'navsuburl'=>'',
				],
				[
					'name'=>'wechat_setting',
					'menu'=>'下车',
					'url'=>'',
					'type'=>'3',
					'adminid'=>'0',
					'displayorder'=>'0',
					'navtitle'=>'',
					'navicon'=>'',
					'navsubname'=>'',
					'navsuburl'=>'',
				],
			],
		],
		'var'=>[
			[
				'displayorder'=>'1',
				'title'=>'显示的数量',
				'description'=>'',
				'variable'=>'shownum',
				'type'=>'number',
				'value'=>'3',
				'extra'=>'',
			],
		],
	],
];



/**
 * 拼接成xml
 * @param  [type]  $data [description]
 * @param  integer $loop [description]
 * @return [type]        [description]
 */
function toXml($data, $loop=1){
	$item = [];
	$pre = '';
	$loop++;
	for($i=1;$i<$loop;$i++){
			$pre .= '	';
	}
	foreach ($data as $k => $v) {
		if(is_array($v)){
			$str = toXml($v,$loop);
			$item[] = "$pre<item id=\"$k\">\n$str\n$pre</item>";
		}else{
			$item[] = "$pre<item id=\"$k\"><![CDATA[$v]]></item>";
		}
	}
	return join("\n",$item);
}

$xmlStr = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n<root>\n";
$xmlStr .= toXml($data);
$xmlStr .= "</root>";
echo $xmlStr;
//exit;
/*
$xml = $dom->saveXML();
// $xml = urldecode($xml);
$xml = htmlspecialchars_decode($xml);
// $xml = str_replace("<item", "\n<item", $xml);
$xml = str_replace("</item><item id", "</item>\n	<item id", $xml);
$xml = str_replace("\"><item id", "\">\n	<item id", $xml);
$xml = str_replace("</item></item>", "</item>\n		</item>", $xml);
$xml = str_replace("</item></item>", "</item>\n		</item>", $xml);
$xml = str_replace("<root><item", "<root>\n	<item", $xml);
$xml = str_replace("</item></root>", "</item>\n</root>", $xml);
// $xml = json_encode($xml);
//$xml = json_decode($xml,true);
echo $xml;

*/


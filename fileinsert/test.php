<?php
require('./library/FileInsertClass.php');
header('content-type:text/html;charset=utf-8');
error_reporting(E_ALL ^ E_NOTICE);
$filename = dirname(__FILE__)."/test.txt";      //文本的最后一行末尾要换行一个空行  否则读取不了最后一行
$m = new FileInsert($filename,'dataHandle',1);

$start = (int)trim($_POST['start']);
$arr   = $m->read($start);
echo json_encode($arr);



/**
 * [dataHandle 回调函数，处理数据]
 * @param  [array] $data [读取出来的每一行的数据组成的数组]
 * @return [boolean]     [返回true或者false]
 */
function dataHandle($data){
	//这里做数据处理,写入数据库或者其他操作
	return true;
}


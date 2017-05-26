<?php

class FileInsert{
    private $filename;   //源文件名
    private $dealArr;   //回调函数
    
    /**
     * 初始化
     * @param  string $filename  需要检索的文件
     * @param  string arr        回调函数,用来处理获取到的数据  
     * @return [type]            [description]
     */
    public function __construct($filename,$arr){
        $this->filename = $filename;
        $this->dealArr  = $arr;
    }


    
    public function receive(){
        if($p){
            $this ->assign('filename',$eid.'_g.txt');
            $this ->assign('eid',$eid);
            $this ->assign('uid',$uid);
            $this ->display();
        }

    }

    
    public function read() {
        $sFile = trim(I('fname'));
        $start = (int)trim(I('start',0));
        $get=self::getFileLine($sFile,$start,1000);
        $the_arr=explode ("\n",$get['content']);

        foreach($the_arr as $k=>$v){
            $tmp = explode ("\t",$v);
            $cas = trim($tmp[0]);
            if(!empty($cas)){
                if(self::dataHandle((array)$tmp)){
                    // $c.= "cas:".$cas.'处理<span style="color:green">成功</span><br />';
                }else{
                    $e.= "cas:".$cas.'处理<span style="color:red">失败</span><br />';
                }
            }
            
        }
            $res_arr['content'] = $c.$e;
            $res_arr['length']  = $get['length'];
            $res_arr['is_end']  = $get['is_end'];
            echo json_encode($res_arr);
    }


    /**
     * [getFileLine 按行读取文件数据]
     * @param  [string] $file  [文件路径]
     * @param  [int] $start    [开始字节数]
     * @param  [int] $step     [一次读取行数]
     * @return [array]         [description]
     */
    public static function getFileLine ($file,$start,$step) {
        $sTmp = '';
        try {
            if (false === ($fp = fopen ($file, 'r'))) {
                throw new Exception ('Failed to open file : '.$file);
            }
    
            if ( -1 === (fseek ($fp, $start, SEEK_SET))) {
                throw new Exception ('Failed to  modify cursor on : '.$file);
            }
        
            $iEnd = 0;
            while ($iEnd < $step) {
                $sTmp .= @fgets ($fp);
                $iEnd ++;

                if(feof($fp)){
                   $arr['is_end'] = 1;
                }
            }

            @fclose ($fp);
        } catch (Exception $e) {
            echo 'wrong';
        }
        $arr['length'] = strlen($sTmp);
        $arr['content']= $sTmp;
        return $arr;
    }

}
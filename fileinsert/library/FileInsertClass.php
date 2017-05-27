<?php

class FileInsert{
    private $filename;   //源文件名
    private $callback;    //回调函数
    private $rows;      
    
    /**
     * 初始化
     * @param  string $filename  需要检索的文件
     * @param  string arr        回调函数,用来处理获取到的数据  
     * @param  string            每一次提交读取处理的行数
     * @return [type]            [description]
     */
    public function __construct($filename=null,$arr,$rows=1){
        $this->filename = $filename;
        $this->callback = $arr;
        $this->rows     = $rows;
    }


    //处理没一行读取的数据,$s为开始读取的字节数
    public function read($s) {
        $sFile   = $this ->filename;
        $start   = $s;
        $get     = self::getFileLine($this->filename,$start,$this->rows);
        $the_arr = explode ("\n",$get['content']);
        array_pop($the_arr);

        foreach($the_arr as $k=>$v){
            $tmp = explode ("\t",$v);
            $c = '';
            $e = '';
            if($this->callback) { 
                $callback = $this->callback;
                if (is_callable($this->callback)) {
                    if(call_user_func($callback,(array)$tmp)){
                        $c.= $tmp[0].'<span style="color:green">处理成功</span>';
                    }else{
                        $e.= $tmp[0].'<span style="color:red">处理失败</span>';
                    }
                }else{
                    $e.= '<span style="color:red">回调函数调用失败</span>';
                }
            }else{
                $e.= '<span style="color:red">找不到回调函数</span>';
            }    
        }


            $res_arr['content'] = $c.$e;        
            $res_arr['length']  = $get['length'];
            $res_arr['is_end']  = $get['is_end'];
            return $res_arr;
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
        $arr['is_end'] = 0;
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
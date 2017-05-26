<?php
$filename = dirname(__FILE__)."/";
$m = new FileInsert("test.txt",'dataHandle');
echo $m->search(95500736);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	 <script src="__PUBLIC__/home/js/jquery.min.js"></script>
</head>
<body>
	<div id="con" attr="<?php echo $filename; ?>"></div>
	
<script type="text/javascript">
	var fname = $('#con').attr('attr');
    noTimeOut(0,fname);
	function noTimeOut(s,fname){
		var start = s;
		$.ajax({
			url:'read',
			data:{start:start,fname:fname},
			type:'post',
			datatype:'text',
			success:function(data) {

				if(data['is_end']==1||data['length']==0){
					alert('数据导入完成');	
				}else{
					start += data['length'];
					$('#con').append(data['content']+'--'+data['length']+'--'+start+'<br />');
					noTimeOut(start,fname);	
				}
			}
		});
	}
	

</script>
	
</body>
</html>
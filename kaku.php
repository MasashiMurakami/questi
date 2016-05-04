<?php
	define ("DEBUG", "ON");
	include("debug.ini");
	debugprint($_POST);
	
	//アンケート結果のtxtファイルへの書き出し
	if($_POST['name'] && $_POST['music']) {
		date_default_timezone_set('Asia/Tokyo');
		$now = date("m/d H:i:s");
		$ip = getenv("REMOTE_ADDR");
		$kotai = $_SERVER['HTTP_USER_AGENT'];
		//書き込むデータの整形、時間,IPアドレス,SD評価値,名前,曲名
		$tuiki = $now.",".$ip;
		
		foreach($_POST as $var) {
			if(preg_match("/^[-]?[0-9]+$/",$var)) {
				if($var<-250) $var=-3;
				else if(-250 <= $var && $var < -150) $var=-2;
				else if(-150 <= $var && $var < -50) $var=-1;
				else if(-50 <= $var && $var < 50) $var=0;
				else if(50 <= $var && $var < 150) $var=1;
				else if(150 <= $var && $var < 250) $var=2;
				else if(250 <= $var) $var=3;
				else echo $var;
			}
			$tuiki .= ",". $var;
		}
		$tuiki .= "\n";
		$fp = fopen("data.csv","r+") or die("Cannot Open File.");
		echo '<p>CSV Result.</p>';
		echo '<table border="1">';
		while($csv = fgetcsv($fp)) {
			echo '<tr>';
			foreach($csv as $value)
				echo '<td>'.htmlspecialchars($value).'</td>';
			echo '</tr>';
		}
		echo '</table>';
		flock($fp, LOCK_EX);
		//ファイルを読み込んで追記
		fputs($fp,$tuiki);
		flock($fp, LOCK_UN);
		fclose($fp);
	} else {
		$message = "<p>もう一度戻って入力してください。";
		echo $message;
	}
	
	//アンケート結果処理
	//回答状況をカウントする。
//	$q1_1_n =mb_substr_count($csv,"q1_1");
	//グラフ用に実数掛ける×10する。（棒グラフのwidthを設定する）
//	$q1_1 = $q1_1_n*10;
?>
 
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Result</title>
	<link href="css.css" rel="stylesheet" type="text/css">
</head>
<body>
	<p>Summary Result</p>
	<table border="0" cellspacing="0" cellpadding="0">
		<tr align="center" bgcolor="#FFFFCC"><td>Subject</td><td>Graph</td><td>Score</td></tr>
<?// for($i=0; $i<18; $i++) {?>
<!--
		<tr><td>SD<? echo $i+1?></td><td><img src ="bou.gif" width="<?echo $q1_1 ?>" height="4"></td><td><?echo $q1_1_n?>名</td></tr>
-->
<?// } ?>
	</table>
	<br>
	
	<p>Recent Connect Number : Date : Name : Music</p>
<?
		$filepath=file("data.csv");
		//ファイルを逆順にする
		$fd = array_reverse($filepath);
		//ファイルをカンマで区切る処理を繰り返す
		//for($i=0;$i<count($fd);$i++)
		for($i=0; $i<10; $i++)
		{
			$a=explode(",",$fd[$i]);
			$tmp =$i+1;
			echo $tmp.": Date:".$a[0].": Name:".$a[2].": Music:".$a[3]."<br>\n";
		}
?>
	<p><input type="button" onclick="location.href='index2.html'" value="Next" style="width:200px; height:50px; font-size:2.4em">
</body>
</html>
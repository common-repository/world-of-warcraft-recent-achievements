<?php	
	//try 
	//{		
		error_reporting(0);
		$realm = stripslashes($_GET["realm"]);
		$name = stripslashes($_GET["character"]);
		$realmType = $_GET["realmType"];
		$realm = str_replace(" ","+",$realm);
		if ($realmType == "EU")
			$ch = curl_init("http://eu.wowarmory.com/character-achievements.xml?r=$realm&n=$name");
		else
			$ch = curl_init("http://www.wowarmory.com/character-achievements.xml?r=$realm&n=$name");
		
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		
		curl_close($ch);
		$parser = xml_parser_create();
		xml_parse_into_struct($parser, $output,$vals,$index);
		xml_parser_free($parser);
		$count = 0;
		echo("<ul style=\"list-style:none;padding:0px;margin:0px;\">");
		foreach($index["ACHIEVEMENT"] as $test)
		{
			//echo("<li style=\"display:block;height:51px;padding-left:51px;padding-top:5px;background:top left no-repeat url(http://www.wowarmory.com/wow-icons/_images/51x51/" . $vals["$test"]["attributes"]["ICON"] .".jpg)\">");
			echo("<li style=\"display:block;list-style:none;margin:3px;\">");
			echo("<img width=\"20\" src=\"http://www.wowarmory.com/wow-icons/_images/51x51/" . $vals["$test"]["attributes"]["ICON"] .".jpg\">&nbsp;&nbsp;");
			echo("<a href=\"http://www.wowhead.com/?achievement=" . $vals["$test"]["attributes"]["ID"] . "\" target=\"_blank\">");
			echo($vals["$test"]["attributes"]["TITLE"] . "<br/>");
			echo("</a>");
			echo("</li>");
		}
		echo("</ul>");
	//}
	//catch (Exception $e)
	//{
		//echo('Sorry, the armory appears to be down :(');
	//}		
?>


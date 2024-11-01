
function getAchiev(character,realm,realmType,domain,num)
{
	//alert('hello');	
	var myurl = domain + "/wp-content/plugins/world-of-warcraft-recent-achievements/ajax/get_achiev.php";
	var modurl = "character=" + character + "&realm=" + realm.replace(" ","+") + "&realmType=" + realmType;
	jQuery.ajax({
		url: myurl,
		data: modurl,
		type: "GET",
		success: function(msg)
		{
			jQuery("#achiev" + num).html(msg);
		},
		error: function(msg)
		{
			jQuery("#achiev" + num).html('Sorry, the armory appears to be down :(');
		}
	});
}
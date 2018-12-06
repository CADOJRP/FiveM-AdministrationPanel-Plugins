<?php

class antivacbanned
{
    public static function playerJoined($license)
	{
		$userinfo = dbquery('SELECT * FROM players WHERE license="' . escapestring($license) . '"');
        	$steamid = hexdec(strtoupper(str_replace('steam:', '', $userinfo[0]['steam'])));
		$steaminfo = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerBans/v1/?key=" . $GLOBALS['apikey'] . '&format=json&steamids=' . $steamid),true);
		if ($steaminfo['players'][0]['NumberOfVACBans'] >= 1 || $steaminfo['players'][0]['VACBanned'] == 1 || $steaminfo['players'][0]['NumberOfGameBans'] >= 1 || $steaminfo['players'][0]['CommunityBanned'] >= 1)
		{
			removeFromSession($license, "Sorry, but VAC Banned Players are prohibited on " . siteConfig('community_name'));
		}
	}
}
?>

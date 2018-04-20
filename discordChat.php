<?php
/*
 * Name: Discord Chat
 * Description: Logs all server messages into Discord chat.
 * Created Date: Friday, April 20th 2018, 3:35:55 pm
 * Author: Avery Johnson
 *
 * Copyright (c) 2018 Avery Johnson
 */

class discordChat
{
    public static function chatMessage($license, $message) {
        // DISCORD CHAT CONFIG
        $config['webhook'] = "https://discordapp.com/api/webhooks/436974825383264259/kdK71JGK88MUS_JspzwzoxPirj2jA0Xd6vZs1gJeAw1QpeAiFzSn_gKPdp6hzzU1I28y";
        $config['logall'] = false;      // Log all messages including commands (TRUE/FALSE)


        $userinfo = dbquery('SELECT * FROM players WHERE license="' . escapestring($license) . '"');
        $steamid = hex2dec(strtoupper(str_replace('steam:', '', $userinfo[0]['steam'])));
        $usersteam = json_decode(file_get_contents('https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?key=' . $GLOBALS['apikey'] . '&format=json&steamids=' . $steamid));
        $discordMessage = '
			{
				"username": "' . $userinfo[0]['name'] . '",
				"avatar_url": "' . $usersteam->response->players[0]->avatarfull . '",
				"content": "' . $message . '"
			}
		';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $config['webhook']);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(json_decode($discordMessage)));
        if($config['logall'] == true) {
            curl_exec($curl);
        } else {
            if(strpos($message, '/') === FALSE) {
                curl_exec($curl);
            }
        }        
        curl_close($curl);
    }
}

<?php

/*
 * Plugin Name: autoAnnounce
 * Version: 0.0.1
 * Details: Auto announces messages every set amount of minutes.
 * Created Date: Monday, April 17th 2018, 9:26:00 pm
 * Author: Avery Johnson
 *
 * Copyright (c) 2018 Avery Johnson
 */

class autoAnnounce
{
    public static function cronCalled()
    {
        // RANDOM AUTO ANNOUNCE CONFIG
        
        if (date('i') % 2 == 0) {
            exit();
        }

        $warns = 0;
        $kicks = 0;
        $bans = 0;
        $commends = 0;
        $playtime = 0;
        $players = 0;
        $staff = 0;

        foreach (dbquery('SELECT * FROM warnings') as $warn) {$warns++;}
        foreach (dbquery('SELECT * FROM kicks') as $kick) {$kicks++;}
        foreach (dbquery('SELECT * FROM bans') as $ban) {$bans++;}
        foreach (dbquery('SELECT * FROM commend') as $commend) {$commends++;}
        foreach (dbquery('SELECT * FROM players') as $playedtime) {
            $playtime = $playtime + $playedtime['playtime'];
            $players++;
        }

        $playtime = $playtime / 60;

        foreach (dbquery('SELECT * FROM users WHERE rank <> "user"') as $user) {$staff++;}

        $config['messages'] = [
            '^2' . $players . '^0 unique players and counting!',
            '^2' . $playtime . '^0 total hours played on CADOJRP!',
            '^2' . $warns . '^0 warnings, ^2' . $kicks . '^0 kicks, ^2' . $bans . '^0 bans, and ^2' . $commends . '^0 commendations!',
            '^2' . $staff . '^0 total staff members working hard!',  
            'Have a suggestion for the server? Feel free to post on the forums at ^2www.CADOJRP.com^0 or in the Discord.',      
            'Think you have what it takes to be apart of our ^2Staff Team^0? Apply at ^2www.CADOJRP.com',
            'Looking to join a department? Join TeamSpeak at ^2ts.cadojrp.com^0 or apply on our website at ^2www.CADOJRP.com^0.',
            'Roleplaying as a ^2civilian^0? You must use out MDT/CAD at ^2http://www.cad-cadojrp.ga/^0. Failure to do so may result in a warning, kick, or ban.',
            'Make sure to read our rules at ^2https://rules.cadojrp.com^0. Failure to follow the rules may result in a warning, kick, or ban.',
            'Want to talk to other civilians? Join our TeamSpeak at ^2ts.CADOJRP.com',
            'Want to stay up to date? Join our ^4Discord^0 server (^2https://discord.gg/a9uPTQM^0). Our ^4Discord^0 is used for text communication only!',
        ];

        sendMessage($config['messages'][array_rand($config['messages'])]);
    }
}

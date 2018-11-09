<?php

/*
 * Plugin Name: autoBan
 * Version: 0.0.1
 * Details: Automatically ban users at or below 0 trust score.
 * Created Date: Monday, November 9th 2018, 2:32:13 am
 * Author: Avery Johnson
 *
 * Copyright (c) 2018 Avery Johnson
 */

class autoBan
{
    public static function playerWarned($name, $license, $reason)
    {
        error_log('Player Warned: ' . trustScore($license));
        if(trustScore($license) < 0) {
            dbquery('INSERT INTO bans (name, identifier, reason, ban_issued, banned_until, staff_name, staff_steamid) VALUES (
            "' . escapestring($name) . '",
            "' . escapestring($license) . '",
            "Trust Score Below 0%",
            "' . time() . '",
            "0",
            "' . escapestring(siteConfig('community_name')) . ' - Automatic Ban",
            "Unknown"
            )', false);
            removeFromSession($license, "Turst Score Below 0%");
            sendMessage('^3' . $name . '^0 has been permanently banned by ^2' . siteConfig('community_name') . ' - Automatic Ban ^0 for ^Trust Score Below 0%');
        }
    }

    public static function playerKicked($name, $license, $reason)
    {
        error_log('Player Kicked: ' . trustScore($license));
        if(trustScore($license) < 0) {
            dbquery('INSERT INTO bans (name, identifier, reason, ban_issued, banned_until, staff_name, staff_steamid) VALUES (
            "' . escapestring($name) . '",
            "' . escapestring($license) . '",
            "Trust Score Below 0%",
            "' . time() . '",
            "0",
            "' . escapestring(siteConfig('community_name')) . ' - Automatic Ban",
            "Unknown"
            )', false);
            sendMessage('^3' . $name . '^0 has been permanently banned by ^2' . siteConfig('community_name') . ' - Automatic Ban ^0 for ^Trust Score Below 0%');
        }
    }

    public static function playerBanned($name, $license, $reason, $length, $staff)
    {
        error_log('Player Banned: ' . trustScore($license));
        if(trustScore($license) < 0 && $length != 0) {
            dbquery('INSERT INTO bans (name, identifier, reason, ban_issued, banned_until, staff_name, staff_steamid) VALUES (
            "' . escapestring($name) . '",
            "' . escapestring($license) . '",
            "Trust Score Below 0%",
            "' . time() . '",
            "0",
            "' . escapestring(siteConfig('community_name')) . ' - Automatic Ban",
            "Unknown"
            )', false);
            sendMessage('^3' . $name . '^0 has been permanently banned by ^2' . siteConfig('community_name') . ' - Automatic Ban ^0 for ^Trust Score Below 0%');
        }
    }
}

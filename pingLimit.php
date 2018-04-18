<?php

/*
 * Plugin Name: pingLimit
 * Version: 0.0.1
 * Details: Removes people from the server with ping higher than allowed.
 * Created Date: Wednesday, April 18th 2018, 12:52:00 am
 * Author: Avery Johnson
 *
 * Copyright (c) 2018 Avery Johnson
 */

class pingLimit
{
    public static function cronCalled()
    {
        // PING LIMIT CONFIG
        $config['limit'] = 200; // LIMIT IN MS (200 DEFAULT)

        $servers = dbquery('SELECT * FROM servers');
        foreach ($servers as $server) {
            if (checkOnline($server['connection'])) {
                foreach (json_decode(file_get_contents('http://' . $server['connection'] . '/players.json')) as $player) {
                    if ($player->ping > $config['limit']) {
                        removeFromSession($player->identifiers[1], 'You have been removed from the server because your ping is above ' . $config['limit'] . 'MS');
                    }
                }
            }
        }
    }
}

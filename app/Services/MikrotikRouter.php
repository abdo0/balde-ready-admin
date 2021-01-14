<?php
/**
 * Created by PhpStorm.
 * User: abd
 * Date: 10/26/20
 * Time: 11:41 AM
 */

namespace App\Services;


class MikrotikRouter
{
    static public function mikrotikConnectAndCommand($router_ip, $port, $username, $password, $command)
    {
        // Establish a connection to the SSH Server. Port is the second param.
        $connection = ssh2_connect($router_ip, $port);

        // Authenticate with the SSH server
        ssh2_auth_password($connection, $username, $password);

        // Execute a command on the connected server and capture the response
        $stream = ssh2_exec($connection, $command);

        // Sets blocking mode on the stream
        stream_set_blocking($stream, true);

        // Get the response of the executed command in a human readable form
        $output = stream_get_contents($stream);

        return $output;
    }

    static public function getMikrotikRouterItemIndexFromPrint($items, $ip)
    {
        foreach ($items as $key=>$value) {
            if(strpos($value[0], $ip) !== false){
                $data=self::stringToArray($value[0], " ");
                return $data[0][0];
                break;
            }
        }
    }

    static public function stringToArray($string, $type)
    {
        //        $csvReportRows = explode("\n", $string);
        //        $report = [];
        //        foreach ($csvReportRows as $c) {
        //            var_dump($c);
        //            if ($c) { $report[] = str_getcsv($c, "\t");}
        //        }
        $csvReportRows = explode($type, $string);
        $report = [];
        foreach ($csvReportRows as $c) {
            if ($c) { $report[] = str_getcsv($c, "\t");}
        }
        return $report;
    }

}
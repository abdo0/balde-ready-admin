<?php
/*
* RouterOS API
* Based on the code of SpectatorCN at http://forum.mikrotik.com/viewtopic.php?f=9&t=32957
* Modified by Ali Damji http://forum.mikrotik.com/viewtopic.php?f=9&t=33690
* Modified by Tim Haak
* Free to modify, distribute, do whatever.
*
*/

namespace App\Services;

use App\Log;

class phpMikrotikTelnet
{
    //You may be able to lower this for single commands but needs to be high when running lots of commands
    var $TimeOut=125000;
    var $fp;
    var $echo=true;

    function phpMikrotikTelnet($host, $username, $password,$echo=true)
    {
        $this->routeros_connect($host, $username, $password);
    }

    function routeros_connect($host, $username, $password)
    {
        $header1=chr(0xFF).chr(0xFB).chr(0x1F).chr(0xFF).chr(0xFB).chr(0x20).chr(0xFF).chr(0xFB).chr(0x18).chr(0xFF).chr(0xFB).chr(0x27).chr(0xFF).chr(0xFD).chr(0x01).chr(0xFF).chr(0xFB).chr(0x03).chr(0xFF).chr(0xFD).chr(0x03).chr(0xFF).chr(0xFC).chr(0x23).chr(0xFF).chr(0xFC).chr(0x24).chr(0xFF).chr(0xFA).chr(0x1F).chr(0x00).chr(0x50).chr(0x00).chr(0x18).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x20).chr(0x00).chr(0x33).chr(0x38).chr(0x34).chr(0x30).chr(0x30).chr(0x2C).chr(0x33).chr(0x38).chr(0x34).chr(0x30).chr(0x30).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x27).chr(0x00).chr(0xFF).chr(0xF0).chr(0xFF).chr(0xFA).chr(0x18).chr(0x00).chr(0x41).chr(0x4E).chr(0x53).chr(0x49).chr(0xFF).chr(0xF0);
        $header2=chr(0xFF).chr(0xFC).chr(0x01).chr(0xFF).chr(0xFC).chr(0x22).chr(0xFF).chr(0xFE).chr(0x05).chr(0xFF).chr(0xFC).chr(0x21);
        $this->fp=fsockopen($host,23);
        fputs($this->fp,$header1);
        usleep(125000);
        fputs($this->fp,$header2);
        usleep(125000);
        $this->write_to_telnet($username."+ct");
        $this->write_to_telnet($password);
        $this->read_from_telnet();
    }

    function routeros_cmd($command)
    {
        //$command = str_replace(";\n",';',$command);
        //echo $command."\n";
        $commands = explode("\n",$command);
        reset($commands);
        foreach ($commands as $cmd)
        {
            if ($this->echo)
                echo $cmd."\n";
            flush();
            $this->write_to_telnet(trim($cmd));
            $read = $this->read_from_telnet()."\n";
            if ($this->echo)
                echo $read;
            flush();
        }
        return $rez;
    }

    # Telnet Related
    function write_to_telnet($text)
    {
        \Illuminate\Support\Facades\Log::info($this->fp);
        \Illuminate\Support\Facades\Log::info($text);
        fputs($this->fp,$text."\r\n");
        usleep($this->TimeOut);
        return true;
    }

    function read_from_telnet()
    {
        $output = "";
        $count = 0;
        $count2 = 0;
        do{
            $char =fread($this->fp, 1);
            $output .= $char;
            if($char==">") $count++;
            if($count==1) break;
            if($char==".") $count2++;
            if($count2==3) break;
        } while(1==1);
        $output=preg_replace("/^.*?\n(.*)\n[^\n]*$/","$1",$output);
        $o=explode("\n",$output);
        for($i=1;$i<=count($o)-2;$i++) $op.=$o[$i]."\n";
        return $op;
    }

    function close()
    {
        fclose($this->fp);
    }

}


$cmd = '
/queue type
remove pfifo
remove pfifo_long
remove red
remove sfq
remove pcq_game
remove pcq_rest
remove pcq_default
add kind=pfifo name=pfifo pfifo-limit=50
add kind=pfifo name=pfifo_long pfifo-limit=250
add kind=sfq name=sfq sfq-allot=1514 sfq-perturb=5
add kind=red name=red red-avg-packet=1000 red-burst=40 red-limit=180 red-max-threshold=100 red-min-threshold=30
#Short que better latency
add kind=pcq name=pcq_game pcq-rate=0 pcq-classifier=dst-address pcq-limit=20 pcq-total-limit=500
add kind=pcq name=pcq_rest pcq-rate=0 pcq-classifier=dst-address pcq-limit=200 pcq-total-limit=8000
add kind=pcq name=pcq_default pcq-rate=0 pcq-classifier=dst-address pcq-limit=50 pcq-total-limit=2000


:foreach intId in=[/interface wireless find] do={     \
:local intname [/interface wireless get $intId name];  \

:local qname ("Q_" . $intname);
:local subqname ("Q_SUB_" . $intname);
:local maxlimit 1000000000;

/queue tree


     
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=$maxlimit \
    max-limit=$maxlimit name=$qname parent=$intname 
    
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=512000 \
    max-limit=512000 name=("voip_46_"  . $intname)  packet-mark=dscp_46     parent=$qname priority=1 queue=pcq_game
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=512000 \
    max-limit=512000 name=("critical_7_"  . $intname)  packet-mark=dscp_7     parent=$qname priority=1 queue=pcq_game
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=3000000 \
    max-limit=3000000 name=("games_6_"  . $intname)  packet-mark=dscp_6     parent=$qname priority=2 queue=pcq_game
#pfifo
    
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=5000000 \
    max-limit=$maxlimit name=("lv_hi_"  . $intname)  packet-mark=lvhi            parent=$qname priority=1 queue=pcq_rest  
      
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=1000000 \
    max-limit=$maxlimit name=("lv_med_"  . $intname)  packet-mark=lvmed          parent=$qname priority=2 queue=pcq_rest
   
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=512000 \
    max-limit=512000 name=("management_5_" . $intname)   packet-mark=dscp_5      parent=$qname priority=3 queue=pcq_default
#pfifo    
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=1000000 \
    max-limit=$maxlimit name=$subqname parent=$qname    
  
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=100000 \
    max-limit=$maxlimit name=("high_4_" . $intname)              packet-mark=dscp_4      parent=$subqname priority=5 queue=pcq_rest
#pfifo_long
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=100000 \
    max-limit=$maxlimit name=("norm_3_" . $intname)              packet-mark=dscp_3      parent=$subqname priority=6 queue=pcq_rest
#pfifo_long
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=100000 \
    max-limit=$maxlimit name=("filetrans_2_" . $intname)         packet-mark=dscp_2      parent=$subqname priority=7 queue=pcq_rest
#pfifo_long
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=100000 \
    max-limit=$maxlimit name=("bulk_1_" . $intname)              packet-mark=dscp_1      parent=$subqname priority=8 queue=pcq_game
#sfq
add burst-limit=0 burst-threshold=0 burst-time=0s  limit-at=100000 \
    max-limit=$maxlimit name=("unmarked_" . $intname)            packet-mark="unmarked"  parent=$subqname priority=8 queue=pcq_game
#sfq
    
/system script
 set start_shaping source=([/system script get start_shaping source] . "       \
     /queue tree set games_6_$intname limit-at=5000000 max-limit=5000000;      \
     /queue tree set [find parent=$subqname] max-limit=5000000;                \
     /queue tree set $subqname max-limit=5000000\r\ \n")
 set stop_shaping source=([/system script get stop_shaping source] . "         \
     /queue tree set games_6_$intname limit-at=3000000 max-limit=3000000;      \
     /queue tree set [find parent=$subqname] max-limit=$maxlimit;              \
     /queue tree set $subqname max-limit=$maxlimit\r\ \n")
}


/system clock
set time-zone-name=Africa/Johannesburg

/system ntp client
set enabled=yes mode=unicast primary-ntp=172.20.2.1 secondary-ntp=\
    172.20.11.34

:put "done"
';

//$ServerList [] = "172.20.16.106";
//$ServerList [] = "172.20.245.55";
//$ServerList [] = "172.20.12.81";



?>
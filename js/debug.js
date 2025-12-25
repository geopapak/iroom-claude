function savemsg($msg){
$log=fopen("../Equipment_rooms/debugsave_614.txt","a");
fwrite($log,"\n*************** NEW ENTRY *************** \n");
fwrite($log, $msg);
fwrite($log,"\n\n\n\n\n");
fclose($log);
}
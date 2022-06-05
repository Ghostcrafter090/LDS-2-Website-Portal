<?php
    $commf = false;
    if (isset($_GET['key'])) {
        if ($_GET['key'] == "30899834ufr89389ur3urueue88932") {
            if (isset($_GET['comm'])) {
                $string = file_get_contents(".\\hosts.cxl");
                $hosts = json_decode($string, true);
                if ($_GET['comm'] == "return") {
                    $keys = array_keys($hosts);
                    $hostsNew = json_decode("{\"gsweathermore.ddns.net\": {\"ip\": \"". getHostByName(getHostName()). "\", \"lastUpdated\": ". $_SERVER['REQUEST_TIME']. "}}", true);
                    $i = 0;
                    while ($i < count($keys)) {
                        if (($hosts[$keys[$i]]["lastUpdated"] + 120) < $_SERVER['REQUEST_TIME'] + 120) {
                            $hostsNew[$keys[$i]] = $hosts[$keys[$i]];
                        }
                        $i = $i + 1;
                    }
                    echo json_encode($hostsNew);
                    file_put_contents(".\\hosts.cxl", json_encode($hostsNew));
                    $commf = true;
                } else if ($_GET['comm'] == "set") {
                    if (isset($_GET['token'])) {
                        if (isset($_GET['value'])) {
                            // echo "{\"ip\": ". $_GET['value']. ", \"last_updated\": ". date("Y-m-d H:i:s"). "}";
                            $hosts[$_GET['token']] = json_decode("{\"ip\": \"". $_GET['value']. "\", \"lastUpdated\": ". $_SERVER['REQUEST_TIME']. "}", true);
                            file_put_contents(".\\hosts.cxl", json_encode($hosts));
                            echo "{\"status\": 200}";
                            $commf = true;
                        }
                    }
                }
            }
        }
    }

    if (!$commf) {
        echo "{\"status\": 403}";
    }
?>
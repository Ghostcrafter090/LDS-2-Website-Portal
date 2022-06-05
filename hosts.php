<?php
    $commf = false;
    if (isset($_GET['key'])) {
        if ($_GET['key'] == "30899834ufr89389ur3urueue88932") {
            if (isset($_GET['comm'])) {
                $string = file_get_contents(".\\hosts.cxl");
                $hosts = json_decode($string, true);
                if ($_GET['comm'] == "return") {
                    $keys = array_keys($hosts);
                    $i = 0;
                    while ($i < count($keys)) {
                        if ($hosts[$keys[$i]]) {
                            
                        }
                    }
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
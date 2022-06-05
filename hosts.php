<?php
    $commf = false;
    echo Date();
    if (isset($_GET['key'])) {
        if ($_GET['key'] == "30899834ufr89389ur3urueue88932") {
            if (isset($_GET['comm'])) {
                $string = file_get_contents(".\\hosts.cxl");
                $hosts = json_decode($string, true);
                if ($_GET['comm'] == "return") {
                    echo $string;
                    $commf = true;
                } else if ($_GET['comm'] == "set") {
                    if (isset($_GET['token'])) {
                        if (isset($_GET['value'])) {
                            $hosts[$_GET['token']] = $_GET['value'];
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
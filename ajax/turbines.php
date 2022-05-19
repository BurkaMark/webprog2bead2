<?php
    switch($_POST['op'])
    {
    case "county":
        $result = array("list" => array());
        try
        {
            $db = new PDO('mysql:host=localhost;dbname=bead2', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $db->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
            $rows = $db->query("SELECT id, nev FROM megye");
            while ($row = $rows->fetch(PDO::FETCH_ASSOC))
            {
                $result['list'][] = array("id" => $row['id'], "nev" => $row['nev']);
            }
        }
        catch(PDOException $e)
        {

        }
        echo json_encode($result);
        break;
    case "city":
        $result = array("list" => array());
        try
        {
            $db = new PDO('mysql:host=localhost;dbname=bead2', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $db->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
            $rows = $db->prepare("SELECT id, nev FROM helyszin where megyeid = :id");
            $rows->execute(Array(":id" => $_POST["id"]));
            while ($row = $rows->fetch(PDO::FETCH_ASSOC))
            {
                $result['list'][] = array("id" => $row['id'], "nev" => $row['nev']);
            }
        }
        catch(PDOException $e)
        {

        }
        echo json_encode($result);
        break;
    case "turbine":
        $result = array("list" => array());
        try
        {
            $db = new PDO('mysql:host=localhost;dbname=bead2', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $db->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
            $rows = $db->prepare("SELECT id FROM torony where helyszinid = :id");
            $rows->execute(Array(":id" => $_POST["id"]));
            while ($row = $rows->fetch(PDO::FETCH_ASSOC))
            {
                $result['list'][] = array("id" => $row['id']);
            }
        }
        catch(PDOException $e)
        {

        }
        echo json_encode($result);
        break;
    case "info":
        $result = array("quantity" => "", "performance" => "", "initialYear" => "", "region" => "");
        try
        {
            $db = new PDO('mysql:host=localhost;dbname=bead2', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $db->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
            $rows = $db->prepare("SELECT darab, teljesitmeny, kezdev, helyszinid FROM torony where id = :id");
            $rows->execute(Array(":id" => $_POST["id"]));
            if ($row = $rows->fetch(PDO::FETCH_ASSOC))
            {
                $result = array("quantity" => $row['darab'], "performance" => $row['teljesitmeny'], "initialYear" => $row['kezdev'], "region" => "");
                $cityId = $row['helyszinid'];

                $rows = $db->prepare("SELECT megyeid FROM helyszin where id = :id");
                $rows->execute(Array(":id" => $cityId));
                if ($row = $rows->fetch(PDO::FETCH_ASSOC))
                {
                    $countyId = $row['megyeid'];

                    $rows = $db->prepare("SELECT regio FROM megye where id = :id");
                    $rows->execute(Array(":id" => $countyId));
                    if ($row = $rows->fetch(PDO::FETCH_ASSOC))
                    {
                        $result['region'] = $row['regio'];
                    }
                }
            }
        }
        catch(PDOException $e)
        {
            
        }
        echo json_encode($result);
        break;
    }
?>

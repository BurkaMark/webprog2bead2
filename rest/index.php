<?php
    $url = "http://localhost/webprog2bead2/rest/server.php";
    $result = "";
    
    if (isset($_POST['id']))
    {
        $_POST['id'] = trim($_POST['id']);
        $_POST['qty'] = trim($_POST['qty']);
        $_POST['pfm'] = trim($_POST['pfm']);
        $_POST['iny'] = trim($_POST['iinyd']);
        $_POST['ctid'] = trim($_POST['ctid']);

        if ($_POST['id'] == "" && $_POST['qty'] != "" && $_POST['pfm'] != "" && $_POST['iny'] != "" && $_POST['ctid'] != "")
        {
            $data = Array("qty" => $_POST['qty'], "pfm" => $_POST['pfm'], "iny" => $_POST['iny'], "ctid" => $_POST['ctid']);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            curl_close($curl);
        }
        elseif ($_POST['id'] == "")
        {
            $result = "Nincs minden adat kitöltve!";
        }
        elseif ($_POST['id'] >= 1 && ($_POST['qty'] != "" || $_POST['pfm'] != "" || $_POST['iny'] != "" || $_POST['ctid'] != ""))
        {
            $data = Array("id" => $_POST['id'], "qty" => $_POST['qty'], "pfm" => $_POST['pfm'], "iny" => $_POST['iny'], "ctid" => $_POST['ctid']);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            curl_close($curl);
        }
        elseif ($_POST['id'] >= 1)
        {
            $data = Array("id" => $_POST['id']);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            curl_close($curl);
        }
        else
        {
            $result = "Rossz azonosító! A megadott ID: " . $_POST['id'] . "<br>";
        }
    }

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $table = curl_exec($curl);
    curl_close($curl);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>REST</title>
    </head>
    <body>
        <?= $result ?>
        <h1>Tornyok:</h1>
        <?= $table ?>
        <br>
        <h2>Módosítás, beszúrás</h2>
        <form method="POST">
            ID: <input type="text" name="id"><br><br>
            Darab: <input type="text" name="qty" maxlength="15"> Teljesítmény: <input type="text" name="pfm" maxlength="25"><br><br>
            Kezdőév: <input type="text" name="iny" maxlenght="25"> Helyszín ID: <input type="text" name="ctid" maxlenght="15"><br><br>
            <input type="submit" name="submit" value="Küldés">
        </form>
    </body>
</html>
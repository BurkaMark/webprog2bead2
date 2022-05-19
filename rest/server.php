<?php
    $result = "";
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=bead2', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $db->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

        switch ($$_SERVER['REQUEST_METHOD'])
        {
            case 'GET':
                $sql = "SELECT * FROM torony";     
				$rows = $db->query($sql);
				$result .= "<table style=\"border-collapse: collapse;\"><tr><th>ID</th><th>Darab</th><th>Teljesítmény</th><th>Kezdőév</th><th>Helyszín ID</th></tr>";
				while($row = $rows->fetch(PDO::FETCH_ASSOC))
                {
					$result .= "<tr>";
					foreach($row as $column)
						$result .= "<td style=\"border: 1px solid black; padding: 3px;\">".$column."</td>";
					$result .= "</tr>";
				}
				$result .= "</table>";
                break;
            case 'POST':
                $sql = "INSERT INTO torony VALUES (0, :qty, :pfm, :iny, :ctid)";
                $row = $db->prepare($sql);
                $count = $row->execute(Array(":qty" => $_POST['qty'], ":pfm" => $_POST['pfm'], ":iny" => $_POST['iny'], ":ctid" => $_POST['ctid']));
                $newid = $db->lastInsertedId();
                $result .= $count . " beszúrt sor: " . $newid;
                break;
            case 'PUT':
                $data = array();
                $incoming = file_get_contents("php://input");
                parse_str($incoming, $data);
                $modify = "id-id";
                $params = Array(":id" => $data['id']);
                if ($data['qty'] != "")
                {
                    $modify .= ", darab = :qty";
                    $params[':qty'] = $data['qty'];
                }
                if ($data['pfm'] != "")
                {
                    $modify .= ", teljesitmeny = :pfm";
                    $params[':pfm'] = $data['pfm'];
                }
                if ($data['iny'] != "")
                {
                    $modify .= ", kezdev = :iny";
                    $params[':iny'] = $data['iny'];
                }
                if ($data['ctid'] != "")
                {
                    $modify .= ", helyszinid = :ctid";
                    $params[':ctid'] = $data['ctid'];
                }
                $sql = "UPDATE torony SET " . $modify . " WHERE id = :id";
                $row = $db->prepare($sql);
                $count = $row->execute($params);
                $result .= $count . " módosított sor: " . $data['id'];
                break;
            case 'DELETE':
                $data = array();
                $incoming = file_get_contents("php://input");
                parse_str($incoming, $data);
                $sql = "DELETE FROM torony WHERE id = :id";
                $row = $dbh->prepare($sql);
                $count = $row->execute(Array(":id" => $data['id']));
                $result .= $count . " sor törölve: " . data['id'];
                break;
        }
    }
    catch (PDOException $e)
    {
        $result = $e->getMessage();
    }

    echo $result;
?>
<?php
include_once "config.php";

function connectDb(){
    $servername = SERVERNAME;
    $username = USERNAME;
    $password = PASSWORD;
    $dbname = DATABASE;

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function crudMain(){
    echo "<h1>CRUD Bier</h1>
    <nav>
        <a href='insert.php'>Nieuw bier toevoegen</a>
    </nav><br>";

    $result = getData("bier"); // Tabelnaam aangepast naar 'bier'
    printCrudTabel($result);
}

function getData($table){
    $conn = connectDb();
    $sql = "SELECT * FROM $table";
    $query = $conn->prepare($sql);
    $query->execute();
    return $query->fetchAll();
}

function getRecord($biercode) {
    $conn = connectDb();
    $stmt = $conn->prepare("SELECT * FROM bier WHERE biercode = :biercode"); // 'bieren' aangepast naar 'bier'
    $stmt->execute(['biercode' => $biercode]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function printCrudTabel($result){
    if (empty($result)) {
        echo "Geen gegevens gevonden.";
        return;
    }

    $table = "<table border='1' style='background-color: lightcyan;'>";
    $headers = array_keys($result[0]);
    $table .= "<tr>";
    
    foreach ($headers as $header) {
        $table .= "<th>" . ucfirst($header) . "</th>";
    }
    $table .= "<th>Actie</th></tr>";

    foreach ($result as $row) {
        $table .= "<tr>";
        foreach ($row as $cell) {
            $table .= "<td>" . htmlspecialchars($cell) . "</td>";
        }
        
        $biercode = $row['biercode'];

        $table .= "<td>
                    <a href='update.php?biercode=$biercode'>Wijzigen</a> |
                    <a href='delete.php?biercode=$biercode' onclick='return confirm(\"Weet je zeker dat je dit wilt verwijderen?\")'>Verwijderen</a>
                  </td>";
        $table .= "</tr>";
    }

    $table .= "</table>";
    echo $table;
}

function updateRecord($row){
    $conn = connectDb();
    $sql = "UPDATE bier SET
        naam = :naam,
        soort = :soort,
        stijl = :stijl,
        alcohol = :alcohol,
        brouwcode = :brouwcode
    WHERE biercode = :biercode";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':naam' => $row['naam'],
        ':soort' => $row['soort'],
        ':stijl' => $row['stijl'],
        ':alcohol' => $row['alcohol'],
        ':brouwcode' => $row['brouwcode'],
        ':biercode' => $row['biercode']
    ]);
    
    return ($stmt->rowCount() == 1);
}

function insertRecord($post){
    $conn = connectDb();
    $naam = isset($post['naam']) ? $post['naam'] : '';
    $soort = isset($post['soort']) ? $post['soort'] : '';
    $stijl = isset($post['stijl']) ? $post['stijl'] : '';
    $alcohol = isset($post['alcohol']) ? $post['alcohol'] : 0;
    $brouwcode = isset($post['brouwcode']) ? $post['brouwcode'] : '';

    $sql = "INSERT INTO bier (naam, soort, stijl, alcohol, brouwcode) 
        VALUES (:naam, :soort, :stijl, :alcohol, :brouwcode)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':naam' => $naam,
        ':soort' => $soort,
        ':stijl' => $stijl,
        ':alcohol' => $alcohol,
        ':brouwcode' => $brouwcode
    ]);
    
    return ($stmt->rowCount() == 1);
}

function deleteRecord($biercode){
    $conn = connectDb();
    $sql = "DELETE FROM bier WHERE biercode = :biercode"; // 'bieren' aangepast naar 'bier'
    $stmt = $conn->prepare($sql);
    $stmt->execute([':biercode' => $biercode]);
    
    return ($stmt->rowCount() == 1);
}
?>

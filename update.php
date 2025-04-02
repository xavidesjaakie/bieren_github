<?php
// Functie: update bier
// Auteur: Vul hier je naam in

require_once('functions.php');

// Controle of er een wijziging is ingediend
if (isset($_POST['btn_wzg'])) {
    if (!isset($_POST['biercode']) || empty($_POST['biercode'])) {
        die("Fout: Geen biercode opgegeven bij de update.");
    }

    if (updateRecord($_POST)) {
        echo "<script>alert('Bier is gewijzigd'); window.location.href='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Bier is NIET gewijzigd');</script>";
    }
}

// Controleer of er een biercode in de URL staat
if (!isset($_GET['biercode']) || empty($_GET['biercode'])) {
    die("Fout: Geen biercode opgegeven.");
}

$biercode = $_GET['biercode'];
$record = getRecord($biercode);

if (!$record) {
    die("Fout: Geen gegevens gevonden voor dit bier.");
}

// Vul de variabelen met de bestaande waarden
$naam = htmlspecialchars($record['naam'] ?? '');
$soort = htmlspecialchars($record['soort'] ?? '');
$stijl = htmlspecialchars($record['stijl'] ?? '');
$alcohol = htmlspecialchars($record['alcohol'] ?? '');
$brouwcode = htmlspecialchars($record['brouwcode'] ?? '');

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Wijzig Bier</title>
</head>
<body>

<h2>Wijzig Bier</h2>

<form method="POST" action="update.php">
    <input type="hidden" name="biercode" value="<?= $biercode ?>">

    <label>Naam:</label>
    <input type="text" name="naam" value="<?= $naam ?>" required>

    <label>Soort:</label>
    <input type="text" name="soort" value="<?= $soort ?>" required>

    <label>Stijl:</label>
    <input type="text" name="stijl" value="<?= $stijl ?>" required>

    <label>Alcoholpercentage:</label>
    <input type="number" step="0.1" name="alcohol" value="<?= $alcohol ?>" required>

    <label>Brouwcode:</label>
    <select name="brouwcode" required>
        <?php
        $brouwers = getData("brouwers"); // Haal alle brouwers op
        foreach ($brouwers as $brouwer) {
            $selected = ($brouwer['brouwcode'] == $brouwcode) ? "selected" : "";
            echo "<option value='{$brouwer['brouwcode']}' $selected>{$brouwer['naam']}</option>";
        }
        ?>
    </select>

    <button type="submit" name="btn_wzg">Wijzig</button>
</form>

<br><br>
<a href='index.php'>Home</a>

</body>
</html>

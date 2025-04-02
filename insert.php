<?php
echo "<h1>Insert Bier</h1>";
require_once('functions.php');

$conn = connectDb();
$sql = "SELECT brouwcode, naam FROM brouwers"; // Ophalen van brouwerijen voor de dropdown
$query = $conn->prepare($sql);
$query->execute();
$brouwers = $query->fetchAll();

if (isset($_POST) && isset($_POST['btn_ins'])) {
    if (insertRecord($_POST) == true) {
        echo "<script>alert('Bier is toegevoegd')</script>";
    } else {
        echo '<script>alert("Bier is NIET toegevoegd")</script>';
    }
}
?>

<html>
    <body>
        <form method="post">
            <label for="naam">Biernaam:</label>
            <input type="text" name="naam" required><br>

            <label for="soort">Soort:</label>
            <input type="text" name="soort" required><br>

            <label for="stijl">Stijl:</label>
            <input type="text" name="stijl" required><br>

            <label for="alcohol">Alcoholpercentage:</label>
            <input type="number" step="0.1" name="alcohol" required><br>

            <label for="brouwcode">Brouwer:</label>
            <select name="brouwcode" required>
                <option value="">-- Selecteer een brouwer --</option>
                <?php foreach ($brouwers as $brouwer): ?>
                    <option value="<?= $brouwer['brouwcode'] ?>"><?= $brouwer['brouwcode'] . ' - ' . $brouwer['naam'] ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <input type="submit" name="btn_ins" value="Toevoegen">
        </form>
        <br><br>
        <a href='index.php'>Home</a>
    </body>
</html>

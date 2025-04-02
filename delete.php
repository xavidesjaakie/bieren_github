<?php
require_once('functions.php');

if (isset($_GET['brouwcode'])) {
    $brouwcode = $_GET['brouwcode'];
    if (deleteRecord($brouwcode)) {
        echo "<script>alert('Brouwer verwijderd!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Verwijderen mislukt!'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Geen brouwcode opgegeven!'); window.location.href='index.php';</script>";
}
if (isset($_GET['brouwcode'])) {
    $brouwcode = $_GET['brouwcode'];
} else {
    die("Geen brouwcode opgegeven");
}

?>

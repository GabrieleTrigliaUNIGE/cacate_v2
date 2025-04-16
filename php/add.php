<?php
$personID = isset($_POST['PersonID']) ? (int)$_POST['PersonID'] : 0;
$azione = isset($_POST['azione']) ? $_POST['azione'] : '';

$conn = mysqli_connect("localhost", "root", "", "cacate_v2");
if (!$conn) {
    exit("Errore: impossibile connettersi al database. " . mysqli_connect_error());
}

if ($azione === 'add') {
    $query = "UPDATE persons SET numero = numero + 1 WHERE PersonID = $personID";
} elseif ($azione === 'remove') {
    $query = "UPDATE persons SET numero = numero - 1 WHERE PersonID = $personID";
} else {
    exit("Errore: azione non valida.");
}

$result = mysqli_query($conn, $query);
if (!$result) {
    exit("Errore nell'esecuzione della query: " . mysqli_error($conn));
}

header("Location: ../index.php");
exit;
?>

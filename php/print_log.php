<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print log</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    $conn = mysqli_connect("localhost", "root", "", "cacate_v2");
    if (!$conn) {
        exit("Errore: impossibile stabilire una connessione " . mysqli_connect_error());
    }

    $query = "SELECT * FROM registrazioni_cacate ORDER BY id ASC";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        exit("Errore: impossibile eseguire la query per stampa log" . mysqli_error($conn));
    }
    ?>
    <table>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Data</th>
            <th>Descrizione</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['person_id'] ?></td>
            <td><?= $row['data_ora'] ?></td>
            <td><?= $row['tipo_evento'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="../index.php">Torna alla home</a>
</body>

</html>
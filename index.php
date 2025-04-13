<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cacate Counter</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header>
        <h2>SUPER CACATE COUNTER</h2>
    </header>
    <br>
    <?php
    $conn = mysqli_connect("localhost", "root", "", "cacate");
    if (!$conn) {
        exit("Errore: impossibile stabilire una connessione " . mysqli_connect_error());
    }

    $query = "SELECT * FROM persons ORDER BY PersonID ASC";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        exit("Errore: impossibile eseguire la query " . mysqli_error($conn));
    }

    $persons = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $persons[] = $row;
    }

    $posizione_classifica = 0;
    ?>
    <table border="1">
        <thead>
            <tr>
                <?php foreach ($persons as $person): ?>
                    <th><?= $person['nome'] ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php foreach ($persons as $person): ?>
                    <td style="text-align: center;"><?= $person['numero'] ?></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($persons as $person): ?>
                    <td style="text-align: center;">
                        <form action="./php/add.php" method="post" style="display:inline;">
                            <input type="hidden" name="PersonID" value="<?= $person['PersonID'] ?>">
                            <input type="hidden" name="azione" value="add">
                            <button type="submit">Add</button>
                        </form>
                        <form action="./php/add.php" method="post" style="display:inline;">
                            <input type="hidden" name="PersonID" value="<?= $person['PersonID'] ?>">
                            <input type="hidden" name="azione" value="remove">
                            <button type="submit" class="red">Remove</button>
                        </form>
                    </td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>

    <!-- Sezione Classifica -->
    <h3>Classifica</h3>
    <?php
    // Query per ottenere la classifica ordinata per 'numero' in ordine discendente
    $query_ranking = "SELECT * FROM persons ORDER BY numero DESC";
    $result_ranking = mysqli_query($conn, $query_ranking);
    if (!$result_ranking) {
        exit("Errore: impossibile eseguire la query della classifica " . mysqli_error($conn));
    }
    ?>
    <table class="ranking-table">
        <thead>
            <tr>
                <th>Posizione</th>
                <th>Player</th>
                <th>Cacate</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $posizione = 1;
            while ($row = mysqli_fetch_assoc($result_ranking)):
            ?>
                <tr>
                    <td><?= $posizione ?></td>
                    <td><?= $row['nome'] ?></td>
                    <td><?= $row['numero'] ?></td>
                </tr>
            <?php
                $posizione++;
            endwhile;
            ?>
        </tbody>
    </table>

</body>

</html>
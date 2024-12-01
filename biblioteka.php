<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteka publiczna</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Biblioteka w Książkowicach Wielkich</h1>
    </header>
    <main>
        <div id="left">
            <h3>Polecamy dzieła autorów:</h3>
            <ol>
                <?php
                $db = new mysqli("localhost", "root", "", "biblioteka");
                $sql = "SELECT imie, nazwisko FROM `autorzy` ORDER BY autorzy.nazwisko ASC;";
                $result = $db->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $firstName = $row['imie'];
                    $lastName = $row['nazwisko'];
                    echo "<li>$firstName $lastName</li>";
                }
            
                ?>
            </ol>
        </div>
        <div id="center">
            <h3>ul. Czytelnicza 25, Książkowice&nbsp;Wielkie</h3>
            <p><a href="sekretariat@biblioteka.pl">Napisz do nas</a></p>
            <img src="biblioteka.png" alt="książki">
        </div>
        <div id="right">
            <div id="up">
                <h3>Dodaj czytelnika</h3>
                <form action="biblioteka.php" method="post">
                    <label for="name">imię:</label>
                    <input type="text" name="name" id="name"><br>
                    <label for="lastName">nazwisko:</label>
                    <input type="text" name="lastName" id="lastName"><br>
                    <label for="symbol">symbol:</label>
                    <input type="number" name="symbol" id="symbol"><br>
                    <input type="submit" value="DODAJ">
                </form>
            </div>
            <div id="down">
                <?php
                    $firstName = $_POST['name'];
                    $lastName = $_POST['lastName'];
                    $symbol = $_POST['symbol'];
                    if (!empty($firstName) && !empty($lastName) && !empty($symbol)) {
                        $db = new mysqli("localhost", "root", "", "biblioteka");
                        $sql = "INSERT INTO czytelnicy (imie, nazwisko, kod) VALUES (?, ?, ?)";
                        $query = $db->prepare($sql);
                        $query->bind_param("ssi", $firstName, $lastName, $symbol);
                        if ($query->execute()) {
                            echo "<p>Czytelnika: $firstName $lastName został(a) dodany do bazy danych</p>";
                        }
                        $db->close();
                    } else {
                        echo "<p>Proszę wypełnić wszystkie pola.</p>";
                    }

                    unset($firstName);
                    unset($lastName);
                    unset($symbol);
                ?>
            </div>
    </main>
    <footer>
        <p>Projekt strony: 00000000000</p>
    </footer>
</body>

</html>
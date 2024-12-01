<?php
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);
?>

<!DOCTYPE HTML>
<html>
	<head>
        <title>Prognoza</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="Antonio Jukić">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body{
                background-color: white;
                margin: 0;
                padding: 0;
                font-family: monospace, "Monaco";
            }

            header {
                text-align: center;
                background-color: azure;
                padding-bottom: 10px;
                border-bottom: 1px solid teal;
            }

            .containerH{
                max-width: 900px;
                margin: 0 auto;
            }

            .containerM{
                max-width: 900px;
                margin: 0 auto;
                background-color: azure;
            }

            header h1{
                color: teal;
                font-weight: normal;
                padding: 10px 0px;
                margin: 0;
            }

            nav {
                display: flex;
                justify-content: center;
                gap: 10px;
            }

            nav a {
                text-decoration: none;
                color: white;
                padding-top: 3px;
                background-color: teal;
                
                display: block;
                text-align: center;
                width: 150px;
                height: 25px;
                border-radius: 5px;
            }

            nav a:hover{
                background-color:cadetblue;
            }

            nav a:visited{
                color: white;
            }

            main h1{
                font-weight: normal;
                margin: 0px;
                color:teal;
            }

            section{
                padding: 10px;
                background-color: azure;
            }

            main section{
                text-align: center;
            }

            main section table {
                margin: 0 auto;
                text-align: center;
                width: 600px;
            }

            main section table thead tr{
                color: white;
                font-weight: normal;
                background-color: teal;
            }

            main section table tbody tr:hover {
                background-color: cadetblue;
            }

            main section th, td {
                border: 1px solid cadetblue;
                padding: 7px;
            }

            footer{
                background-color: teal;
            }

            .containerF{
                max-width: 900px;
                margin: 0 auto;

            }

            footer {
                color: white;
                text-align: center;
                margin: 0;
                padding: 10px;
            }

            footer a {
                color: white;
            }

        </style>
</head>
<body>
    <header>
        <div class="containerH">
            <h1 style="text-align: center; ">Prognoza</h1>
            <nav>
            <a href="index.php">Početna</a>
            <a href="admin.php">Admin Login</a>
            </nav>
        </div>
    </header>
    
    <main>
        <div class="containerM">
            <section>
                <?php

                    $uspjesnaPrijava = false;

                    $dbc = mysqli_connect('localhost', 'root', '', 'ntpws') or die('Error connecting: ' . mysqli_connect_error());

                    if (isset($_POST['prijava'])) {

                        $prijavaImeKorisnika = $_POST['user'];
                        $prijavaLozinkaKorisnika = $_POST['pass'];

                        $sql = "SELECT user, pass FROM user WHERE user = '$prijavaImeKorisnika'";
                        $result = mysqli_query($dbc, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $imeKorisnika = $row['user'];
                            $lozinkaKorisnika = $row['pass'];

                            if ($prijavaLozinkaKorisnika == $lozinkaKorisnika) {
                                $uspjesnaPrijava = true;
                            } else {
                                $uspjesnaPrijava = false;
                            }
                        } else {
                            $uspjesnaPrijava = false;
                        }
                    }

                    if ($uspjesnaPrijava == true) {
                        echo 'Bok, ' . $imeKorisnika . '! Prijavljeni ste.';

                        $sqlGradovi = "SELECT id, grad FROM gradovi";
                        $resultGradovi = mysqli_query($dbc, $sqlGradovi);

                        
                        if ($resultGradovi && mysqli_num_rows($resultGradovi) > 0) {
                            echo '<h1>Popis gradova iz baze:</h1>';
                            echo'
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Grad</th>
                                    </tr>
                                </thead>
                                <tbody>';

                            while ($row = mysqli_fetch_assoc($resultGradovi)) {
                                echo '<tr>';
                                echo '<td>' . $row['id'] . '</td>';
                                echo '<td>' . $row['grad'] . '</td>';
                                echo '</tr>';
                            }
                            echo '
                                    </tbody>
                                </table>';
                        } else {
                            echo '<p>Nema dostupnih podataka o gradovima.</p>';
                        }

                        mysqli_close($dbc);
                    } else {
                        echo '
                            <section>
                                <form method="post" action="">
                                    <label for="content">Korisničko ime:</label><br>
                                    <input type="text" name="user" id="user" class="form-field-textual"><br><br>
                                    <label for="pass">Lozinka: </label><br>
                                    <input type="password" name="pass" id="pass" class="form-field-textual"><br><br>
                                    <button type="submit" value="Prijava" name="prijava" id="slanje">Prijava</button>
                                </form>
                            </section>
                        ';
                    }
                ?>
            </section>

        </div>
    </main>
    <footer>
        <div class="containerF">
            <div class="sadrzaj">
                © Antonio Jukić
                <a href="https://github.com/ajukic-tvz/NTPWS_projekt" target="_blank">Github</a>
                &amp; Prognoza. All rights reserved.
            </div>
        </div>
    </footer>
</body>

</html>
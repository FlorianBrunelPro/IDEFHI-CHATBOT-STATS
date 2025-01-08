<?php
if (!function_exists('connect')) {
    function connect() {
        $servername = "localhost";
        $username = "idefhi";
        $password = "9hr7x8Q6OVZmVJMq";
        $dbname = "chatbot_stats_admin";
        $bdd = new mysqli($servername, $username, $password, $dbname);
        
        // Vérifier la connexion
        if ($bdd->connect_error) {
            die("Connection failed: " . $bdd->connect_error);
        }
        return $bdd;
    }
}

function add_version() {
    $bdd = connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $version_number = $_POST['version_number'];
        $version_release_date = $_POST['version_release_date'];
        $version_changelog = $_POST['version_changelog'];

        // Conversion de la date
        $date = DateTime::createFromFormat("Y-m-d\TH:i", $version_release_date);
        if ($date) {
            $version_release_date = $date->format("Y-m-d");
        } else {
            die("Invalid date format. Please use 'YYYY-MM-DDTHH:MM'.");
        }

        // Préparer et exécuter la requête
        $stmt = $bdd->prepare("INSERT INTO VERSION (VERSION_NUMBER, VERSION_RELEASE_DATE, VERSION_CHANGELOG) VALUES (?, ?, ?);");
        $stmt->bind_param("sss", $version_number, $version_release_date, $version_changelog);
        $stmt->execute();

        header("Location: ../home.php");
    }
}

add_version();
?>

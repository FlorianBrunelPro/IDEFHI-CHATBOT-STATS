<?php
if ($_SESSION == true) {
    session_destroy();
}

session_start();
$_SESSION['loggedin'] = false;
$servername = "localhost";
$username = "idefhi";
$password = "9hr7x8Q6OVZmVJMq";
$dbname = "chatbot_stats_admin";

// Créer une connexion
$bdd = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($bdd->connect_error) {
    die("Connection failed: " . $bdd->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_name = $_POST['username'];
    $admin_pwd = $_POST['password'];

    $stmt = $bdd->prepare("SELECT ADMIN_PWD FROM ADMIN WHERE ADMIN_NAME = ?");
    $stmt->bind_param("s", $admin_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['ADMIN_PWD'];

        if (password_verify($admin_pwd, $hashed_password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['admin_name'] = $admin_name;
            header("Location: ../home.php");
        } else {
            header("Location: ../index.php");
        }
    } else {
        header("Location: ../index.php");
    }

    $stmt->close();
}
$bdd->close();

?>

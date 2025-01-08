<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit;
}

include 'engine/settlement.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques Chatbot</title>
    <link rel="stylesheet" href="style/style.css?v=<?php echo time(); ?>">
    <link rel="icon" alt = "Logo IDEFHI" href="img/IDEFHI_LOGO.ico">
</head>
<body>
    <div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <div class="container">
        

        <div class="navbar">
            <div class="left-navbar">
                <img class="navbar-img" src="img/IDEFHI_LOGO.png">
            </div>
            <div class="middle-navbar">
                <h1>STATISTIQUES DU CHATBOT</h1>
            </div>
          
            <form id="loginForm" class="right-navbar" method="post" action="engine/delogin.php">
                <button type="submit" class="unlogin">Déconnexion</button>
            </form>

        </div>
        <div class="first-block">
            <div class="general-stats">
                <div class = "title-general-stats">
                    <h2>Informations globales :</h2>
                </div>

                <div class = "content-general-stats">
                    <?php
                        general_stats();
                    ?>
                </div>
            </div>
               
            <div class="last-stats">
                <div class = "last-stats-box">
                    <div class = "title-last-stats">
                        <h2>Les 5 derniers avis :</h2>
                    </div>
                    
                    <div class = "content-last-stats">
                        <?php
                            last_five();
                        ?>
                    </div>
                    
                </div>
                
            </div>
        </div>
        <div class="second-block">
            <div class="graphic-stats">
                
                <?php
                    satisfaction_per_version();
                ?>
            </div>
        </div>

        <div class="third-block">
            <div class="all-stats">
                <?php
                    all_notices();
                ?>
            </div>
        </div>

        <div class = "fourth-block">
            <div class = "add-version">
                <div class = "left-add-version">
                    <h3>Comment rédiger un changelog de version ?</h3>

                    <p>Pour rédiger un changelog de version, plusieurs éléments sont nécessaires:
                        <br>
                        <br>
                        Munissez vous de ces emojis : 🚀 🔧 🛠️ 📅, Ils permettent de structurer le changelog.
                        <br>
                        <br>
                        Votre structure doit ABSOLUMENT respecter cette forme :
                        <br>
                        <br>
                        <br>

                        🚀 Nouveautés<br>
                        <br>
                        Fait n°1 : Détail concernant le fait n°1.<br>
                        Fait n°2 : Détail concernant le fait n°1.<br>
                        etc ...
                        <br>
                        <br>
                        🔧 Améliorations<br>
                        Fait n°1 : Détail concernant le fait n°1.<br>
                        etc ...<br>
                        <br>
                        <br>
                        🛠️ Corrections de bugs<br>
                        Fait n°1 : Détail concernant le fait n°1.<br>
                        etc ...<br>
                        <br>
                        <br>
                        📅 A venir <br>
                        Fait n°1 : Détail concernant le fait n°1.<br>
                        etc ...<br>
                    </p>
                </div>

                <div class = "right-add-version">
                    <form id="add-version-form" class="add-version-form" method="post" action="engine/add_version.php">
                        <h3>Rédigez ici votre rapport de changelog :</h3>
                        
                        <input type="text" class="version-input" id="version_number-input" name="version_number" placeholder="Numéro de version" required>
                        
                        <input type="datetime-local" class="version-input" id="version_release_date-input" name="version_release_date" required>
                        
                        <textarea rows="20" placeholder="Écrivez ici votre changelog" name="version_changelog" required></textarea>
                        
                        <button type="submit" class="add-version-button">Ajouter la version</button>
                    </form>
                </div>
                
            </div>
        </div>

        <div class = "fifth-block">
            <div class = "all-versions-info">
                <?php all_versions(); ?>
            </div>
        </div>

        <div class="footer">
            <div class="footer-container">

                <div class = "footer-logo-container">
                    <img src="img/IDEFHI_LOGO.png" alt = "Logo IDEFHI" class="footer-logo">
                </div>
                <div class="footer-info">
                    
                    <p>Statistiques Chatbot - Version 0.1</p>
                    <p>&copy; <?php echo date("Y"); ?> IDEFHI - Tous droits réservés</p>
                </div>

                
                
                <div class="footer-legal">
                    <p>Site interne réservé aux collaborateurs de l’IDEFHI.</p>
                    <p>Les données présentées sont confidentielles et à usage exclusif.</p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
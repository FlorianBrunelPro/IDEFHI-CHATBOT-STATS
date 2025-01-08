<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques Chatbot Login</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" href="img/IDEFHI_LOGO.ico">
</head>

<body>
    <div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <div class = "background">
        

        <div class ="left-page">
            
        </div>

        <div class = "right-page">
            <div class = "login-box">
                <form id="loginForm" class="login-container" method="post" action="engine/login.php">
                    <div class="title-box">
                        <p class="login-box-title">Connectez vous à l'espace statistiques du Chatbot IDEFHI</p>
                    </div>
                    <div class="inputs-box">
                        <div class="username-box">
                            <label class="username-title">Identifiant</label>
                            <input type="text" class="user-input" id="username-input" name="username">
                        </div>
                        <div class="pwd-box">
                            <label class="pwd-title">Mot de passe</label>
                            <input type="password" class="user-input" id="pwd-input" name="password">
                        </div>
                    </div>
                    <div class="button-box">
                        <button type="submit" class="login-button">SE CONNECTER</button>
                    </div>
                </form>


            </div>
        </div>
        
    </div>


</body>
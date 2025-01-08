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

function last_version() {
    $bdd = connect();
    $sql = "SELECT VERSION_NUMBER, VERSION_RELEASE_DATE
            FROM version
            ORDER BY VERSION_RELEASE_DATE DESC
            LIMIT 1;";
    $version_info = $bdd->query($sql);
    
    if ($version_info->num_rows > 0) {
        $row = $version_info->fetch_assoc();
        echo "<div class='general-stat-version'>";
        echo "<label class='last-version-label'> Version la plus récente : " . $row["VERSION_NUMBER"] . "</label>";
        echo "</div>";
        echo "<div class='general-stat-version'>";
        echo "<label class='last-version-label'> Date de sortie : " . $row["VERSION_RELEASE_DATE"] . "</label>";
        echo "</div>";
        echo "<br>";
        $version_number = $row["VERSION_NUMBER"];
    } else {
        echo "Aucune version trouvée.";
        $version_number = null;
    }
    
    $bdd->close();
    return $version_number;
}

function use_average($last_version) {
    $bdd = connect();
    $sql = "SELECT AVG(GRADE.GRADE_USE) AS avg_use
            FROM notice
            NATURAL JOIN grade
            NATURAL JOIN version
            WHERE version.VERSION_NUMBER = '$last_version';";
    
    $version_info = $bdd->query($sql);
    
    if ($version_info->num_rows > 0) {
        $row = $version_info->fetch_assoc();
        echo "<div class='general-stat-average-use'>";
        echo "<label class='last-version-label'> Note d'utilisation moyenne (v" . $last_version . ") : " . number_format($row["avg_use"], 2)  . "</label>";
        echo "</div>";
    } else {
        echo "Aucune donnée trouvée pour la moyenne.";
    }
    
    $bdd->close();
}

function relevance_average($last_version) {
    $bdd = connect();
    $sql = "SELECT AVG(GRADE.GRADE_RELEVANCE) AS avg_rel
            FROM notice
            NATURAL JOIN grade
            NATURAL JOIN version
            WHERE version.VERSION_NUMBER = '$last_version';";
    
    $version_info = $bdd->query($sql);
    
    if ($version_info->num_rows > 0) {
        $row = $version_info->fetch_assoc();
        echo "<div class='general-stat-average-use'>";
        echo "<label class='last-version-label'> Note de pertinence moyenne (v" . $last_version . ") : " . number_format($row["avg_rel"], 2)  . "</label>";
        echo "</div>";
    } else {
        echo "Aucune donnée trouvée pour la moyenne.";
    }
    
    $bdd->close();
}

function service_average($last_version) {
    $bdd = connect();
    $sql = "SELECT AVG(GRADE.GRADE_SERVICE) AS avg_ser
            FROM notice
            NATURAL JOIN grade
            NATURAL JOIN version
            WHERE version.VERSION_NUMBER = '$last_version';";
    
    $version_info = $bdd->query($sql);
    
    if ($version_info->num_rows > 0) {
        $row = $version_info->fetch_assoc();
        echo "<div class='general-stat-average-use'>";
        echo "<label class='last-version-label'> Note de qualité de service moyenne (v" . $last_version. ") : " . number_format($row["avg_ser"], 2)  . "</label>";
        echo "</div>";
    } else {
        echo "Aucune donnée trouvée pour la moyenne.";
    }
    
    $bdd->close();
}

function visual_average($last_version) {
    $bdd = connect();
    $sql = "SELECT AVG(GRADE.GRADE_VISUAL) AS avg_vis
            FROM notice
            NATURAL JOIN grade
            NATURAL JOIN version
            WHERE version.VERSION_NUMBER = '$last_version';";
    
    $version_info = $bdd->query($sql);
    
    if ($version_info->num_rows > 0) {
        $row = $version_info->fetch_assoc();
        echo "<div class='general-stat-average-use'>";
        echo "<label class='last-version-label'> Note de qualité visuelle moyenne (v" . $last_version. ") : " . number_format($row["avg_vis"], 2). "</label>";
        echo "</div>";
    } else {
        echo "Aucune donnée trouvée pour la moyenne.";
    }
    
    $bdd->close();
}

function global_average($last_version) {
    $bdd = connect();
    $sql = "SELECT AVG(GRADE.GRADE_GLOBAL) AS avg_glo
            FROM notice
            NATURAL JOIN grade
            NATURAL JOIN version
            WHERE version.VERSION_NUMBER = '$last_version';";
    
    $version_info = $bdd->query($sql);
    
    if ($version_info->num_rows > 0) {
        $row = $version_info->fetch_assoc();
        echo "<div class='general-stat-average-use'>";
        echo "<label class='last-version-label'> Note de qualité visuelle moyenne (v" . round($last_version, 2) . ") : " . number_format($row["avg_glo"], 2) . "</label>";
        echo "</div>";
    } else {
        echo "Aucune donnée trouvée pour la moyenne.";
    }
    
    $bdd->close();
}

function general_stats() {
    $last_version = last_version();
    
    use_average($last_version);
    relevance_average($last_version);
    service_average($last_version);
    visual_average($last_version);
    global_average($last_version);
}


function last_five() {
    $bdd = connect();
    $sql = "SELECT NOTICE_DATE, VERSION.VERSION_NUMBER, GRADE.GRADE_USE, GRADE.GRADE_RELEVANCE, GRADE.GRADE_SERVICE, GRADE.GRADE_VISUAL, GRADE.GRADE_GLOBAL 
            FROM NOTICE 
            NATURAL JOIN VERSION 
            NATURAL JOIN GRADE 
            ORDER BY NOTICE_DATE DESC 
            LIMIT 5;";

    $result = $bdd->query($sql);

    if ($result->num_rows > 0) 
    {
        echo "<table class='last-five-tab'>";
        echo "<tr><th>Date de l'avis</th><th>Version du site concernée</th><th>Note d'utilisation</th><th>Note de pertinence</th><th>Note de service</th><th>Note du visuel</th><th>Appréciation globale</th></tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["NOTICE_DATE"]. "</td><td>" . $row["VERSION_NUMBER"]. "</td><td>" . $row["GRADE_USE"]. "</td><td>" . $row["GRADE_RELEVANCE"]. "</td><td>" . $row["GRADE_SERVICE"]. "</td><td>" . $row["GRADE_VISUAL"]. "</td><td>" . $row["GRADE_GLOBAL"]. "</td></tr>";
        }

        echo "</table>";
    } 
    
    else 
    {
        echo "0 results";
    }

    $bdd->close();
}

function satisfaction_per_version() {
    $bdd = connect();
    $sql = "SELECT VERSION.VERSION_NUMBER, 
                   VERSION.VERSION_RELEASE_DATE, 
                   AVG(GRADE.GRADE_USE) AS AVG_USE, 
                   AVG(GRADE.GRADE_RELEVANCE) AS AVG_RELEVANCE, 
                   AVG(GRADE.GRADE_SERVICE) AS AVG_SERVICE, 
                   AVG(GRADE.GRADE_VISUAL) AS AVG_VISUAL, 
                   AVG(GRADE.GRADE_GLOBAL) AS AVG_GLOBAL
            FROM grade
            NATURAL JOIN notice
            NATURAL JOIN version
            GROUP BY VERSION.VERSION_NUMBER
            ORDER BY VERSION.VERSION_ID ASC";

    $result = $bdd->query($sql);

    $versions = [];
    $avg_use = [];
    $avg_relevance = [];
    $avg_service = [];
    $avg_visual = [];
    $avg_global = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $versions[] = $row['VERSION_NUMBER'];
            $avg_use[] = $row['AVG_USE'];
            $avg_relevance[] = $row['AVG_RELEVANCE'];
            $avg_service[] = $row['AVG_SERVICE'];
            $avg_visual[] = $row['AVG_VISUAL'];
            $avg_global[] = $row['AVG_GLOBAL'];
        }
    } else {
        echo "0 results";
        return;
    }

    // Intégration du graphique
    echo '
    <style>
        .graphic-stats {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .chart-container {
            width: 90%;
            height: 90%; /* Fixe la hauteur pour éviter des problèmes de redimensionnement */
            margin: auto; /* Centre le graphique */
        }
        #satisfactionChart {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
    <div class="chart-container">
        <canvas id="satisfactionChart"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById("satisfactionChart").getContext("2d");
        
        // Créez le graphique une seule fois pour éviter les répétitions
        const satisfactionChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ' . json_encode($versions) . ',
                datasets: [
                    {
                        label: "Utilisation",
                        data: ' . json_encode($avg_use) . ',
                        borderColor: "rgba(255, 99, 132, 1)",
                        fill: false
                    },
                    {
                        label: "Pertinence",
                        data: ' . json_encode($avg_relevance) . ',
                        borderColor: "rgba(54, 162, 235, 1)",
                        fill: false
                    },
                    {
                        label: "Service",
                        data: ' . json_encode($avg_service) . ',
                        borderColor: "rgba(75, 192, 192, 1)",
                        fill: false
                    },
                    {
                        label: "Visuel",
                        data: ' . json_encode($avg_visual) . ',
                        borderColor: "rgba(153, 102, 255, 1)",
                        fill: false
                    },
                    {
                        label: "Global",
                        data: ' . json_encode($avg_global) . ',
                        borderColor: "rgba(255, 159, 64, 1)",
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Versions"
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Scores"
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: "top",
                    },
                    tooltip: {
                        enabled: true,
                    }
                }
            }
        });
    </script>
    ';
}

function all_notices() {
    $bdd = connect();
    $sql = "SELECT NOTICE_DATE, VERSION.VERSION_NUMBER, GRADE.GRADE_USE, GRADE.GRADE_RELEVANCE, GRADE.GRADE_SERVICE, GRADE.GRADE_VISUAL, GRADE.GRADE_GLOBAL 
            FROM NOTICE 
            NATURAL JOIN VERSION 
            NATURAL JOIN GRADE 
            ORDER BY NOTICE_DATE DESC 
            ;";

    $result = $bdd->query($sql);

    if ($result->num_rows > 0) 
    {
        echo "<table class='all-notices-tab'>";
        echo "<tr><th>Date de l'avis</th><th>Version du site concernée</th><th>Note d'utilisation</th><th>Note de pertinence</th><th>Note de service</th><th>Note du visuel</th><th>Appréciation globale</th></tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["NOTICE_DATE"]. "</td><td>" . $row["VERSION_NUMBER"]. "</td><td>" . $row["GRADE_USE"]. "</td><td>" . $row["GRADE_RELEVANCE"]. "</td><td>" . $row["GRADE_SERVICE"]. "</td><td>" . $row["GRADE_VISUAL"]. "</td><td>" . $row["GRADE_GLOBAL"]. "</td></tr>";
        }

        echo "</table>";
    } 
    
    else 
    {
        echo "0 results";
    }

    echo '
    <style>
        .all-stats {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            background-color: white;
            border-radius: 25px;
            box-shadow: 0 0 10px rgba(63, 62, 61, 0.096), 0 0 10px 3px rgba(0, 0, 0, 0.014);
        }

        .all-notices-tab {
            height: 90%;
            width: 90%; /* Ajuste la largeur du tableau à 90% */
            margin: 0 auto; /* Centre le tableau horizontalement */
            border-collapse: collapse;
            table-layout: auto;
            overflow-y: auto;
            display: block;
        }

        .table-container {
            max-height: 100%;
            overflow-y: auto; 
        }

        .all-notices-tab th, .all-notices-tab td {
            border: 1px solid #ddd;
            padding: 9px;
            text-align: left;
            word-wrap: break-word;
            width: auto;
        }

        .all-notices-tab th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .all-notices-tab td {
            background-color: #ffffff;
        }

    </style>
    ';

    $bdd->close();
}

function all_versions() {
    $bdd = connect();

    $sql = "SELECT VERSION_ID, VERSION_NUMBER, VERSION_RELEASE_DATE, VERSION_CHANGELOG
            FROM VERSION
            ORDER BY VERSION_ID DESC";

    $result = $bdd->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="one-version-info">';
            
            // Affichage du titre et de la date de version
            echo '<div class="title-date-version">';
            echo '<h1>Version ' . htmlspecialchars($row['VERSION_NUMBER']) . '</h1>';
            echo '<h2>' . htmlspecialchars($row['VERSION_RELEASE_DATE']) . '</h2>';
            echo '</div>';

            echo '<div class="changelog-version">';
            
            // Diviser le changelog en sections par titre
            $sections = preg_split("/\n(?=🚀|🔧|🛠️|📅)/", $row['VERSION_CHANGELOG']);
            
            foreach ($sections as $section) {
                // Extraire le titre de la section (première ligne)
                preg_match("/^(🚀 Nouveautés|🔧 Améliorations|🛠️ Corrections de bugs|📅 A venir)/", $section, $matches);
                
                if (!empty($matches)) {
                    $sectionTitle = $matches[0];
                    echo '<h2>' . htmlspecialchars($sectionTitle) . '</h2>';
                    
                    // Extraire chaque fait dans la section (lignes suivantes)
                    $facts = preg_split("/\n/", trim(str_replace($sectionTitle, '', $section)));
                    echo '<ul>';
                    foreach ($facts as $fact) {
                        if (trim($fact) !== "") {
                            // Appliquer la mise en forme en gras avant les ":"
                            $fact = preg_replace("/^(.*?)(:)/", "<strong>$1</strong>$2", $fact);
                            // Affichage sans échappement pour permettre l'interprétation HTML
                            echo '<li>' . $fact . '</li>';
                        }
                    }
                    echo '</ul>';
                }
            }
            
            echo '</div>';
            echo '</div>';
        }
    }

    $bdd->close();
}

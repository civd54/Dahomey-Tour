<?php
// Vérification de l'authentification
session_start();

// Informations d'identification (à changer en production)
$admin_username = "admin";
$admin_password = password_hash("Dahomey2025!", PASSWORD_DEFAULT);

// Vérifier si l'utilisateur est déjà connecté
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Afficher le formulaire de connexion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if ($username === $admin_username && password_verify($password, $admin_password)) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header('Location: admin.php');
            exit;
        } else {
            $error = "Identifiants incorrects!";
        }
    }
    
    // Afficher la page de connexion
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dahomey Tour - Connexion</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Poppins:wght@800;900&display=swap" rel="stylesheet">
        <style>
            :root {
                --vert: rgb(27, 208, 87);
                --jaune: #FCD116;
                --rouge: #E8112D;
                --dark: #1A1A1A;
                --light: #FFFFFF;
            }
            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Montserrat', sans-serif;
                background: linear-gradient(135deg, var(--dark) 0%, #1a1a2e 100%);
                color: var(--light);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            
            .login-container {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 50px;
                width: 100%;
                max-width: 450px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
                border: 1px solid rgba(252, 209, 22, 0.2);
            }
            
            .logo {
                text-align: center;
                margin-bottom: 30px;
            }
            
            .logo img {
                max-width: 200px;
                height: auto;
            }
            
            h1 {
                text-align: center;
                margin-bottom: 40px;
                color: var(--jaune);
                font-family: 'Poppins', sans-serif;
            }
            
            .form-group {
                margin-bottom: 25px;
            }
            
            label {
                display: block;
                margin-bottom: 8px;
                color: var(--jaune);
                font-weight: 500;
            }
            
            input {
                width: 100%;
                padding: 15px;
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 10px;
                background: rgba(255, 255, 255, 0.05);
                color: var(--light);
                font-size: 1rem;
                transition: all 0.3s ease;
            }
            
            input:focus {
                outline: none;
                border-color: var(--jaune);
                box-shadow: 0 0 0 3px rgba(252, 209, 22, 0.1);
            }
            
            button {
                width: 100%;
                padding: 15px;
                background: linear-gradient(45deg, var(--vert), var(--jaune));
                color: var(--dark);
                border: none;
                border-radius: 10px;
                font-weight: 700;
                font-size: 1.1rem;
                cursor: pointer;
                transition: all 0.3s ease;
                margin-top: 10px;
            }
            
            button:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 20px rgba(252, 209, 22, 0.3);
            }
            
            .error {
                background: rgba(232, 17, 45, 0.1);
                color: var(--rouge);
                padding: 15px;
                border-radius: 10px;
                margin-bottom: 20px;
                border: 1px solid rgba(232, 17, 45, 0.3);
            }
            
            @media (max-width: 768px) {
                .login-container {
                    padding: 30px;
                }
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="logo">
                <img src="uploads/logo.png" alt="Dahomey Tour">
            </div>
            <h1>Connexion Administrateur</h1>
            
            <?php if (isset($error)): ?>
                <div class="error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dahomey_tour";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

// Traitement des actions
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'modifier_hero':
            // Code pour modifier la section hero
            break;
            
        case 'ajouter_evenement':
            // Code pour ajouter un événement
            break;
            
        case 'ajouter_photo_galerie':
            // Code pour ajouter une photo
            break;
            
        case 'modifier_service':
            // Code pour modifier un service
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dahomey Tour</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Poppins:wght@800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --vert: rgb(27, 208, 87);
            --jaune: #FCD116;
            --rouge: #E8112D;
            --dark: #1A1A1A;
            --light: #FFFFFF;
            --gray: #2D3748;
            --gray-light: #4A5568;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: #0F172A;
            color: var(--light);
            min-height: 100vh;
            display: flex;
        }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #1E293B;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid #334155;
            padding: 20px 0;
        }
        
        .logo {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #334155;
            margin-bottom: 30px;
        }
        
        .logo img {
            max-width: 180px;
            height: auto;
        }
        
        .nav-links {
            list-style: none;
            padding: 0 20px;
        }
        
        .nav-item {
            margin-bottom: 10px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #CBD5E1;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-link i {
            margin-right: 12px;
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }
        
        .nav-link:hover,
        .nav-link.active {
            background: linear-gradient(90deg, var(--vert), var(--vert-fonce));
            color: white;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: #1E293B;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-family: 'Poppins', sans-serif;
            color: var(--jaune);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logout-btn {
            background: var(--rouge);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: var(--rouge-fonce);
        }
        
        /* Dashboard Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #1E293B 0%, #334155 100%);
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #475569;
        }
        
        .stat-icon {
            font-size: 2rem;
            margin-bottom: 15px;
            color: var(--jaune);
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--light);
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #CBD5E1;
            font-size: 0.9rem;
        }
        
        /* Content Sections */
        .content-section {
            background: #1E293B;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #334155;
        }
        
        .section-title {
            color: var(--jaune);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #334155;
            font-family: 'Poppins', sans-serif;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #E2E8F0;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: #0F172A;
            border: 1px solid #475569;
            border-radius: 6px;
            color: var(--light);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--jaune);
            box-shadow: 0 0 0 3px rgba(252, 209, 22, 0.1);
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        
        .file-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            background: #0F172A;
            border: 2px dashed #475569;
            border-radius: 6px;
            color: #94A3B8;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-label:hover {
            border-color: var(--jaune);
            color: var(--jaune);
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.95rem;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--vert), var(--vert-fonce));
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(27, 208, 87, 0.3);
        }
        
        .btn-warning {
            background: linear-gradient(45deg, var(--jaune), #EAB308);
            color: var(--dark);
        }
        
        .btn-danger {
            background: linear-gradient(45deg, var(--rouge), var(--rouge-fonce));
            color: white;
        }
        
        /* Tables */
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            background: #0F172A;
        }
        
        .table th {
            background: #1E293B;
            color: var(--jaune);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #334155;
        }
        
        .table td {
            padding: 15px;
            border-bottom: 1px solid #334155;
            color: #E2E8F0;
        }
        
        .table tr:hover {
            background: rgba(252, 209, 22, 0.05);
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }
        
        /* Message Alerts */
        .alert {
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-success {
            background: rgba(27, 208, 87, 0.1);
            color: var(--vert);
            border: 1px solid rgba(27, 208, 87, 0.3);
        }
        
        .alert-error {
            background: rgba(232, 17, 45, 0.1);
            color: var(--rouge);
            border: 1px solid rgba(232, 17, 45, 0.3);
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .modal-content {
            background: #1E293B;
            border-radius: 10px;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #334155;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-title {
            color: var(--jaune);
            font-family: 'Poppins', sans-serif;
        }
        
        .modal-close {
            background: none;
            border: none;
            color: #94A3B8;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar .logo img {
                max-width: 40px;
            }
            
            .nav-link span {
                display: none;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="uploads/logo.png" alt="Dahomey Tour">
        </div>
        
        <ul class="nav-links">
            <li class="nav-item">
                <a href="#dashboard" class="nav-link active" data-target="dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#hero" class="nav-link" data-target="hero-section">
                    <i class="fas fa-home"></i>
                    <span>Section Hero</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#evenements" class="nav-link" data-target="evenements-section">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Événements</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#services" class="nav-link" data-target="services-section">
                    <i class="fas fa-concierge-bell"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#galerie" class="nav-link" data-target="galerie-section">
                    <i class="fas fa-images"></i>
                    <span>Galerie</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#histoire" class="nav-link" data-target="histoire-section">
                    <i class="fas fa-landmark"></i>
                    <span>Histoire</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#contact" class="nav-link" data-target="contact-section">
                    <i class="fas fa-address-book"></i>
                    <span>Contact</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#tickets" class="nav-link" data-target="tickets-section">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Tickets Vendus</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#messages" class="nav-link" data-target="messages-section">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span>
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1 id="section-title">Tableau de bord</h1>
            <div class="user-info">
                <span>Connecté en tant que: <strong><?php echo $_SESSION['admin_username']; ?></strong></span>
                <a href="logout.php" class="btn logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>
        
        <!-- Messages -->
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <i class="fas fa-info-circle"></i> <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <!-- Dashboard Content -->
        <div id="dashboard" class="content-section">
            <h2 class="section-title">Statistiques</h2>
            
            <div class="stats-grid">
                <?php
                // Récupérer les statistiques
                $stats = [];
                
                // Événements à venir
                $stmt = $conn->query("SELECT COUNT(*) as count FROM evenements WHERE date >= CURDATE()");
                $stats['evenements'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                
                // Événements passés
                $stmt = $conn->query("SELECT COUNT(*) as count FROM evenements WHERE date < CURDATE()");
                $stats['evenements_passes'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                
                // Photos dans la galerie
                $stmt = $conn->query("SELECT COUNT(*) as count FROM galerie");
                $stats['photos'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                
                // Messages non lus
                $stmt = $conn->query("SELECT COUNT(*) as count FROM messages WHERE lu = 0");
                $stats['messages'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                ?>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-value"><?php echo $stats['evenements']; ?></div>
                    <div class="stat-label">Événements à venir</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="stat-value"><?php echo $stats['evenements_passes']; ?></div>
                    <div class="stat-label">Événements passés</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="stat-value"><?php echo $stats['photos']; ?></div>
                    <div class="stat-label">Photos galerie</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-value"><?php echo $stats['messages']; ?></div>
                    <div class="stat-label">Messages non lus</div>
                </div>
            </div>
            
            <h2 class="section-title">Actions rapides</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Ajouter un événement</h3>
                    <p>Créez un nouvel événement</p>
                    <button class="btn btn-primary" onclick="showModal('ajouter-evenement')">
                        <i class="fas fa-plus"></i> Ajouter
                    </button>
                </div>
                
                <div class="stat-card">
                    <h3>Ajouter une photo</h3>
                    <p>Ajoutez des photos à la galerie</p>
                    <button class="btn btn-primary" onclick="showModal('ajouter-photo')">
                        <i class="fas fa-upload"></i> Uploader
                    </button>
                </div>
                
                <div class="stat-card">
                    <h3>Voir les messages</h3>
                    <p>Consultez les messages reçus</p>
                    <a href="#messages" class="btn btn-primary" data-target="messages-section">
                        <i class="fas fa-envelope-open"></i> Voir
                    </a>
                </div>
                
                <div class="stat-card">
                    <h3>Tickets vendus</h3>
                    <p>Consultez les ventes de tickets</p>
                    <a href="#tickets" class="btn btn-primary" data-target="tickets-section">
                        <i class="fas fa-chart-bar"></i> Statistiques
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Hero Section Management -->
        <div id="hero-section" class="content-section" style="display: none;">
            <h2 class="section-title">Gestion de la section Hero</h2>
            
            <form action="admin.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="modifier_hero">
                
                <div class="form-group">
                    <label class="form-label">Titre principal</label>
                    <input type="text" name="hero_title" class="form-control" 
                           value="Vivez l'énergie du Bénin autrement">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Sous-titre</label>
                    <textarea name="hero_subtitle" class="form-control" rows="3">
Dahomey Tour, c'est plus que des soirées : c'est une vibe, une culture, une fierté.  
Sur les plages, dans les rues ou au cœur de l'histoire, on transforme chaque moment en souvenir inoubliable.
                    </textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Image de fond</label>
                    <div class="file-upload">
                        <label class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Choisir une image</span>
                            <input type="file" name="hero_image" accept="image/*">
                        </label>
                    </div>
                    <small class="text-muted">Taille recommandée: 1920x1080px</small>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </form>
        </div>
        
        <!-- Événements Management -->
        <div id="evenements-section" class="content-section" style="display: none;">
            <h2 class="section-title">Gestion des Événements</h2>
            
            <button class="btn btn-primary mb-4" onclick="showModal('ajouter-evenement')">
                <i class="fas fa-plus"></i> Ajouter un événement
            </button>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Prix</th>
                            <th>Places</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->query("SELECT * FROM evenements ORDER BY date DESC");
                        $evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach ($evenements as $event):
                            $status = strtotime($event['date']) >= time() ? 'À venir' : 'Terminé';
                            $status_class = strtotime($event['date']) >= time() ? 'btn-warning' : 'btn-danger';
                        ?>
                        <tr>
                            <td>
                                <img src="uploads/evenements/<?php echo $event['image']; ?>" 
                                     alt="<?php echo $event['titre']; ?>"
                                     style="width: 80px; height: 60px; object-fit: cover; border-radius: 5px;">
                            </td>
                            <td><?php echo $event['titre']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($event['date'])); ?></td>
                            <td><?php echo number_format($event['prix'], 0, ',', ' '); ?> FCFA</td>
                            <td><?php echo $event['places_disponibles']; ?> / <?php echo $event['places_total']; ?></td>
                            <td>
                                <span class="btn btn-sm <?php echo $status_class; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary" 
                                            onclick="editerEvenement(<?php echo $event['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" 
                                            onclick="supprimerEvenement(<?php echo $event['id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Services Management -->
        <div id="services-section" class="content-section" style="display: none;">
            <h2 class="section-title">Gestion des Services</h2>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ordre</th>
                            <th>Icône</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->query("SELECT * FROM services ORDER BY ordre");
                        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach ($services as $service):
                        ?>
                        <tr>
                            <td><?php echo $service['ordre']; ?></td>
                            <td><i class="fas <?php echo $service['icone']; ?>"></i></td>
                            <td><?php echo $service['titre']; ?></td>
                            <td><?php echo substr($service['description'], 0, 100); ?>...</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary" 
                                            onclick="editerService(<?php echo $service['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Galerie Management -->
        <div id="galerie-section" class="content-section" style="display: none;">
            <h2 class="section-title">Gestion de la Galerie</h2>
            
            <button class="btn btn-primary mb-4" onclick="showModal('ajouter-photo')">
                <i class="fas fa-plus"></i> Ajouter une photo
            </button>
            
            <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                <?php
                $stmt = $conn->query("SELECT * FROM galerie ORDER BY date DESC");
                $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($photos as $photo):
                ?>
                <div class="gallery-item">
                    <img src="uploads/galerie/<?php echo $photo['image']; ?>" 
                         alt="<?php echo $photo['nom']; ?>"
                         style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
                    <div style="padding: 10px; background: #0F172A; border-radius: 0 0 8px 8px;">
                        <p style="font-size: 0.9rem; margin-bottom: 5px;"><?php echo $photo['nom']; ?></p>
                        <p style="font-size: 0.8rem; color: #94A3B8;"><?php echo date('d/m/Y', strtotime($photo['date'])); ?></p>
                        <button class="btn btn-sm btn-danger" 
                                onclick="supprimerPhoto(<?php echo $photo['id']; ?>)">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Histoire Management -->
        <div id="histoire-section" class="content-section" style="display: none;">
            <h2 class="section-title">Gestion de l'Histoire</h2>
            
            <form action="admin.php" method="POST">
                <input type="hidden" name="action" value="modifier_histoire">
                
                <div class="form-group">
                    <label class="form-label">Titre de l'histoire</label>
                    <input type="text" name="histoire_titre" class="form-control" 
                           value="L'Épopée du Royaume de Dahomey">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Contenu</label>
                    <textarea name="histoire_contenu" class="form-control" rows="8">
Le Dahomey, royaume emblématique de l'Afrique de l'Ouest, a marqué l'histoire par sa puissance militaire, son organisation sociale et sa riche culture. Fondé au 17ème siècle, ce royaume a prospéré pendant près de trois siècles avant de devenir une partie intégrante de l'actuel Bénin.

Connu pour ses célèbres Amazones - une unité militaire exclusivement féminine - le Dahomey impressionnait par sa discipline et sa stratégie militaire. Ces guerrières d'élite, redoutées dans toute la région, étaient au service du roi et constituaient l'une des premières unités militaires féminines modernes.

L'organisation sociale du Dahomey était remarquablement structurée, avec un système administratif complexe et une économie basée sur l'agriculture, le commerce et les arts. Le royaume était particulièrement réputé pour ses sculptures sur bois, ses bas-reliefs et ses tissus richement décorés.

Le nom "Dahomey" signifie "dans le ventre de Dan" en référence à Dan, un roi fondateur. Ce nom symbolisait l'unité et la force du royaume, des valeurs que nous perpétuons à travers Dahomey Tour en créant des événements qui unissent les gens et célèbrent notre riche héritage.
                    </textarea>
                </div>
                
                <h3 class="mt-5 mb-3">Timeline</h3>
                
                <div id="timeline-container">
                    <?php
                    $stmt = $conn->query("SELECT * FROM timeline ORDER BY annee");
                    $timeline = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($timeline as $item):
                    ?>
                    <div class="timeline-item-form mb-4 p-3" style="background: #0F172A; border-radius: 8px;">
                        <input type="hidden" name="timeline_id[]" value="<?php echo $item['id']; ?>">
                        
                        <div class="form-group">
                            <label class="form-label">Année</label>
                            <input type="text" name="timeline_annee[]" class="form-control" 
                                   value="<?php echo $item['annee']; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Titre</label>
                            <input type="text" name="timeline_titre[]" class="form-control" 
                                   value="<?php echo $item['titre']; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="timeline_description[]" class="form-control" rows="3"><?php echo $item['description']; ?></textarea>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="button" class="btn btn-warning mb-4" onclick="ajouterTimelineItem()">
                    <i class="fas fa-plus"></i> Ajouter un élément à la timeline
                </button>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </form>
        </div>
        
        <!-- Contact Management -->
        <div id="contact-section" class="content-section" style="display: none;">
            <h2 class="section-title">Gestion des Informations de Contact</h2>
            
            <form action="admin.php" method="POST">
                <input type="hidden" name="action" value="modifier_contact">
                
                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control" 
                           value="+229 01 58 17 34 32">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" 
                           value="info@dahomeytour.bj">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Adresse</label>
                    <textarea name="adresse" class="form-control" rows="3">Plage Fidjrossè, Cotonou, Bénin (près de l'avion)</textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Liens sociaux (Facebook)</label>
                    <input type="text" name="facebook" class="form-control" 
                           value="https://facebook.com/profile.php?id=100092640841907">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Instagram</label>
                    <input type="text" name="instagram" class="form-control">
                </div>
                
                <div class="form-group">
                    <label class="form-label">TikTok</label>
                    <input type="text" name="tiktok" class="form-control">
                </div>
                
                <div class="form-group">
                    <label class="form-label">WhatsApp</label>
                    <input type="text" name="whatsapp" class="form-control">
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </form>
        </div>
        
        <!-- Tickets Management -->
        <div id="tickets-section" class="content-section" style="display: none;">
            <h2 class="section-title">Tickets Vendus</h2>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Ticket</th>
                            <th>Événement</th>
                            <th>Client</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Quantité</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Simuler des données de tickets (à remplacer par une vraie requête)
                        $tickets = [
                            ['id' => 'TKT001', 'event' => 'OUIDAH TRIP', 'client' => 'Jean Dupont', 
                             'email' => 'jean@email.com', 'phone' => '+229 01 23 45 67', 
                             'quantity' => 2, 'amount' => '12,000', 'date' => '15/01/2025', 'status' => 'Payé'],
                            ['id' => 'TKT002', 'event' => 'GARI PARTY', 'client' => 'Marie Koné', 
                             'email' => 'marie@email.com', 'phone' => '+229 02 34 56 78', 
                             'quantity' => 1, 'amount' => '1,000', 'date' => '10/01/2025', 'status' => 'Payé'],
                            ['id' => 'TKT003', 'event' => 'ATASSI PARTY', 'client' => 'Paul Akakpo', 
                             'email' => 'paul@email.com', 'phone' => '+229 03 45 67 89', 
                             'quantity' => 3, 'amount' => '3,000', 'date' => '05/01/2025', 'status' => 'Payé'],
                        ];
                        
                        foreach ($tickets as $ticket):
                        ?>
                        <tr>
                            <td><?php echo $ticket['id']; ?></td>
                            <td><?php echo $ticket['event']; ?></td>
                            <td><?php echo $ticket['client']; ?></td>
                            <td><?php echo $ticket['email']; ?></td>
                            <td><?php echo $ticket['phone']; ?></td>
                            <td><?php echo $ticket['quantity']; ?></td>
                            <td><?php echo $ticket['amount']; ?> FCFA</td>
                            <td><?php echo $ticket['date']; ?></td>
                            <td>
                                <span class="btn btn-sm btn-primary"><?php echo $ticket['status']; ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Messages Management -->
        <div id="messages-section" class="content-section" style="display: none;">
            <h2 class="section-title">Messages Reçus</h2>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Événement</th>
                            <th>Message</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->query("SELECT * FROM messages ORDER BY date_envoi DESC");
                        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach ($messages as $msg):
                            $status_class = $msg['lu'] ? 'btn-primary' : 'btn-warning';
                            $status_text = $msg['lu'] ? 'Lu' : 'Non lu';
                        ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i', strtotime($msg['date_envoi'])); ?></td>
                            <td><?php echo $msg['nom']; ?></td>
                            <td><?php echo $msg['email']; ?></td>
                            <td><?php echo $msg['telephone']; ?></td>
                            <td><?php echo $msg['evenement_id'] ? 'ID: ' . $msg['evenement_id'] : 'Aucun'; ?></td>
                            <td><?php echo substr($msg['message'], 0, 50); ?>...</td>
                            <td>
                                <span class="btn btn-sm <?php echo $status_class; ?>">
                                    <?php echo $status_text; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary" 
                                            onclick="voirMessage(<?php echo $msg['id']; ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" 
                                            onclick="supprimerMessage(<?php echo $msg['id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modals -->
    <div id="ajouter-evenement" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter un Événement</h3>
                <button class="modal-close" onclick="hideModal('ajouter-evenement')">&times;</button>
            </div>
            <div class="modal-body">
                <form action="admin.php" method="POST" enctype="multipart/form-data" id="form-ajouter-evenement">
                    <input type="hidden" name="action" value="ajouter_evenement">
                    
                    <div class="form-group">
                        <label class="form-label">Titre de l'événement</label>
                        <input type="text" name="titre" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Heure</label>
                        <input type="time" name="heure" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Lieu</label>
                        <input type="text" name="lieu" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Prix (FCFA)</label>
                        <input type="number" name="prix" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Nombre total de places</label>
                        <input type="number" name="places_total" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Icône (Font Awesome)</label>
                        <input type="text" name="icone" class="form-control" value="fas fa-music">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Caractéristiques (séparées par des points-virgules)</label>
                        <textarea name="caracteristiques" class="form-control" rows="3" 
                                  placeholder="Visite;Divertissement;Concours;Jeux & Danse;Réseautage"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Image de l'événement</label>
                        <div class="file-upload">
                            <label class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choisir une image</span>
                                <input type="file" name="image" accept="image/*" required>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Ajouter l'événement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div id="ajouter-photo" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter une Photo à la Galerie</h3>
                <button class="modal-close" onclick="hideModal('ajouter-photo')">&times;</button>
            </div>
            <div class="modal-body">
                <form action="admin.php" method="POST" enctype="multipart/form-data" id="form-ajouter-photo">
                    <input type="hidden" name="action" value="ajouter_photo_galerie">
                    
                    <div class="form-group">
                        <label class="form-label">Nom de l'événement</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Date de l'événement</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Lieu</label>
                        <input type="text" name="lieu" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Image</label>
                        <div class="file-upload">
                            <label class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choisir une image</span>
                                <input type="file" name="image" accept="image/*" required>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Ajouter la photo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Mettre à jour la navigation active
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                
                // Afficher la section correspondante
                const target = this.getAttribute('data-target');
                document.querySelectorAll('.content-section').forEach(section => {
                    section.style.display = 'none';
                });
                
                if (target === 'dashboard') {
                    document.getElementById('section-title').textContent = 'Tableau de bord';
                } else if (target === 'hero-section') {
                    document.getElementById('section-title').textContent = 'Gestion de la section Hero';
                } else if (target === 'evenements-section') {
                    document.getElementById('section-title').textContent = 'Gestion des Événements';
                } else if (target === 'services-section') {
                    document.getElementById('section-title').textContent = 'Gestion des Services';
                } else if (target === 'galerie-section') {
                    document.getElementById('section-title').textContent = 'Gestion de la Galerie';
                } else if (target === 'histoire-section') {
                    document.getElementById('section-title').textContent = "Gestion de l'Histoire";
                } else if (target === 'contact-section') {
                    document.getElementById('section-title').textContent = 'Gestion du Contact';
                } else if (target === 'tickets-section') {
                    document.getElementById('section-title').textContent = 'Tickets Vendus';
                } else if (target === 'messages-section') {
                    document.getElementById('section-title').textContent = 'Messages Reçus';
                }
                
                document.getElementById(target).style.display = 'block';
            });
        });
        
        // Fonctions pour les modals
        function showModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }
        
        function hideModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        // Gestion des formulaires modaux
        document.querySelectorAll('.modal form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const action = this.getAttribute('action');
                
                fetch(action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // Recharger la page pour voir les modifications
                    location.reload();
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue.');
                });
            });
        });
        
        // Fonctions CRUD
        function editerEvenement(id) {
            alert('Édition de l\'événement ' + id + ' (fonctionnalité à implémenter)');
        }
        
        function supprimerEvenement(id) {
            if (confirm('Voulez-vous vraiment supprimer cet événement ?')) {
                fetch('supprimer_evenement.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Erreur: ' + data.message);
                        }
                    });
            }
        }
        
        function editerService(id) {
            alert('Édition du service ' + id + ' (fonctionnalité à implémenter)');
        }
        
        function supprimerPhoto(id) {
            if (confirm('Voulez-vous vraiment supprimer cette photo ?')) {
                fetch('supprimer_photo.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Erreur: ' + data.message);
                        }
                    });
            }
        }
        
        function voirMessage(id) {
            fetch('voir_message.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Message de: ' + data.message.nom + '\n\n' + data.message.message);
                        location.reload();
                    }
                });
        }
        
        function supprimerMessage(id) {
            if (confirm('Voulez-vous vraiment supprimer ce message ?')) {
                fetch('supprimer_message.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
            }
        }
        
        // Ajouter un élément à la timeline
        function ajouterTimelineItem() {
            const container = document.getElementById('timeline-container');
            const newItem = document.createElement('div');
            newItem.className = 'timeline-item-form mb-4 p-3';
            newItem.style.background = '#0F172A';
            newItem.style.borderRadius = '8px';
            
            newItem.innerHTML = `
                <input type="hidden" name="timeline_id[]" value="new">
                
                <div class="form-group">
                    <label class="form-label">Année</label>
                    <input type="text" name="timeline_annee[]" class="form-control" placeholder="ex: 1600 - 1620">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Titre</label>
                    <input type="text" name="timeline_titre[]" class="form-control" placeholder="ex: Fondation du Royaume">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="timeline_description[]" class="form-control" rows="3" placeholder="Description de l'événement"></textarea>
                </div>
                
                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">
                    <i class="fas fa-trash"></i> Supprimer cet élément
                </button>
            `;
            
            container.appendChild(newItem);
        }
        
        // Fermer les modals en cliquant en dehors
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.style.display = 'none';
            }
        });
    </script>
</body>
</html>
<?php
// Fermer la connexion à la base de données
$conn = null;
?>
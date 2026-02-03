<?php
// tickets.php - Page d'achat des tickets

session_start();

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

// Récupérer l'événement si spécifié dans l'URL
$event_id = $_GET['event_id'] ?? null;
$event = null;

if ($event_id) {
    $stmt = $conn->prepare("SELECT * FROM evenements WHERE id = ? AND date >= CURDATE()");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Récupérer tous les événements à venir pour la liste
$stmt = $conn->query("SELECT * FROM evenements WHERE date >= CURDATE() ORDER BY date");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement de l'achat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $quantite = $_POST['quantite'];
    $montant_total = $_POST['montant_total'];
    
    // Générer un numéro de commande unique
    $commande_id = 'CMD' . date('YmdHis') . rand(100, 999);
    
    // Enregistrer la commande dans la base de données
    $stmt = $conn->prepare("INSERT INTO commandes (commande_id, evenement_id, nom, prenom, email, telephone, quantite, montant_total, statut) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'en_attente')");
    $stmt->execute([$commande_id, $event_id, $nom, $prenom, $email, $telephone, $quantite, $montant_total]);
    
    // Rediriger vers le paiement FedaPay
    header("Location: paiement.php?commande_id=" . $commande_id);
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acheter des Tickets - Dahomey Tour</title>
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
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo {
            margin-bottom: 20px;
        }
        
        .logo img {
            max-width: 200px;
            height: auto;
        }
        
        h1 {
            font-family: 'Poppins', sans-serif;
            color: var(--jaune);
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #CBD5E1;
            margin-bottom: 30px;
        }
        
        .content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
        }
        
        @media (min-width: 992px) {
            .content {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        /* Sélection d'événement */
        .events-list {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(252, 209, 22, 0.2);
        }
        
        .event-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        
        .event-item:hover,
        .event-item.selected {
            border-color: var(--jaune);
            background: rgba(252, 209, 22, 0.05);
        }
        
        .event-title {
            color: var(--jaune);
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .event-date {
            color: #94A3B8;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        
        .event-price {
            color: var(--vert);
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        /* Formulaire d'achat */
        .purchase-form {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(252, 209, 22, 0.2);
        }
        
        .selected-event-info {
            background: rgba(252, 209, 22, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 4px solid var(--jaune);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--jaune);
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: var(--light);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--jaune);
            box-shadow: 0 0 0 3px rgba(252, 209, 22, 0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .quantity-btn {
            width: 40px;
            height: 40px;
            background: var(--vert);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .quantity-input {
            width: 80px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: 700;
        }
        
        .total-amount {
            text-align: center;
            padding: 20px;
            background: rgba(27, 208, 87, 0.1);
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .total-label {
            color: #CBD5E1;
            margin-bottom: 10px;
        }
        
        .total-value {
            font-size: 2rem;
            color: var(--vert);
            font-weight: 700;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 15px 30px;
            background: linear-gradient(45deg, var(--vert), var(--jaune));
            color: var(--dark);
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            gap: 10px;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(252, 209, 22, 0.3);
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="uploads/logo.png" alt="Dahomey Tour">
            </div>
            <h1>Acheter des Tickets</h1>
            <p class="subtitle">Réservez votre place pour nos prochains événements</p>
        </div>
        
        <div class="content">
            <!-- Liste des événements -->
            <div class="events-list">
                <h2 style="color: var(--jaune); margin-bottom: 20px;">Événements disponibles</h2>
                
                <?php foreach ($events as $ev): ?>
                <div class="event-item" 
                     onclick="selectEvent(<?php echo $ev['id']; ?>, '<?php echo addslashes($ev['titre']); ?>', <?php echo $ev['prix']; ?>, <?php echo $ev['places_disponibles']; ?>)"
                     id="event-<?php echo $ev['id']; ?>">
                    <div class="event-title"><?php echo $ev['titre']; ?></div>
                    <div class="event-date">
                        <i class="far fa-calendar"></i> 
                        <?php echo date('d F Y', strtotime($ev['date'])); ?> • 
                        <i class="far fa-clock"></i> <?php echo $ev['heure']; ?>
                    </div>
                    <div class="event-price"><?php echo number_format($ev['prix'], 0, ',', ' '); ?> FCFA</div>
                    <div style="font-size: 0.9rem; color: #94A3B8; margin-top: 5px;">
                        <i class="fas fa-users"></i> 
                        <?php echo $ev['places_disponibles']; ?> places disponibles
                    </div>
                </div>
                <?php endforeach; ?>
                
                <?php if (empty($events)): ?>
                <div style="text-align: center; padding: 40px; color: #94A3B8;">
                    <i class="fas fa-calendar-times fa-3x" style="margin-bottom: 20px;"></i>
                    <p>Aucun événement à venir pour le moment.</p>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Formulaire d'achat -->
            <div class="purchase-form">
                <h2 style="color: var(--jaune); margin-bottom: 20px;">Informations d'achat</h2>
                
                <div class="selected-event-info" id="selected-event-info" style="display: none;">
                    <div style="font-weight: 700; color: var(--jaune); margin-bottom: 10px;" id="selected-event-title"></div>
                    <div style="color: #CBD5E1; font-size: 0.9rem;" id="selected-event-details"></div>
                </div>
                
                <form id="purchase-form" method="POST" action="tickets.php">
                    <input type="hidden" name="event_id" id="event_id">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="prenom" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" name="telephone" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Nombre de tickets</label>
                        <div class="quantity-selector">
                            <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                            <input type="number" name="quantite" id="quantite" class="form-control quantity-input" value="1" min="1" max="10" readonly>
                            <button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
                        </div>
                        <div style="font-size: 0.9rem; color: #94A3B8; margin-top: 10px;">
                            Maximum 10 tickets par commande
                        </div>
                    </div>
                    
                    <div class="total-amount">
                        <div class="total-label">Montant total</div>
                        <div class="total-value" id="total-amount">0 FCFA</div>
                        <input type="hidden" name="montant_total" id="montant_total">
                    </div>
                    
                    <button type="submit" class="btn" id="purchase-btn" disabled>
                        <i class="fas fa-shopping-cart"></i>
                        <span id="btn-text">Sélectionnez un événement</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        let selectedEvent = null;
        let eventPrice = 0;
        let maxPlaces = 0;
        let quantity = 1;
        
        // Sélectionner un événement
        function selectEvent(id, title, price, availablePlaces) {
            // Mettre à jour la sélection visuelle
            document.querySelectorAll('.event-item').forEach(item => {
                item.classList.remove('selected');
            });
            document.getElementById('event-' + id).classList.add('selected');
            
            // Mettre à jour les variables
            selectedEvent = id;
            eventPrice = price;
            maxPlaces = Math.min(availablePlaces, 10);
            
            // Mettre à jour l'affichage
            document.getElementById('selected-event-info').style.display = 'block';
            document.getElementById('selected-event-title').textContent = title;
            document.getElementById('selected-event-details').innerHTML = `
                <div>Prix unitaire: ${formatPrice(price)} FCFA</div>
                <div>Places disponibles: ${availablePlaces}</div>
            `;
            
            // Mettre à jour le formulaire
            document.getElementById('event_id').value = id;
            document.getElementById('quantite').max = maxPlaces;
            
            // Réinitialiser la quantité si nécessaire
            if (quantity > maxPlaces) {
                quantity = 1;
                document.getElementById('quantite').value = quantity;
            }
            
            // Calculer le montant total
            calculateTotal();
            
            // Activer le bouton d'achat
            document.getElementById('purchase-btn').disabled = false;
            document.getElementById('btn-text').textContent = 'Procéder au paiement';
        }
        
        // Changer la quantité
        function changeQuantity(change) {
            const newQuantity = quantity + change;
            const max = parseInt(document.getElementById('quantite').max);
            
            if (newQuantity >= 1 && newQuantity <= max) {
                quantity = newQuantity;
                document.getElementById('quantite').value = quantity;
                calculateTotal();
            }
        }
        
        // Calculer le montant total
        function calculateTotal() {
            if (selectedEvent) {
                const total = eventPrice * quantity;
                document.getElementById('total-amount').textContent = formatPrice(total) + ' FCFA';
                document.getElementById('montant_total').value = total;
            } else {
                document.getElementById('total-amount').textContent = '0 FCFA';
            }
        }
        
        // Formater le prix
        function formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
        
        // Sélectionner automatiquement l'événement depuis l'URL
        <?php if ($event): ?>
        window.addEventListener('DOMContentLoaded', function() {
            selectEvent(
                <?php echo $event['id']; ?>,
                '<?php echo addslashes($event['titre']); ?>',
                <?php echo $event['prix']; ?>,
                <?php echo $event['places_disponibles']; ?>
            );
        });
        <?php endif; ?>
        
        // Validation du formulaire
        document.getElementById('purchase-form').addEventListener('submit', function(e) {
            if (!selectedEvent) {
                e.preventDefault();
                alert('Veuillez sélectionner un événement.');
                return;
            }
            
            if (quantity > maxPlaces) {
                e.preventDefault();
                alert('La quantité demandée dépasse le nombre de places disponibles.');
                return;
            }
        });
    </script>
</body>
</html>
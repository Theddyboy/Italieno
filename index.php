<!DOCTYPE html>
<html lang="no">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles.css" />
  <title>Bestill Bord - Italiensk Uke</title>
</head>

<body>
  <nav>
    <a href="#">Hjem</a>
    <a href="#">Meny</a>
    <a href="#">Bestill Bord</a>
  </nav>

  <div class="hero" id="hero">
    <h1>Velkommen til vår nettside</h1>
  </div>

  <!-- Om Italiensk Uke Section -->
  <section class="about">
    <h2 id="overskrift">Om Italiensk Uke</h2>
    <p>Under den internasjonale uken feirer vi kulturer fra hele verden, med fokus på italiensk mat og tradisjoner.</p>
    <p><strong>Italiensk Matopplevelse:</strong> Vårt kjøkken serverer autentiske italienske retter som klassiske pastaretter, pizza og tiramisù.</p>
    <p><strong>Italienske Tradisjoner:</strong> Opplev kultur, musikk og lær noen italienske uttrykk.</p>
    <p>Kom og nyt smaken og kulturen fra Italia, og bli med på en uforglemmelig internasjonal uke!</p>
  </section>

  <!-- Meny Section -->
  <section class="menu-section">
    <h2>Vår Meny</h2>
    <div class="menu-grid" id="menu-items">
      <div class="menu-item" data-name="Pasta Carbonara" data-price="150" data-type="main">
        <img src="Pasta Carbonara.jpg" alt="Pasta Carbonara" />
        <h3>Pasta Carbonara</h3>
        <p>Klassisk italiensk rett med pancetta og parmesan.</p>
        <p><strong>Pris: 150 NOK</strong></p>
        <button class="select-item">Velg denne hovedretten</button>
      </div>
      <div class="menu-item" data-name="Pizza Margherita" data-price="180" data-type="main">
        <img src="Pizza Margherita.jpg" alt="Pizza Margherita" />
        <h3>Pizza Margherita</h3>
        <p>Italiensk pizza med ferske tomater og mozzarella.</p>
        <p><strong>Pris: 180 NOK</strong></p>
        <button class="select-item">Velg denne hovedretten</button>
      </div>
    </div>
  </section>

  <!-- Bestill Bord Form -->
  <section class="register-section">
    <h2>Bestill Bord</h2>
    <form id="bookingForm" method="post">
      <input type="text" name="fornavn" placeholder="Fornavn" required />
      <input type="text" name="etternavn" placeholder="Etternavn" required />
      <label for="dag">Select a day:</label>
      <select name="dag" id="dag" required>
        <option value="">-- Select a day --</option>
        <option value="monday">Monday</option>
        <option value="tuesday">Tuesday</option>
        <option value="wednesday">Wednesday</option>
        <option value="thursday">Thursday</option>
        <option value="friday">Friday</option>
      </select>

      <input type="time" name="tid" required />
  

      <div class="select-menus">
        <div class="menu-select">
          <label for="main-dish">Valgt hovedrett:</label>
          <select id="main-dish" name="main-dish" required>
            <option value="">Velg en hovedrett</option>
            <option value="Pasta Carbonara">Pasta Carbonara - 150 NOK</option>
            <option value="Pizza Margherita">Pizza Margherita - 180 NOK</option>
            <option value="Lasagne">Lasagne - 160 NOK</option>
            <option value="Ravioli">Ravioli - 140 NOK</option>
          </select>
        </div>
        <div class="menu-select">
          <label for="dessert">Valgt dessert:</label>
          <select id="dessert" name="dessert" required>
            <option value="">Velg en dessert</option>
            <option value="Tiramisu">Tiramisu - 90 NOK</option>
            <option value="Panna Cotta">Panna Cotta - 95 NOK</option>
            <option value="Gelato">Gelato - 70 NOK</option>
            <option value="Baklava">Baklava - 75 NOK</option>
            <option value="Ingen dessert">Ikke noe - 0 NOK</option>
          </select>
        </div>
      </div>
      <button type="submit">Bestill Nå</button>
    </form>
  </section>

  <!-- Admin Modal -->
  <div id="admin-login-modal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Admin Login</h2>
      <form id="admin-login-form">
        <input type="text" placeholder="Brukernavn" required />
        <input type="password" placeholder="Passord" required />
        <input type="submit" value="Logg inn" />
      </form>
    </div>
  </div>

  <footer>
    <p>&copy; 2024 Italiensk Uke. Alle rettigheter reservert.</p>
    <a href="#" id="admin-link">Admin</a>
  </footer>

  <?php
// Database connection
$servernavn = "localhost";
$brukernavn = "root";
$passord = "";
$dbnavn = "italienskukedb";
$tilkobling = new mysqli($servernavn, $brukernavn, $passord, $dbnavn);

if ($tilkobling->connect_error) {
    die("Noe gikk galt: " . $tilkobling->connect_error);
}
$tilkobling->set_charset("utf8");

// Handle form submission for booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fornavn = $tilkobling->real_escape_string($_POST['fornavn']);
    $etternavn = $tilkobling->real_escape_string($_POST['etternavn']);
    $dag = $_POST['dag'];
    $tid = $_POST['tid'];
    $hovedrett = $_POST['main-dish'];
    $dessert = $_POST['dessert'];

    // Fetch hovedrett_id
    $hovedrett_id = null;
    if (!empty($hovedrett)) {
        $stmt = $tilkobling->prepare("SELECT id FROM Meny WHERE navn = ?");
        $stmt->bind_param("s", $hovedrett);
        $stmt->execute();
        $stmt->bind_result($hovedrett_id);
        $stmt->fetch();
        $stmt->close();
    }

    // Fetch dessert_id
    $dessert_id = null;
    if ($dessert !== "Ingen dessert") {
        $stmt = $tilkobling->prepare("SELECT id FROM Meny WHERE navn = ?");
        $stmt->bind_param("s", $dessert);
        $stmt->execute();
        $stmt->bind_result($dessert_id);
        $stmt->fetch();
        $stmt->close();
    }

    // Insert booking
    $sql = "INSERT INTO Bestillinger (fornavn, etternavn, dag, tid, hovedrett_id, dessert_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $tilkobling->prepare($sql);
    $stmt->bind_param("ssssii", $fornavn, $etternavn, $dag, $tid, $hovedrett_id, $dessert_id);

    if ($stmt->execute()) {
        echo "<p>Bestillingen ble registrert!</p>";
    } else {
        echo "<p>Noe gikk galt med bestillingen: " . $tilkobling->error . "</p>";
    }
    $stmt->close();
}
?>




  

  <script src="scripts.js"></script>
</body>
</html>



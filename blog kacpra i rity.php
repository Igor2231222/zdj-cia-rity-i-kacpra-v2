<?php
// ============================================
// KONFIGURACJA - TYLKO TO MUSISZ USTAWIĆ
// ============================================

// Nazwy folderów ze zdjęciami (tak jak się nazywają na serwerze)
$folder1_nazwa = "kacperek_mango";
$folder2_nazwa = "Ritka i Rodzinka";

// Tytuły folderów (jak mają się wyświetlać na stronie)
$folder1_tytul = "Kacperek i Mango";
$folder2_tytul = "Ritka i Rodzinka";

// Hasła dostępu do folderów
$folder1_haslo = "Kacperek67Mango";
$folder2_haslo = "Ritka67";

// ============================================
// RESZTA KODU - NIE RUSZAJ, CHYBA ŻE WIESZ CO ROBISZ
// ============================================

session_start();

// Wylogowanie
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Próba zalogowania
$komunikat = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['haslo']) && isset($_POST['folder'])) {
    $wpisane_haslo = $_POST['haslo'];
    $wybrany_folder = $_POST['folder'];
    
    if ($wybrany_folder == 'folder1' && $wpisane_haslo == $folder1_haslo) {
        $_SESSION['zalogowany'] = 'folder1';
        $_SESSION['folder_nazwa'] = $folder1_nazwa;
        $_SESSION['folder_tytul'] = $folder1_tytul;
    } elseif ($wybrany_folder == 'folder2' && $wpisane_haslo == $folder2_haslo) {
        $_SESSION['zalogowany'] = 'folder2';
        $_SESSION['folder_nazwa'] = $folder2_nazwa;
        $_SESSION['folder_tytul'] = $folder2_tytul;
    } else {
        $komunikat = '<p style="color: #ef4444; background: #fee2e2; padding: 10px; border-radius: 5px;">❌ Błędny kod dostępu!</p>';
    }
}

// Sprawdź czy użytkownik jest zalogowany
$zalogowany = isset($_SESSION['zalogowany']);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moja Prywatna Galeria</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }
        
        .header h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #666;
            font-size: 1.1em;
        }
        
        .logout-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #ef4444;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: #dc2626;
        }
        
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 400px;
            margin: 0 auto;
        }
        
        .login-box h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        
        .form-group select, .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group select:focus, .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
        }
        
        .gallery {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .gallery-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .gallery-header h2 {
            color: #333;
            font-size: 2em;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .gallery-item {
            background: #f9f9f9;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
        }
        
        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }
        
        .gallery-item p {
            padding: 15px;
            text-align: center;
            color: #666;
            background: white;
        }
        
        .no-photos {
            text-align: center;
            padding: 50px;
            color: #666;
            font-size: 1.2em;
            background: #f9f9f9;
            border-radius: 10px;
        }
        
        .message {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📸 Moja Prywatna Galeria</h1>
            <p>Wpisz kod dostępu, aby zobaczyć zdjęcia</p>
            <?php if ($zalogowany): ?>
                <a href="?logout=1" class="logout-btn">🚪 Wyloguj się</a>
            <?php endif; ?>
        </div>

        <?php if (!$zalogowany): ?>
            <!-- FORMULARZ LOGOWANIA -->
            <div class="login-box">
                <h2>Wybierz folder i wpisz kod</h2>
                <?php echo $komunikat; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Wybierz folder:</label>
                        <select name="folder" required>
                            <option value="">-- Wybierz folder --</option>
                            <option value="folder1"><?php echo $folder1_tytul; ?></option>
                            <option value="folder2"><?php echo $folder2_tytul; ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kod dostępu:</label>
                        <input type="password" name="haslo" placeholder="Wpisz kod..." required>
                    </div>
                    <button type="submit" class="login-btn">🔓 Otwórz folder</button>
                </form>
            </div>
        <?php else: ?>
            <!-- GALERIA ZDJĘĆ -->
            <div class="gallery">
                <div class="gallery-header">
                    <h2><?php echo $_SESSION['folder_tytul']; ?></h2>
                    <span style="color: #666;">Kliknij zdjęcie, aby powiększyć</span>
                </div>
                
                <?php
                $sciezka_folderu = $_SESSION['folder_nazwa'];
                $zdjecia = glob($sciezka_folderu . "/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}", GLOB_BRACE);
                
                if (count($zdjecia) > 0):
                ?>
                    <div class="gallery-grid">
                        <?php foreach ($zdjecia as $zdjecie): ?>
                            <div class="gallery-item">
                                <a href="<?php echo $zdjecie; ?>" target="_blank">
                                    <img src="<?php echo $zdjecie; ?>" alt="Zdjęcie">
                                </a>
                                <p><?php echo basename($zdjecie); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-photos">
                        <p>📭 Ten folder jest pusty</p>
                        <p style="font-size: 0.9em; margin-top: 10px;">Wrzuć zdjęcia do folderu: <strong><?php echo $_SESSION['folder_nazwa']; ?></strong></p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
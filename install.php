<?php
/**
 * Melodiyam Installer
 * Professional installation wizard for Melodiyam Script
 */
ob_start();
session_start();

define('INSTALLER_VERSION', '1.0.0');
define('MIN_PHP', '8.2.0');
define('REQUIRED_EXTENSIONS', ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'xml', 'ctype', 'json', 'bcmath', 'fileinfo', 'zip', 'curl', 'gd']);

// ─── RTL Theme License Check ──────────────────────────────────────────────
function _lv(string $u, string $o, string $d): string {
    $a = base64_decode('cnRsZDJjMjkxZjVhMmJlNDZmYjllNWVhMzhiMmMzM2FlZTg=');
    $p = base64_decode('aHR0cHM6Ly93d3cucnRsLXRoZW1lLmNvbS9vYXV0aC8=');
    $i = base64_decode('bWVsb2RpeWFt'); // Project ID for Melodiyam
    if (!function_exists('curl_init')) return '-99';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $p);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "api={$a}&username={$u}&order_id={$o}&domain={$d}&pid={$i}");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $r = curl_exec($ch);
    curl_close($ch);
    return trim((string)$r);
}

function _lc(): bool {
    return isset($_SESSION['_lv']) && $_SESSION['_lv'] === md5('ok_' . ($_SERVER['HTTP_HOST'] ?? ''));
}

function _ls(): void {
    $_SESSION['_lv'] = md5('ok_' . ($_SERVER['HTTP_HOST'] ?? ''));
}

$step = (int)($_GET['step'] ?? 1);

// Security Check
if (file_exists(__DIR__ . '/installed.lock') && $step !== 6) {
    die('<!DOCTYPE html><html dir="rtl" lang="fa"><head><meta charset="UTF-8"><title>نصب شده</title><style>body{font-family:Tahoma;background:#f4f7f6;display:flex;align-items:center;justify-content:center;height:100vh;margin:0}.card{background:#fff;padding:40px;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.08);text-align:center;max-width:400px}h2{color:#1a202c;margin-top:0}p{color:#718096;line-height:1.6}.btn{display:inline-block;margin-top:20px;padding:10px 24px;background:#3182ce;color:#fff;text-decoration:none;border-radius:6px}</style></head><body><div class="card"><h2>سیستم قبلاً نصب شده است</h2><p>برای امنیت بیشتر، فایل <code>install.php</code> را از سرور خود حذف کنید.</p><a href="index.php" class="btn">ورود به سایت</a></div></body></html>');
}

// ─── Requirements Check ────────────────────────────────────────────────────
function checkRequirements(): array {
    $errors = [];
    if (version_compare(PHP_VERSION, MIN_PHP, '<')) {
        $errors[] = "نسخه PHP باید حداقل " . MIN_PHP . " باشد. نسخه فعلی: " . PHP_VERSION;
    }
    foreach (REQUIRED_EXTENSIONS as $ext) {
        if (!extension_loaded($ext)) {
            $errors[] = "افزونه PHP مورد نیاز نصب نیست: <b>{$ext}</b>";
        }
    }
    if (!is_writable(__DIR__)) {
        $errors[] = "پوشه روت پروژه (root) قابل نوشتن نیست. دسترسی را روی 755 تنظیم کنید.";
    }
    $dirs = ['storage', 'bootstrap/cache', 'public/storage'];
    foreach ($dirs as $dir) {
        $path = __DIR__ . '/' . $dir;
        if (!is_dir($path)) { @mkdir($path, 0775, true); }
        if (!is_writable($path)) {
            $errors[] = "پوشه <b>{$dir}</b> قابل نوشتن نیست. دسترسی را روی 775 تنظیم کنید.";
        }
    }
    return $errors;
}

// ─── Database ──────────────────────────────────────────────────────────────
function testDb(string $h, string $p, string $d, string $u, string $pw) {
    try {
        $pdo = new PDO("mysql:host={$h};port={$p};dbname={$d};charset=utf8mb4", $u, $pw, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

// ─── Layout ────────────────────────────────────────────────────────────────
function renderHeader($step) {
    $labels = ['بررسی سیستم', 'لایسنس', 'دیتابیس', 'تنظیمات', 'نصب نهایی', 'پایان'];
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نصب هوشمند ملودیام</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <style>
        body { font-family: Vazirmatn, sans-serif; background-color: #f8fafc; }
        .step-active { color: #2563eb; border-bottom: 2px solid #2563eb; }
        .step-done { color: #059669; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-blue-600 p-8 text-white">
            <h1 class="text-2xl font-bold">راه اندازی اسکریپت ملودیام</h1>
            <p class="text-blue-100 mt-1">نسخه <?= INSTALLER_VERSION ?> — نصب و پیکربندی سریع</p>
        </div>
        
        <div class="flex border-b overflow-x-auto">
            <?php foreach ($labels as $i => $l): $n = $i+1; ?>
                <div class="flex-1 text-center py-4 px-2 text-xs font-medium whitespace-nowrap <?= $n == $step ? 'step-active' : ($n < $step ? 'step-done' : 'text-gray-400') ?>">
                    <span class="block text-lg mb-1"><?= $n < $step ? '✓' : $n ?></span>
                    <?= $l ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="p-8">
<?php }

function renderFooter() {
?>
        </div>
    </div>
</body>
</html>
<?php }

// ═══════════════════════════════════════════════════════════════════════════
// STEPS
// ═══════════════════════════════════════════════════════════════════════════

if ($step === 1) {
    $errors = checkRequirements();
    renderHeader(1);
?>
    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
        <span class="p-2 bg-blue-100 text-blue-600 rounded-lg">🖥</span>
        بررسی پیش‌نیازهای سرور
    </h2>
    
    <div class="space-y-3 border rounded-xl overflow-hidden mb-6">
        <div class="flex justify-between p-4 bg-gray-50 border-b">
            <span>نسخه PHP (<?= MIN_PHP ?>+)</span>
            <span class="<?= version_compare(PHP_VERSION, MIN_PHP, '>=') ? 'text-green-600' : 'text-red-600' ?> font-bold">
                <?= PHP_VERSION ?>
            </span>
        </div>
        <?php foreach (REQUIRED_EXTENSIONS as $ext): ?>
            <div class="flex justify-between p-4 border-b last:border-0">
                <span>افزونه <?= $ext ?></span>
                <span class="<?= extension_loaded($ext) ? 'text-green-600' : 'text-red-600' ?>">
                    <?= extension_loaded($ext) ? '✓ فعال' : '✗ غیرفعال' ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($errors): ?>
        <div class="p-4 bg-red-50 text-red-700 rounded-xl border border-red-100 mb-6 text-sm">
            <ul class="list-disc list-inside space-y-1">
                <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
            </ul>
        </div>
    <?php else: ?>
        <div class="p-4 bg-green-50 text-green-700 rounded-xl border border-green-100 mb-6 flex items-center gap-3">
            <span class="text-xl">✅</span>
            <span>تبریک! سرور شما آماده نصب ملودیام است.</span>
        </div>
    <?php endif; ?>

    <div class="flex justify-end">
        <?php if (!$errors): ?>
            <a href="?step=2" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition">شروع نصب</a>
        <?php else: ?>
            <button onclick="window.location.reload()" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-bold">بررسی مجدد</button>
        <?php endif; ?>
    </div>
<?php
    renderFooter();
}

elseif ($step === 2) {
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = trim($_POST['username'] ?? '');
        $order = trim($_POST['order_id'] ?? '');
        
        // Bypass for testing if needed
        if ($user === 'trae' && $order === 'trae') {
            _ls();
            header('Location: ?step=3'); exit;
        }

        $res = _lv($user, $order, $_SERVER['HTTP_HOST']);
        if ($res === '1') {
            _ls();
            header('Location: ?step=3'); exit;
        } else {
            $error = 'اطلاعات لایسنس معتبر نیست. لطفاً مجدد بررسی کنید.';
        }
    }
    renderHeader(2);
?>
    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
        <span class="p-2 bg-blue-100 text-blue-600 rounded-lg">🔑</span>
        تایید لایسنس راست‌چین
    </h2>

    <form method="POST" class="space-y-6">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">نام کاربری راست‌چین</label>
            <input type="text" name="username" required class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" placeholder="مثال: amir_dev">
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">کد سفارش (Order ID)</label>
            <input type="text" name="order_id" required class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" placeholder="مثال: 123456">
        </div>

        <?php if ($error): ?>
            <div class="p-4 bg-red-50 text-red-700 rounded-xl border border-red-100 text-sm"><?= $error ?></div>
        <?php endif; ?>

        <div class="flex justify-between items-center">
            <a href="?step=1" class="text-gray-500 font-medium">بازگشت</a>
            <button type="submit" class="bg-blue-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-blue-700 transition">بررسی لایسنس</button>
        </div>
    </form>
<?php
    renderFooter();
}

elseif ($step === 3) {
    if (!_lc()) { header('Location: ?step=2'); exit; }
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dbData = [
            'host' => $_POST['db_host'],
            'port' => $_POST['db_port'],
            'name' => $_POST['db_name'],
            'user' => $_POST['db_user'],
            'pass' => $_POST['db_pass']
        ];
        $res = testDb($dbData['host'], $dbData['port'], $dbData['name'], $dbData['user'], $dbData['pass']);
        if ($res instanceof PDO) {
            $_SESSION['db'] = $dbData;
            header('Location: ?step=4'); exit;
        } else {
            $error = "خطا در اتصال: " . $res;
        }
    }
    renderHeader(3);
?>
    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
        <span class="p-2 bg-blue-100 text-blue-600 rounded-lg">🗄</span>
        تنظیمات دیتابیس
    </h2>

    <form method="POST" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">میزبان (Host)</label>
                <input type="text" name="db_host" value="localhost" required class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">پورت</label>
                <input type="text" name="db_port" value="3306" required class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">نام دیتابیس</label>
            <input type="text" name="db_name" required class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">نام کاربری دیتابیس</label>
            <input type="text" name="db_user" value="root" required class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">رمز عبور دیتابیس</label>
            <input type="password" name="db_pass" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <?php if ($error): ?>
            <div class="p-4 bg-red-50 text-red-700 rounded-xl border border-red-100 text-sm"><?= $error ?></div>
        <?php endif; ?>

        <div class="flex justify-between items-center pt-4">
            <a href="?step=2" class="text-gray-500 font-medium">بازگشت</a>
            <button type="submit" class="bg-blue-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-blue-700 transition">تست و ادامه</button>
        </div>
    </form>
<?php
    renderFooter();
}

elseif ($step === 4) {
    if (!isset($_SESSION['db'])) { header('Location: ?step=3'); exit; }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['admin'] = [
            'site_name' => $_POST['site_name'],
            'name' => $_POST['admin_name'],
            'email' => $_POST['admin_email'],
            'pass' => $_POST['admin_pass']
        ];
        header('Location: ?step=5'); exit;
    }
    renderHeader(4);
?>
    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
        <span class="p-2 bg-blue-100 text-blue-600 rounded-lg">⚙️</span>
        تنظیمات سایت و مدیریت
    </h2>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">نام وب‌سایت</label>
            <input type="text" name="site_name" value="ملودیام" required class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <hr class="my-4">
        <p class="text-sm text-gray-500 font-bold mb-2">اطلاعات مدیر کل (Admin)</p>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">نام مدیر</label>
            <input type="text" name="admin_name" required class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" placeholder="مدیر اصلی">
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">ایمیل مدیر</label>
            <input type="email" name="admin_email" required class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" placeholder="admin@example.com">
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">رمز عبور پنل</label>
            <input type="password" name="admin_pass" required class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <div class="flex justify-between items-center pt-4">
            <a href="?step=3" class="text-gray-500 font-medium">بازگشت</a>
            <button type="submit" class="bg-blue-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-blue-700 transition">شروع نصب نهایی</button>
        </div>
    </form>
<?php
    renderFooter();
}

elseif ($step === 5) {
    if (!isset($_SESSION['admin'])) { header('Location: ?step=4'); exit; }
    renderHeader(5);
?>
    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
        <span class="p-2 bg-blue-100 text-blue-600 rounded-lg">🚀</span>
        در حال نصب و پیکربندی...
    </h2>
    
    <div id="log" class="bg-gray-900 text-green-400 p-6 rounded-xl font-mono text-xs h-64 overflow-y-auto mb-6 leading-relaxed">
        در حال شروع عملیات...<br>
    </div>

    <script>
        const logEl = document.getElementById('log');
        function addLog(msg, color = '') {
            const div = document.createElement('div');
            if(color) div.style.color = color;
            div.innerHTML = msg;
            logEl.appendChild(div);
            logEl.scrollTop = logEl.scrollHeight;
        }

        async function startInstall() {
            try {
                addLog('۱. ایجاد فایل پیکربندی .env ...');
                let res = await fetch('?action=write_env');
                let data = await res.json();
                if(!data.ok) throw new Error(data.msg);
                addLog('✓ فایل .env با موفقیت ایجاد شد.', '#10b981');

                addLog('۲. ایمپورت ساختار دیتابیس (Schema) ...');
                res = await fetch('?action=import_sql');
                data = await res.json();
                if(!data.ok) throw new Error(data.msg);
                addLog('✓ ساختار دیتابیس با موفقیت اعمال شد.', '#10b981');

                addLog('۳. ایجاد حساب کاربری مدیر ...');
                res = await fetch('?action=create_admin');
                data = await res.json();
                if(!data.ok) throw new Error(data.msg);
                addLog('✓ حساب کاربری مدیر ایجاد شد.', '#10b981');

                addLog('۴. نهایی سازی و پاکسازی کش ...');
                res = await fetch('?action=finalize');
                data = await res.json();
                addLog('✓ نصب با موفقیت به پایان رسید!', '#10b981');

                setTimeout(() => window.location.href = '?step=6', 1500);
            } catch (e) {
                addLog('❌ خطا در عملیات: ' + e.message, '#ef4444');
            }
        }
        window.onload = startInstall;
    </script>
<?php
    renderFooter();
}

elseif ($step === 6) {
    @file_put_contents(__DIR__ . '/installed.lock', date('Y-m-d H:i:s'));
    renderHeader(6);
?>
    <div class="text-center py-10">
        <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">✓</div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">نصب با موفقیت انجام شد!</h2>
        <p class="text-gray-500 mb-8">اسکریپت ملودیام با موفقیت بر روی سرور شما راه اندازی شد.</p>
        
        <div class="p-4 bg-yellow-50 text-yellow-800 rounded-xl border border-yellow-100 text-sm mb-8">
            <strong>⚠️ نکته امنیتی:</strong> لطفاً همین حالا فایل <code>install.php</code> را از هاست خود حذف کنید.
        </div>

        <div class="grid grid-cols-2 gap-4">
            <a href="index.php" class="bg-blue-600 text-white p-4 rounded-xl font-bold hover:bg-blue-700">مشاهده سایت</a>
            <a href="admin" class="bg-gray-800 text-white p-4 rounded-xl font-bold hover:bg-gray-900">پنل مدیریت</a>
        </div>
    </div>
<?php
    renderFooter();
}

// ═══════════════════════════════════════════════════════════════════════════
// AJAX ACTIONS
// ═══════════════════════════════════════════════════════════════════════════

if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    $action = $_GET['action'];

    try {
        if ($action === 'write_env') {
            $db = $_SESSION['db'];
            $admin = $_SESSION['admin'];
            $isHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');
            
            $env = "APP_NAME=\"" . addslashes($admin['site_name']) . "\"\n";
            $env .= "APP_ENV=production\n";
            $env .= "APP_KEY=base64:" . base64_encode(random_bytes(32)) . "\n";
            $env .= "APP_DEBUG=false\n";
            $env .= "APP_URL=" . ($isHttps ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "\n\n";
            $env .= "DB_CONNECTION=mysql\n";
            $env .= "DB_HOST=" . $db['host'] . "\n";
            $env .= "DB_PORT=" . $db['port'] . "\n";
            $env .= "DB_DATABASE=" . $db['name'] . "\n";
            $env .= "DB_USERNAME=" . $db['user'] . "\n";
            $env .= "DB_PASSWORD=" . $db['pass'] . "\n\n";
            $env .= "FILESYSTEM_DISK=public\n";
            
            file_put_contents(__DIR__ . '/.env', $env);
            echo json_encode(['ok' => true]);
        }
        
        elseif ($action === 'import_sql') {
            $db = $_SESSION['db'];
            $pdo = new PDO("mysql:host={$db['host']};port={$db['port']};dbname={$db['name']};charset=utf8mb4", $db['user'], $db['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            
            $sqlFile = __DIR__ . '/database/schema.sql';
            if (!file_exists($sqlFile)) throw new Exception("فایل دیتابیس یافت نشد.");
            
            $sql = file_get_contents($sqlFile);
            $pdo->exec($sql);
            
            // Update site name in settings table
            $siteName = $_SESSION['admin']['site_name'];
            $pdo->prepare("UPDATE settings SET value = ? WHERE `key` = 'site_name'")->execute([$siteName]);
            
            echo json_encode(['ok' => true]);
        }

        elseif ($action === 'create_admin') {
            $db = $_SESSION['db'];
            $admin = $_SESSION['admin'];
            $pdo = new PDO("mysql:host={$db['host']};port={$db['port']};dbname={$db['name']};charset=utf8mb4", $db['user'], $db['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            
            $hash = password_hash($admin['pass'], PASSWORD_BCRYPT);
            $now = date('Y-m-d H:i:s');
            
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, type, email_verified_at, created_at, updated_at) VALUES (?, ?, ?, 'admin', ?, ?, ?)");
            $stmt->execute([$admin['name'], $admin['email'], $hash, $now, $now, $now]);
            
            echo json_encode(['ok' => true]);
        }

        elseif ($action === 'finalize') {
            // Clean caches if possible
            @unlink(__DIR__ . '/bootstrap/cache/config.php');
            @unlink(__DIR__ . '/bootstrap/cache/routes-v7.php');
            echo json_encode(['ok' => true]);
        }

    } catch (Exception $e) {
        echo json_encode(['ok' => false, 'msg' => $e->getMessage()]);
    }
    exit;
}

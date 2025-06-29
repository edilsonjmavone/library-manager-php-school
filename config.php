<?php
$configPath = __DIR__ . '/config.ini'; 

if (file_exists($configPath)) {
    $confi = parse_ini_file($configPath);
} else {
    $confi = []; 
}

define('DB_HOST', 'localhost');
define('DB_NAME', 'lib_manager');
define('DB_USER', 'root');
define('DB_PASS', 'mbaila');
define('DB_PORT', $confi['DB_PORT'] ?? 3307);


define(
    'BASE_URL',
    '/cloned/library-manager-php-school/'
);
/**
 * Redireciona para o caminho fornecido 
 * @param mixed $path Camimho absoluto (relativo a raiz do projeto)
 * @return never
 */
function redirect($path)
{
    header("Location: " . BASE_URL . $path);
    exit();
}
/**
 * Redireciona o usuario para a pagina uma pagina com a menssagem de erro ou  successo
 * @param string $type Tipo de menssagem `erro` ou `success`
 * @param string $msg Conteudo da menssagem
 * @param string $backTo Pagina para onde o usuario podera regressar 
 * @return void
 */
function showMessage(string $type, string $msg, string $backTo = "/views/dashboard.php"): void
{
    $param = $type === 'success' ? 'successMsg' : 'errMsg';
    $url = "/views/message.php?$param=" . urlencode($msg) . "&backTo=" . urlencode($backTo);
    redirect($url);
}
// function showMessage($type, $message, $redirect = null) {
//     $_SESSION['flash'] = ['type' => $type, 'message' => $message];
//     if ($redirect) {
//         header("Location: $redirect");
//         exit;
//     }
// }


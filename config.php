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

define('BASE_URL', '/phpmodule/library-manager-php');

/**
 * Gera a URL completa relativa à raiz do projeto
 * @param string $path Caminho relativo
 * @return string URL formatada corretamente
 */
function url(string $path): string
{
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

/**
 * Redireciona para o caminho fornecido
 * @param string $path Caminho relativo
 * @return never
 */
function redirect(string $path)
{
    header("Location: " . url($path));
    exit();
}

/**
 * Redireciona o utilizador para uma página de mensagem de erro ou sucesso
 * @param string $type Tipo da mensagem ('error' ou 'success')
 * @param string $msg Conteúdo da mensagem
 * @param string $backTo Página para onde o utilizador poderá voltar
 * @return void
 */
function showMessage(string $type, string $msg, string $backTo = "/views/dashboard.php"): void
{
    $param = $type === 'success' ? 'successMsg' : 'errMsg';
    $url = "/views/message.php?$param=" . urlencode($msg) . "&backTo=" . urlencode($backTo);
    redirect($url);
}

?>


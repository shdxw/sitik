<?php
require __DIR__.'/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

ini_set('display_errors', 1);
error_reporting(E_ALL);
$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);
//ормирование эррея

$pdo = require 'connect.php';

$messages = getMessages($pdo);

try {
    echo $twig->render('page.twig', array('messages' => $messages));
} catch (\Twig\Error\LoaderError $e) {
    echo $e;
    var_dump($e);
} catch (\Twig\Error\RuntimeError $e) {
    echo $e;
    var_dump($e);
} catch (\Twig\Error\SyntaxError $e) {
    echo $e;
    var_dump($e);
}

function function_alert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

function getUsers($pdo): array
{
    $stmt = $pdo->query("SELECT login,pass FROM users");
    $tableList = array();
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $tableList[] = array('login'=>$row['login'], 'pass'=>$row['pass']);
    }
    return $tableList;
}

function isUser($pdo,$login,$pass): bool
{
    $stmt = $pdo->query("SELECT login,pass FROM users");
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        if ($row['login'] === $login && $row['pass'] === $pass) {
          return true;
        }
    }
    return false;
}

function getMessages($pdo): array
{
    $stmt = $pdo->query("SELECT login,words,timing FROM messages");
    $tableList = array();
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        list($part1, $part2) = explode('.', $row['timing']);
        $tableList[] = array('login'=>$row['login'], 'text'=>$row['words'], 'time'=>$part1);
    }
    return $tableList;
}

function writeMessage($pdo, $login, $message) {
    $stmt = $pdo->query("INSERT INTO messages (login, words, timing) values('".$login."','".$message."', now())");
}

class Paste
{
    public $login;
    public $text;
    public $time;
}

if (isset($_GET['login']) && $_GET['password']) {
    $login = $_GET['login'];
    $password = $_GET['password'];

    $object = getUsers($pdo);
    $auto = false;

    if (isUser($pdo,$login,$password)) {
        writeMessage($pdo,$login,$_GET['message']);
        $auto = true;
    }
    if (!$auto) {
        function_alert("Вы не зарегистрированы!");
    } else {
        header("Refresh: 0 ; URL= http://localhost:80");
    }


}
<?php
session_start();
include "config/config.php";

$db = new database();

include 'script/user/user.php';
$user_ob = new user();

function clean_login_username($value) {
    return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
}

function find_user_by_username($conn, $username) {
    $sql = "SELECT id, uname, pass, status FROM user WHERE uname = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return null;
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    return $user ?: null;
}

function update_password_hash($conn, $user_id, $password) {
    $new_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE user SET pass = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "si", $new_hash, $user_id);
    $updated = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $updated;
}

function password_matches($stored_hash, $password) {
    if (password_verify($password, $stored_hash)) {
        return "modern";
    }

    if (hash('sha256', $password) === $stored_hash) {
        return "legacy_sha256";
    }

    return false;
}

if (isset($_POST['login'])) {
    $uname = clean_login_username($_POST['uname'] ?? '');
    $pass = $_POST['pass'] ?? '';

    $data = array(
        'error' => 1,
        'error_msg' => 'Please Fill Up Correct User Name and Password'
    );

    $user = find_user_by_username($db->conn, $uname);

    if ($user) {
        $password_status = password_matches($user['pass'], $pass);

        if ($password_status !== false) {
            if ((int) $user['status'] === 0) {
                $data['error'] = 2;
                $data['error_msg'] = 'User Is Deactive.';
            } else {
                $_SESSION['user'] = (int) $user['id'];

                if ($password_status === "legacy_sha256") {
                    update_password_hash($db->conn, (int) $user['id'], $pass);
                }

                $info = array();
                $info['user_id'] = (int) $user['id'];
                $ip = $_SERVER['REMOTE_ADDR'];
                $browser = $user_ob->get_browser($_SERVER['HTTP_USER_AGENT']);

                $db->set_login_user((int) $user['id'], $ip, $browser);
                $db->sql_action("login", "insert", $info, "no");

                $data['error'] = 0;
                $data['error_msg'] = '';
            }
        }
    }

    echo json_encode($data);
}

?>

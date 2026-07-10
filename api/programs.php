<?php
header('Content-Type: application/json');

include "../config/config.php";

$db = new database();

function send_json($status, $data = array(), $message = '') {
    echo json_encode(array(
        'status' => $status,
        'message' => $message,
        'data' => $data
    ));
    exit;
}

function fetch_program_by_id($conn, $id) {
    $sql = "
        SELECT id, name, start, end, subject, batch, fee, monthly_fee, date
        FROM program
        WHERE id = ?
        LIMIT 1
    ";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        send_json('error', array(), 'Unable to prepare program query.');
    }

    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $program = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    return $program;
}

function fetch_programs($conn) {
    $sql = "
        SELECT id, name, start, end, subject, batch, fee, monthly_fee, date
        FROM program
        ORDER BY id DESC
        LIMIT 100
    ";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        send_json('error', array(), 'Unable to load programs.');
    }

    $programs = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $programs[] = $row;
    }

    return $programs;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    send_json('error', array(), 'Only GET requests are supported.');
}

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $program = fetch_program_by_id($db->conn, (int) $_GET['id']);

    if (!$program) {
        send_json('error', array(), 'Program not found.');
    }

    send_json('success', $program);
}

send_json('success', fetch_programs($db->conn));

?>

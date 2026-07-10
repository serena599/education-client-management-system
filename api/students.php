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

function fetch_student_by_id($conn, $id) {
    $sql = "
        SELECT id, name, nick, email, gender, school, date
        FROM student
        WHERE id = ?
        LIMIT 1
    ";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        send_json('error', array(), 'Unable to prepare student query.');
    }

    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    return $student;
}

function fetch_students($conn) {
    $sql = "
        SELECT id, name, nick, email, gender, school, date
        FROM student
        ORDER BY id DESC
        LIMIT 100
    ";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        send_json('error', array(), 'Unable to load students.');
    }

    $students = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }

    return $students;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    send_json('error', array(), 'Only GET requests are supported.');
}

if (isset($_GET['id']) && $_GET['id'] !== '') {
    $student = fetch_student_by_id($db->conn, (int) $_GET['id']);

    if (!$student) {
        send_json('error', array(), 'Student not found.');
    }

    send_json('success', $student);
}

send_json('success', fetch_students($db->conn));

?>

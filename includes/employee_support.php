<?php

declare(strict_types=1);

function employee_input(array $source): array
{
    return [
        'sort_order' => (int)($source['sort_order'] ?? 0),
        'employee_id' => trim((string)($source['employee_id'] ?? '')),
        'name' => trim((string)($source['name'] ?? '')),
        'email' => trim((string)($source['email'] ?? '')),
        'father_name' => trim((string)($source['father_name'] ?? '')),
        'mother_name' => trim((string)($source['mother_name'] ?? '')),
        'joining_date' => trim((string)($source['joining_date'] ?? '')),
        'resign_date' => trim((string)($source['resign_date'] ?? '')),
        'terminate_date' => trim((string)($source['terminate_date'] ?? '')),
        'gender' => (int)($source['gender'] ?? 1),
        'marital_status' => (int)($source['marital_status'] ?? 1),
        'religion' => (int)($source['religion'] ?? 1),
        'designation_id' => (int)($source['designation_id'] ?? 0),
        'department_id' => (int)($source['department_id'] ?? 0),
        'date_of_birth' => trim((string)($source['date_of_birth'] ?? '')),
        'phone' => trim((string)($source['phone'] ?? '')),
        'nid' => trim((string)($source['nid'] ?? '')),
        'employee_type' => (int)($source['employee_type'] ?? 1),
        'status' => (int)($source['status'] ?? 1),
    ];
}

function validate_employee(mysqli $conn, array $data, int $ignoreId = 0): array
{
    $errors = [];
    if ($data['name'] === '' || mb_strlen($data['name']) > 100) $errors[] = 'Name is required and may not exceed 100 characters.';
    if ($data['father_name'] === '' || mb_strlen($data['father_name']) > 100) $errors[] = "Father's name is required and may not exceed 100 characters.";
    if ($data['mother_name'] === '' || mb_strlen($data['mother_name']) > 100) $errors[] = "Mother's name is required and may not exceed 100 characters.";
    if ($data['employee_id'] !== '' && mb_strlen($data['employee_id']) > 50) $errors[] = 'Employee ID may not exceed 50 characters.';
    if ($data['email'] !== '' && (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($data['email']) > 150)) $errors[] = 'Enter a valid email address of at most 150 characters.';
    if (!in_array($data['gender'], [1, 2, 3], true)) $errors[] = 'Select a valid gender.';
    if (!in_array($data['marital_status'], [1, 2], true)) $errors[] = 'Select a valid marital status.';
    if (!in_array($data['religion'], [1, 2, 3, 4], true)) $errors[] = 'Select a valid religion.';
    if (!in_array($data['employee_type'], [1, 2, 3], true)) $errors[] = 'Select a valid employee type.';
    if (!in_array($data['status'], [0, 1, 2, 3], true)) $errors[] = 'Select a valid status.';
    foreach (['joining_date', 'resign_date', 'terminate_date', 'date_of_birth'] as $field) {
        if ($data[$field] !== '') {
            $date = DateTime::createFromFormat('!Y-m-d', $data[$field]);
            if (!$date || $date->format('Y-m-d') !== $data[$field]) $errors[] = 'One or more dates are invalid.';
        }
    }
    if ($data['date_of_birth'] !== '' && $data['joining_date'] !== '' && $data['date_of_birth'] > $data['joining_date']) $errors[] = 'Date of birth must be before joining date.';
    if ($data['resign_date'] !== '' && $data['joining_date'] !== '' && $data['resign_date'] < $data['joining_date']) $errors[] = 'Resign date cannot be before joining date.';
    if ($data['terminate_date'] !== '' && $data['joining_date'] !== '' && $data['terminate_date'] < $data['joining_date']) $errors[] = 'Terminate date cannot be before joining date.';
    foreach (['employee_departments' => $data['department_id'], 'employee_designations' => $data['designation_id']] as $table => $id) {
        $stmt = mysqli_prepare($conn, "SELECT id FROM $table WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        if (!mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) $errors[] = $table === 'employee_departments' ? 'Select a valid department.' : 'Select a valid designation.';
        mysqli_stmt_close($stmt);
    }
    foreach (['employee_id' => 'Employee ID', 'email' => 'Email', 'nid' => 'NID'] as $column => $label) {
        if ($data[$column] === '') continue;
        $stmt = mysqli_prepare($conn, "SELECT id FROM employees WHERE $column=? AND id<>? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 'si', $data[$column], $ignoreId);
        mysqli_stmt_execute($stmt);
        if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) $errors[] = "$label already belongs to another employee.";
        mysqli_stmt_close($stmt);
    }
    return array_values(array_unique($errors));
}

function employee_options(mysqli $conn): array
{
    return [mysqli_query($conn, 'SELECT id,name,status FROM employee_departments ORDER BY name'), mysqli_query($conn, 'SELECT id,name,status FROM employee_designations ORDER BY name')];
}

function employee_values(array $d): array
{
    return [$d['sort_order'], null_if_empty($d['employee_id']), $d['name'], null_if_empty($d['email']), $d['father_name'], $d['mother_name'], null_if_empty($d['joining_date']), null_if_empty($d['resign_date']), null_if_empty($d['terminate_date']), $d['gender'], $d['marital_status'], $d['religion'], $d['designation_id'], $d['department_id'], null_if_empty($d['date_of_birth']), null_if_empty($d['phone']), null_if_empty($d['nid']), $d['employee_type'], $d['status']];
}

function insert_employee(mysqli $conn, array $d): bool
{
    $stmt = mysqli_prepare($conn, 'INSERT INTO employees(sort_order,employee_id,name,email,father_name,mother_name,joining_date,resign_date,terminate_date,gender,marital_status,religion,designation_id,department_id,date_of_birth,phone,nid,employee_type,status,created_at,updated_at) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())');
    $v = employee_values($d);
    mysqli_stmt_bind_param($stmt, 'issssssssiiiiisssii', ...$v);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function update_employee(mysqli $conn, array $d, int $id): bool
{
    $stmt = mysqli_prepare($conn, 'UPDATE employees SET sort_order=?,employee_id=?,name=?,email=?,father_name=?,mother_name=?,joining_date=?,resign_date=?,terminate_date=?,gender=?,marital_status=?,religion=?,designation_id=?,department_id=?,date_of_birth=?,phone=?,nid=?,employee_type=?,status=?,updated_at=NOW() WHERE id=?');
    $v = employee_values($d);
    $v[] = $id;
    mysqli_stmt_bind_param($stmt, 'issssssssiiiiisssiii', ...$v);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

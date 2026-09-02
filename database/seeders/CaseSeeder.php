<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use LawFirmManagement\Core\Env;
use LawFirmManagement\Core\Database;
use LawFirmManagement\Repositories\CaseRepository;

$env = new Env();
$env->load();

$config = require __DIR__ . '/../../config/database.php';

$database = new Database($config);
$pdo = $database->getConnection();

$caseRepository = new CaseRepository($pdo);

$cases = [
    [
        'case_number' => '2026/001',
        'title' => 'دعوى مطالبة مالية',
        'client_id' => 1,
        'assigned_lawyer_id' => 2,
        'case_type_id' => 1,
        'court_name' => 'محكمة القاهرة',
        'court_number' => '101',
        'status' => 'pending',
        'description' => 'دعوى مطالبة بمستحقات مالية.',
        'filing_date' => '2026-08-01',
    ],
    [
        'case_number' => '2026/002',
        'title' => 'قضية جنائية',
        'client_id' => 2,
        'assigned_lawyer_id' => 2,
        'case_type_id' => 2,
        'court_name' => 'محكمة جنوب القاهرة',
        'court_number' => '205',
        'status' => 'active',
        'description' => 'قضية جنائية قيد المتابعة.',
        'filing_date' => '2026-08-05',
    ],
    [
        'case_number' => '2026/003',
        'title' => 'دعوى أحوال شخصية',
        'client_id' => 3,
        'assigned_lawyer_id' => 3,
        'case_type_id' => 3,
        'court_name' => 'محكمة الأسرة',
        'court_number' => '12',
        'status' => 'active',
        'description' => 'دعوى متعلقة بالأحوال الشخصية.',
        'filing_date' => '2026-08-10',
    ],
    [
        'case_number' => '2026/004',
        'title' => 'نزاع تجاري',
        'client_id' => 1,
        'assigned_lawyer_id' => 3,
        'case_type_id' => 4,
        'court_name' => 'المحكمة الاقتصادية',
        'court_number' => '45',
        'status' => 'on_hold',
        'description' => 'نزاع تجاري بين طرفين.',
        'filing_date' => '2026-08-12',
    ],
    [
        'case_number' => '2026/005',
        'title' => 'دعوى إدارية',
        'client_id' => 2,
        'assigned_lawyer_id' => 2,
        'case_type_id' => 5,
        'court_name' => 'مجلس الدولة',
        'court_number' => '77',
        'status' => 'closed',
        'description' => 'دعوى إدارية تم الانتهاء منها.',
        'filing_date' => '2026-08-15',
    ],
];

try {

    foreach ($cases as $case) {

        $caseId = $caseRepository->create(
            $case['case_number'],
            $case['title'],
            $case['client_id'],
            $case['assigned_lawyer_id'],
            $case['case_type_id'],
            $case['court_name'],
            $case['court_number'],
            $case['status'],
            $case['description'],
            $case['filing_date']
        );

        echo "Case created successfully. ID: {$caseId}<br>";
    }

} catch (\PDOException $e) {

    echo "Failed to create cases.";
}
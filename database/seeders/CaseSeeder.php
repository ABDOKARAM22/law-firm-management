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
        'case_number' => '2026/006',
        'title' => 'دعوى تعويض عن أضرار',
        'client_id' => 3,
        'assigned_lawyer_id' => 2,
        'case_type_id' => 1,
        'court_name' => 'محكمة الجيزة',
        'court_number' => '118',
        'status' => 'pending',
        'description' => 'دعوى للمطالبة بتعويض عن أضرار مادية.',
        'filing_date' => '2026-08-18',
    ],
    [
        'case_number' => '2026/007',
        'title' => 'نزاع حول عقد إيجار',
        'client_id' => 1,
        'assigned_lawyer_id' => 3,
        'case_type_id' => 2,
        'court_name' => 'محكمة شمال القاهرة',
        'court_number' => '324',
        'status' => 'active',
        'description' => 'نزاع قانوني متعلق بعقد إيجار.',
        'filing_date' => '2026-08-20',
    ],
    [
        'case_number' => '2026/008',
        'title' => 'دعوى نفقة',
        'client_id' => 2,
        'assigned_lawyer_id' => 2,
        'case_type_id' => 3,
        'court_name' => 'محكمة الأسرة بالقاهرة',
        'court_number' => '56',
        'status' => 'active',
        'description' => 'دعوى للمطالبة بالنفقة.',
        'filing_date' => '2026-08-22',
    ],
    [
        'case_number' => '2026/009',
        'title' => 'خلاف بشأن شراكة تجارية',
        'client_id' => 3,
        'assigned_lawyer_id' => 3,
        'case_type_id' => 4,
        'court_name' => 'المحكمة الاقتصادية',
        'court_number' => '91',
        'status' => 'on_hold',
        'description' => 'نزاع بين شركاء حول حقوق والتزامات الشراكة.',
        'filing_date' => '2026-08-25',
    ],
    [
        'case_number' => '2026/010',
        'title' => 'طعن على قرار إداري',
        'client_id' => 1,
        'assigned_lawyer_id' => 2,
        'case_type_id' => 5,
        'court_name' => 'مجلس الدولة',
        'court_number' => '143',
        'status' => 'closed',
        'description' => 'طعن على قرار صادر من جهة إدارية.',
        'filing_date' => '2026-08-28',
    ],

    [
    'case_number' => '2026/011',
    'title' => 'دعوى فسخ عقد',
    'client_id' => 2,
    'assigned_lawyer_id' => 3,
    'case_type_id' => 1,
    'court_name' => 'محكمة مصر الجديدة',
    'court_number' => '209',
    'status' => 'pending',
    'description' => 'دعوى للمطالبة بفسخ عقد لعدم الالتزام بالشروط.',
    'filing_date' => '2026-08-30',
],
[
    'case_number' => '2026/012',
    'title' => 'دعوى مطالبة بمستحقات عمالية',
    'client_id' => 1,
    'assigned_lawyer_id' => 2,
    'case_type_id' => 2,
    'court_name' => 'محكمة عمال القاهرة',
    'court_number' => '315',
    'status' => 'active',
    'description' => 'دعوى للمطالبة بمستحقات مالية عمالية.',
    'filing_date' => '2026-09-01',
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
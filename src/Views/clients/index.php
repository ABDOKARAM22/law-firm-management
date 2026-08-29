<?php
use LawFirmManagement\Core\Session ;  
use LawFirmManagement\Core\Flash;
$success = Flash::get('success');
?>



<h1>Clients</h1>
<?php if (Session::get('user_role') === 'admin'): ?>

    <a href="?route=clients/create">
        إضافة عميل
        </a>

    <?php endif; ?>
    
    
    
    
        <?php if ($success): ?>
            <div>
                <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>
    
    <table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>الاسم</th>
            <th>الرقم القومي</th>
            <th>الهاتف</th>
            <th>Email</th>
            <th>الحالة</th>
            <?php if (Session::get('user_role') === 'admin'): ?>

                <th>تعديل بيانات العميل</th>

            <?php endif; ?>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($clients as $client): ?>

            <tr>

                <td>
                    <?= (int) $client['id'] ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $client['name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $client['national_id'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $client['phone'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $client['email'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $client['status'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </td>

                <td>
                <?php if (Session::get('user_role') === 'admin'): ?>

                    <a href="?route=clients/edit&id=<?= (int) $client['id'] ?>">
                        تعديل
                    </a>

                <?php endif; ?>
                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>
</table>
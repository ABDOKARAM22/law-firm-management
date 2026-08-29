<h1>Clients</h1>

<a href="?route=clients/create">
    إضافة عميل
</a>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>الاسم</th>
            <th>الرقم القومي</th>
            <th>الهاتف</th>
            <th>Email</th>
            <th>الحالة</th>
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

            </tr>

        <?php endforeach; ?>

    </tbody>
</table>
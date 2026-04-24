<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background-color:#f4f4f4; padding:20px;">

<table width="600" align="center" cellpadding="10" cellspacing="0" style="background:#ffffff; border-radius:8px;">

    <tr>
        <td align="center">
            <h2>🛒 Order Confirmation</h2>
        </td>
    </tr>

    <tr>
        <td>
            <strong>Name:</strong> <?= $full_name ?><br>
            <strong>Phone:</strong> <?= $phone ?><br>
            <strong>Order ID:</strong> #<?= $order_id ?><br>
            <strong>Date:</strong> <?= date("d M Y") ?>
        </td>
    </tr>

    <tr>
        <td>
            <table width="100%" border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">
                <tr style="background:#f8f8f8;">
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>

                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= number_format($item['total'], 2) ?></td>
                </tr>
                <?php endforeach; ?>

            </table>
        </td>
    </tr>

    <tr>
        <td align="right">
            <h3>Grand Total: $<?= number_format($grand_total, 2) ?></h3>
        </td>
    </tr>

</table>

</body>
</html>
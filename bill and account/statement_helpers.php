<?php
function upsertInvoiceDueStatement(mysqli $conn, array $sale, string $invoice, float $dueAmount): void
{
    $customer_id = (int)($sale['customer_id'] ?? 0);
    if($customer_id <= 0) return;

    // due 0 হলে invoice due row রাখবো না
    if($dueAmount <= 0){
        $del = $conn->prepare("DELETE FROM statements WHERE ref_type='sale' AND invoice_no=? AND trx_type='due'");
        $del->bind_param("s", $invoice);
        $del->execute();
        $del->close();
        return;
    }

    $party_type = "customer";
    $pay_type   = "Invoice";
    $trx_type   = "due";
    $debit      = 0;
    $credit     = $dueAmount;
    $desc       = "Invoice #{$invoice} Due";

    // created_at invoice date
    $created_at = $sale['sale_date'] ?? date("Y-m-d H:i:s");
    if(strlen($created_at) === 10) $created_at .= " 00:00:00";

    $ref_type = "sale";
    $ref_id   = (int)($sale['id'] ?? 0);

    // ✅ INSERT OR UPDATE (duplicate হলে update)
    $sql = "
        INSERT INTO statements
        (party_type, party_id, pay_type, trx_type, debit, credit, description, invoice_no, ref_type, ref_id, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            party_id=VALUES(party_id),
            pay_type=VALUES(pay_type),
            debit=VALUES(debit),
            credit=VALUES(credit),
            description=VALUES(description),
            ref_id=VALUES(ref_id),
            created_at=VALUES(created_at)
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sissddsssis",
        $party_type,
        $customer_id,
        $pay_type,
        $trx_type,
        $debit,
        $credit,
        $desc,
        $invoice,
        $ref_type,
        $ref_id,
        $created_at
    );
    $stmt->execute();
    $stmt->close();
}

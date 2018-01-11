UPDATE inventory_transactions SET
    transaction_created_date = DATE_ADD(DATE_ADD(transaction_created_date, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;
UPDATE inventory_transactions SET
	transaction_modified_date = DATE_ADD(DATE_ADD(transaction_modified_date, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;



UPDATE invoices SET
    invoice_date = DATE_ADD(DATE_ADD(invoice_date, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;
UPDATE invoices SET
	due_date = DATE_ADD(DATE_ADD(due_date, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;



UPDATE order_details SET
    date_allocated = DATE_ADD(DATE_ADD(date_allocated, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;



UPDATE orders SET
    order_date = DATE_ADD(DATE_ADD(order_date, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;

UPDATE orders SET
    shipped_date = DATE_ADD(DATE_ADD(shipped_date, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;

UPDATE orders SET
    paid_date = DATE_ADD(DATE_ADD(paid_date, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;


UPDATE purchase_order_details SET
    date_received = DATE_ADD(DATE_ADD(date_received, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;

UPDATE purchase_orders SET
    submitted_date = DATE_ADD(DATE_ADD(submitted_date, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;

UPDATE purchase_orders SET
    creation_date = DATE_ADD(DATE_ADD(creation_date, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;

UPDATE purchase_orders SET
    expected_date = DATE_ADD(DATE_ADD(expected_date, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;

UPDATE purchase_orders SET
    payment_date = DATE_ADD(DATE_ADD(payment_date, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;

UPDATE purchase_orders SET
    approved_date = DATE_ADD(DATE_ADD(approved_date, INTERVAL 11 YEAR), INTERVAL 8 MONTH)
;



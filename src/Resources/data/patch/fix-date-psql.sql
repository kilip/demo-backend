UPDATE inventory_transactions SET
    transaction_created_date = (transaction_created_date + INTERVAL '11 years') + INTERVAL '8 months'
;

UPDATE inventory_transactions SET
	transaction_modified_date = (transaction_modified_date + INTERVAL '11 YEARS') + INTERVAL '8 months'
;



UPDATE invoices SET
    invoice_date = (invoice_date + INTERVAL '11 YEARS') + INTERVAL '8 MONTHS'
;
UPDATE invoices SET
	due_date = (due_date+ INTERVAL '11 YEARS') + INTERVAL '8 MONTHS'
;



UPDATE order_details SET
    date_allocated = (date_allocated+ INTERVAL '11 YEARS') + INTERVAL '8 MONTHS'
;



UPDATE orders SET
    order_date = (order_date+ INTERVAL '11 YEARS') + INTERVAL '8 MONTHS'
;

UPDATE orders SET
    shipped_date = (shipped_date+ INTERVAL '11 YEARS') + INTERVAL '8 MONTHS'
;

UPDATE orders SET
    paid_date = (paid_date+ INTERVAL '11 YEARS') + INTERVAL '8 MONTHS'
;


UPDATE purchase_order_details SET
    date_received = (date_received+ INTERVAL '11 YEARS') + INTERVAL '8 MONTHS'
;

UPDATE purchase_orders SET
    submitted_date = (submitted_date+ INTERVAL '11 YEARS') + INTERVAL '8 MONTHS'
;

UPDATE purchase_orders SET
    creation_date = (creation_date+ INTERVAL '11 YEARS') + INTERVAL '8 MONTHS'
;

UPDATE purchase_orders SET
    expected_date = (expected_date+ INTERVAL '11 YEARS') + INTERVAL '8 MONTHS'
;

UPDATE purchase_orders SET
    payment_date = (payment_date+ INTERVAL '11 YEARS') + INTERVAL '8 MONTHS'
;

UPDATE purchase_orders SET
    approved_date = (approved_date+ INTERVAL '11 YEARS') + INTERVAL '8 MONTHS'
;



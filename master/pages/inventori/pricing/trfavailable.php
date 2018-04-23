<?php

$sql = "SELECT inv_fifo.*, '' AS suppname, stok_trf_batch.qty AS qtyin, 
                         (CASE WHEN stok_trf_batch.total_cost > 0 THEN stok_trf_batch.total_cost ELSE ((stok_trf_ln.total_cost / stok_trf_ln.qty) * stok_trf_batch.qty) END) AS costin, 
                         stok_trf_batch.no_batch, stok_trf_ln.id_ln, stok_trf_hdr.doc_date, stok_trf_hdr.ke_unit AS UnitID, stok_trf_hdr.ke_departemen AS deptid,  stok_trf_batch.tgl_expired, 
                         stok_trf_batch.tgl_manufac
FROM inv_fifo LEFT JOIN
                         stok_trf_batch ON (stok_trf_batch.id_trf_hdr = inv_fifo.id_hdr) AND (stok_trf_batch.id_ln = inv_fifo.id_ln) AND (stok_trf_batch.id_trf_batch = inv_fifo.id_batch) 
                         LEFT JOIN
                         stok_trf_ln ON stok_trf_ln.id_ln = inv_fifo.id_ln AND stok_trf_ln.id_trf_hdr = inv_fifo.id_hdr LEFT JOIN
                         stok_trf_hdr ON stok_trf_hdr.id = inv_fifo.id_hdr
WHERE inv_fifo.doc_type = 'TRF' AND stok_trf_hdr.proses_by > 0 AND stok_trf_batch.qty - qty_out > 0 AND stok_trf_hdr.status <> 'D'
"



?
<?php
session_start();
error_reporting(0);
  include "../../config/conn.php";
$id_rujukan=$_GET['pasien_rujukan'];
   $que="Select pr.id, pr.tanggal, pr.id_cabang_rujuk, pr.id_cabang_dirujuk, pr.tipe_rujukan from pasien_rujukan pr
                   where pr.id='$id_rujukan' ";

  $r=pg_fetch_array(pg_query($dbconn,$que));
  

 ?>
<table id="myTable4" class="table">
                    <thead class="table-info">
                    <tr>
                    
                      <th width="">NO RM</th>
                      <th width="">Nama</th>
                      <th width="">Test</th>
                      <th width="">Tanggal</th> 
                       <th width=""></th>                                
                    
                      
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                      $query="SELECT detail.id,  detail.id_detail, detail.id_pasien,  detail.jenis_pemeriksaan, p.nama, p.no_rm FROM pasien_rujukan_detail detail               
                              LEFT OUTER JOIN master_pasien p ON p.id = detail.id_pasien
                              WHERE detail.id_rujukan='$id_rujukan'";
                            $res=pg_query($dbconn,$query);

                                  while ($row=pg_fetch_assoc($res)) {
                                    //$a= explode(" ", $row[waktu_input] );
                                       ?>
                                         <tr>                                        
                                          
                                          <td class="text-left" ><?php echo $row["no_rm"] ?></td>
                                            <td class="text-left" ><?php echo $row["nama"] ?></td>
                                          <?php
                                          if($row['jenis_pemeriksaan']=='S'){
                      $jenis=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis WHERE id='$row[id_detail]'"));
                      
                      echo '<td>';
                        echo $nama_transaksi="$jenis[nama]";
                      echo '</td>'; 
                      
                    }
                    elseif($row['jenis_pemeriksaan']=='M'){
                      $a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM lab_analysis_group WHERE id='$row[id_detail]'"));
                      
                      echo '<td>';
                        echo $nama_transaksi="$a[nama]";
                      echo '</td>';
                    }
                    elseif($row['jenis_pemeriksaan']=='N'){
                      $a=pg_fetch_array(pg_query($dbconn,"SELECT * FROM tindakan WHERE id='$row[id_detail]'"));
                      
                      echo '<td>';
                        echo $nama_transaksi="$a[nama]";
                      echo '</td>';
                    }
                    elseif($row['jenis_pemeriksaan']=='E'){
                      
                      $b=pg_fetch_array(pg_query($dbconn,"SELECT p.nama_paket, d.* FROM billing_paket p INNER JOIN billing_paket_detail d on d.id_billing_paket=p.id  WHERE p.id='$row[id_detail]' order by d.id_detail "));

                      echo '<td>';
                        echo $b[nama_paket];
                      echo '</td>';

                      
                    }
                     ?>
                                          
                        <td class="text-left" ><?php echo $r['tanggal']; ?></td>
                        <td class="text-center" style="vertical-align:middle;">
                         <a id="<?php echo $row[id];?>" class="btn btn-danger btn-xs btnHapusRujukan" onclick="return confirm('Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="icon-trash"></i></a>
                               
                        </td>              
                        </tr>     

                        <?php
                        }
                        ?>
                      </tbody>                 
                </table>
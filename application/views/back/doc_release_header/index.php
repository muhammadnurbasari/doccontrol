

<!--main-container-part-->
<div id="content" class="yield">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href=""class="tip-bottom"><i class="icon-home"></i> <?php echo $title; ?></a></div>
  </div>
<!--End-breadcrumbs-->
<?php //var_dump($this->session->userdata()); ?>
  <div class="container-fluid">   
      <h3><span class="badge tombol badge-info add">add <?php echo explode('_', $table)[0].' '.explode('_', $table)[1]; ?></span></h3>
      <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title bg_lg"><span class="icon"><i class="icon-th-large"></i></span>
            <h5><?php echo $title; ?> Table</h5>
          </div>
          <div class="widget-content nopadding" >
            <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Propose No</th>
                    <th>Propose Date</th>
                    <th>Document No</th>
                    <th>No Revisi</th>
                    <th>Document Name</th>
                    <th>Created By</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $no = 1;
                    foreach ($doc_release_headers as $key => $value):
                      // make doc_no
                      $doc_no = 'ILP-'.$this->Result_model->get_name_by_id('document', $value['doc_type_id'], 'document_code');
                      $doc_no .= '-'.$this->Result_model->get_name_by_id('department', $value['department_id'], 'department_code');
                      if ($value['doc_category_id'] < 10) {
                        $doc_category_id = '0'.$value['doc_category_id'];
                      } else {
                        $doc_category_id = $value['doc_category_id'];
                      }
                      $doc_no .= '-'.$doc_category_id;
                      if ($value['doc_no'] < 10) {
                        $doc_nomor_urut = '0'.$value['doc_no'];
                      } else {
                        $doc_nomor_urut = $value['doc_no'];
                      }
                      $doc_no .= '-'.$doc_nomor_urut;
                      $revisi_no = $this->Result_model->get_name_by_id('doc_release_header', $value['doc_release_header_id'], 'revisi_no');
                      if ($revisi_no == NULL) {
                        $revisi_no = '00';
                      } else {
                        if ($revisi_no < 10) {
                          $revisi_no = '0'.$revisi_no;
                        } else {
                          $revisi_no = $revisi_no;
                        }
                      }
                      $doc_no .= '-'.$revisi_no;
                      // finish mak doc_no
                  ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $value['doc_release_code']; ?></td>
                      <td><?php echo $value['doc_release_date']; ?></td>
                      <td><?php echo $doc_no; ?></td>
                      <td><?php echo $value['revisi_no'] == NULL ? 0 : $value['revisi_no']; ?></td>
                      <td><?php echo $value['doc_title']; ?></td>
                      <td><?php echo $this->Result_model->get_name_by_id('user', $value['created_by'], 'user_name'); ?></td>
                      <td>
                        <?php if ($value['doc_status'] == 0) { ?>
                            <span><h5 class="text-danger">Waiting </h5></span>
                        <?php } ?>
                        <?php if ($value['doc_status'] == 1) { ?>
                            <span><h5 class="text-danger">Approved</h5></span>
                        <?php } ?>
                        <?php if ($value['doc_status'] == 2) { ?>
                            <span><h5 class="text-danger">Revise</h5></span>
                        <?php } ?>
                        <?php if ($value['doc_status'] == 3) { ?>
                            <span><h5 class="text-danger">Rejected</h5></span>
                        <?php } ?>
                       </td>
                      <td>
                        <a target="_BLANK" href="<?php echo base_url('assets/files/release/'.$value['doc_file']) ?>">
                          <span class="badge tombol badge-warning" data-id="<?php echo $value[$table.'_id']; ?>"><i class="icon-info-sign"></i></span>
                        </a>
                        <span class="badge tombol badge-success edit" data-id="<?php echo $value[$table.'_id']; ?>"><i class="icon-edit"></i></span>
                      </td>  
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
          </div>
        </div>
      </div>
    <hr/>
  </div>  
</div>

<!--end-main-container-part-->



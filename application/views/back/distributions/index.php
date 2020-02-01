
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<!--main-container-part-->
<div id="content" class="yield">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href=""class="tip-bottom"><i class="icon-home"></i> <?php echo $title; ?></a></div>
  </div>
<!--End-breadcrumbs-->
<?php //var_dump($this->session->userdata()); ?>
  <div class="container-fluid">
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
                    <th>Document Name</th>
                    <th>Created By</th>
                    <th>Approve MR By</th>
                    <th>Approve Date</th>
                    <th>Status</th>
                    <th>Document Files</th>
                    <th class="action">Action</th>
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
                      <td><?php echo $value['doc_title']; ?></td>
                      <td><?php echo $this->Result_model->get_name_by_id('user', $value['created_by'], 'user_name'); ?></td>
                      <td>
                        <?php 
                        $user_id = $this->Result_model->get_name_by_name('release_approves','doc_release_header_id', $value['doc_release_header_id'], 'approve_mr_by');
                        echo $this->Result_model->get_name_by_id('user', $user_id, 'user_name');
                        ?>
                      </td>
                      <td><?php echo date('d F Y', strtotime($value['doc_release_date'])); ?></td>
                      <td class="status">
                        <?php 
                          $doc_release_header_id = $value['doc_release_header_id'];
                          $cek_distribution = $this->db->query("SELECT * FROM doc_release_details RIGHT JOIN distributions ON doc_release_details.doc_release_details_id = distributions.doc_release_details_id WHERE doc_release_details.doc_release_header_id = '$doc_release_header_id'")->result_array();
                          if ($cek_distribution) {
                            echo $status = '<span class="label label-info status">Confirmed</span>';
                          } else {
                            echo $status = '<span class="label label-important status">No Confirmed</span>';
                          }
                         ?>
                      <td><a target="_BLANK" href="<?php echo base_url('assets/files/release/'.$value['doc_file']) ?>">
                          <span class="badge tombol badge-warning" data-id="<?php echo $value[$table.'_id']; ?>"><i class="icon-info-sign"></i> show & download</span>
                        </a></td>
                      <td class="action">
                        <a target="_BLANK" href="<?php echo base_url('assets/files/release/'.$value['doc_file']) ?>">
                          <span class="badge tombol badge-warning" data-id="<?php echo $value[$table.'_id']; ?>"><i class="icon-info-sign"></i></span>
                        </a>
                        <span class="badge tombol badge-success edit" data-id="<?php echo $value[$table.'_id']; ?>"><i class="icon-edit"></i></span>
                        <?php if ($value['doc_status'] == 3) { ?>
                          <span class="badge tombol badge-important hapus" data-toggle="modal" data-target="#deletemodal" data-id="<?php echo $value[$table.'_id']; ?>" data-name="<?php echo $value['doc_release_code']; ?>"><i class="icon-trash"></i></span>
                        <?php } ?>
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

<script type="text/javascript">
  $(document).ready(function() {

    var status = $('td.status span.status').html();
    get_status(status);

    function get_status(status) {
      if (status == 'No Confirmed') {
        $('td.action').html(`<h6>click to confirm</h6><label class="switch"><input type="checkbox"><span class="slider round"></span></label>`);
        $('th.action').html('click to confirmed');
      }
    }
  })
</script>



























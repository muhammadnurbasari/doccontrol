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
                    <th>Confirm By</th>
                    <th>Confirm Date</th>
                    <th>Status</th>
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
                      <td>
                        <?php 
                          $this->db->where('department_id', $this->session->userdata('user')[0]['department_id']);
                          $doc_release_details_id = $this->Result_model->get_name_by_name('doc_release_details','doc_release_header_id', $value['doc_release_header_id'], 'doc_release_details_id');

                          if (!$doc_release_details_id) {
                              echo "-";
                           } else {
                            if (!$this->Result_model->get_name_by_name('distributions','doc_release_details_id', $doc_release_details_id)) {
                              echo "-";
                            } else {
                              echo $this->Result_model->get_name_by_id('user', $this->Result_model->get_name_by_name('distributions','doc_release_details_id', $doc_release_details_id, 'confirm_by'), 'user_name');
                            }
                           }
                         ?>
                      </td>
                      <td>
                        <?php 
                          $this->db->where('department_id', $this->session->userdata('user')[0]['department_id']);
                          $doc_release_details_id = $this->Result_model->get_name_by_name('doc_release_details','doc_release_header_id', $value['doc_release_header_id'], 'doc_release_details_id');

                          if (!$doc_release_details_id) {
                              echo "-";
                           } else {
                            if (!$this->Result_model->get_name_by_name('distributions','doc_release_details_id', $doc_release_details_id)) {
                              echo "-";
                            } else {
                              echo $this->Result_model->get_name_by_name('distributions','doc_release_details_id', $doc_release_details_id, 'confirm_date');
                            }
                           }
                         ?>
                      </td>
                      <td class="status">
                        <?php 
                          $doc_release_header_id = $value['doc_release_header_id'];
                          $department_id = $this->session->userdata('user')[0]['department_id'];
                          $this->db->where('department_id', $department_id);
                          $cek_id_detail = $this->Result_model->get_by_name('doc_release_details', 'doc_release_header_id' , $doc_release_header_id);
                          foreach ($cek_id_detail as $key => $nilai) :
                            if ($this->Result_model->get_by_name('distributions', 'doc_release_details_id' , $nilai['doc_release_details_id'])) {
                              echo $status = '<span class="label label-info status">Confirmed</span>';
                              break;
                            } else {
                              echo $status = '<span class="label label-important status">No Confirmed</span>';
                              break;
                            }
                          endforeach;
                         ?>
                         <input type="hidden" class="doc_details_id" value="<?php echo $value['doc_release_details_id']; ?>">
                      </td>
                      <td class="action">
                        <a target="_BLANK" href="<?php echo base_url('assets/files/release/'.$value['doc_file']) ?>">
                          <span class="badge tombol badge-warning" data-id="<?php echo $value[$table.'_id']; ?>"><i class="icon-info-sign"></i> view & download</span>
                        </a>
                        <a target="_BLANK" href="<?php echo base_url('result/report/pengesahan/'.$value['doc_release_header_id']) ?>">
                          <span class="badge tombol badge-info" data-id="<?php echo $value[$table.'_id']; ?>"><i class="icon-print"></i> Lembar Pengesahan</span>
                        </a>
                        <span class="badge tombol badge-success details-distributions" data-toggle="modal" data-target="#modalDetailDistributions" data-id="<?php echo $value[$table.'_id']; ?>"><i class="icon-edit"></i> details</span>
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

      <div class="modal fade" id="modalDetailDistributions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Confirm Distributions Details</h5>
            </div>
            <div class="modal-body"></div>
          </div>
        </div>
      </div>
<!--end-main-container-part-->

<script type="text/javascript">
  $(document).ready(function() {
    
    $('td.status span.status').each(function(index, value) {
      var action = $(this).closest('tr').find('td.action');
      get_status($(this).html(), action);
    })

    function get_status(status, action) {
      if (status == 'No Confirmed') {
        action.html(`<strong>CLICK TO CONFIRM</strong><br><label class="switch"><input type="checkbox" class="toggle_confirm"><span class="slider round"></span></label>`);
      }
    }

    $('body').on('click','input.toggle_confirm', function() {
      var doc_details_id = $(this).closest('tr').find('input.doc_details_id').val();
      $.ajax({
        url : '<?php echo base_url('result/distributions/confirmed') ?>'+'/'+doc_details_id,
        success : function(response) {
          PNotify.success({
            text : response
          })
          setTimeout(function() {
            window.location.replace('<?php echo base_url('result/distributions'); ?>')
          }, 1200)
        }
      })
    })

    // ajax modal
    $('.details-distributions').each(function(index, value) {
      $(this).click(function() {
        var id = $(this).data('id');
        $.ajax({
          url : '<?php echo base_url('result/distributions/details') ?>'+'/'+id,
          success : function(response) {
            var result = JSON.parse(response);
            var confirm = [];
            for (var i = 0; i < result[1].length; i++) {
              confirm.push(result[1][i].department_id);
            }
            var html = `<div class="widget-box">
                          <div class="widget-title"> <span class="icon"><i class="icon-time"></i></span>
                            <h5>To Do List</h5>
                          </div>
                          <div class="widget-content nopadding">
                            <table class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                  <th>Department</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                              <tbody>`;
            for (var i = 0; i < result[0].length; i++) {
              if (jQuery.inArray(result[0][i].department_id, confirm) != -1) {
                html += `<tr>
                          <td class="taskDesc">`+result[0][i].department_code+`</td>
                          <td class="taskStatus"><span class="in-progress">CONFIRMED</span></td>
                        </tr>`
              } else {
                html += `<tr>
                          <td class="taskDesc">`+result[0][i].department_code+`</td>
                          <td class="taskStatus"><span class="pending">NO CONFIRMED</span></td>
                        </tr>`
              }
            }
                html += `</tbody>
                        </table>
                      </div>
                    </div>`
            $('.modal-body').html(html)
          }
        })
      })
    })

  })
</script>


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
                            <span class="label label-warning">Waiting</span>
                        <?php } ?>
                        <?php if ($value['doc_status'] == 1) { ?>
                            <span class="label label-primary">Approved</span>
                        <?php } ?>
                        <?php if ($value['doc_status'] == 2) { ?>
                            <span class="label label-info">Revise</span>
                        <?php } ?>
                        <?php if ($value['doc_status'] == 3) { ?>
                            <span class="label label-important">Rejected</span>
                        <?php } ?>
                       </td>
                      <td>
                        <a target="_BLANK" href="<?php echo base_url('assets/files/release/'.$value['doc_file']) ?>">
                          <span class="badge tombol badge-warning" data-id="<?php echo $value[$table.'_id']; ?>"><i class="icon-info-sign"></i> details</span>
                        </a>
                        <span class="badge tombol badge-success revise" data-id="<?php echo $value[$table.'_id']; ?>"><i class="icon-edit"></i> revise</span>
                        <span class="badge tombol badge-important destroyed" data-toggle="modal" data-target="#destroyed" data-id="<?php echo $value[$table.'_id']; ?>" data-name="<?php echo $value['doc_release_code']; ?>"><i class="icon-trash"></i> destroyed</span>
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

<!-- modal destroyed -->
        <div class="modal fade" id="destroyed" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
            </div>
            <div class="modal-footer">
              <form action="<?= base_url('result/revise/destroyed'); ?>" method="post" class="destroyed">
                <input type="hidden" name="<?php echo $table; ?>_id" id="id">
                <div class="form-actions">
                  <button type="button" class="btn btn-danger destroyed" data-dismiss="modal" aria-label="Close"><i class="icon-trash"></i></button>
                  <button class="btn btn-warning " type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

<!--end-main-container-part-->

<script type="text/javascript">
  $(document).ready(function() {
    $('span.revise').click(function() {
      var id = $(this).data('id')
      $.ajax({
        url : '<?php echo base_url('result/load_revise/') ?>'+'/'+id,
        success : function(response) {
          $('div.yield').html(response);
        }
      })
    })

    $('body').on('click','span.destroyed', function() {
      var id  = $(this).data('id');
      var name  = $(this).data('name');

      $("div.modal-header .modal-title").html('Yakin Musnahkan Document '+name+' ?');
      $("form input#id").val(id);
    });

    $('body').on('click','button.destroyed', function() {
      var form = $('form.destroyed');
      var here = $(this);
      $.ajax({
        url : form.attr('action'),
        data : form.serialize(),
        type : 'post',
        success : function(response) {
            PNotify.error({
              text : 'Proses destroyed data Berhasil'
            });
            setTimeout(function() {
              window.location.replace('<?php echo base_url('result/revise'); ?>')
            }, 1000);
        }
      });
    });

  })
</script>



































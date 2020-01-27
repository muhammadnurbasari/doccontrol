<div id="content-header">
  <div id="breadcrumb"> <a href="<?php echo base_url('result/release_approves'); ?>" class="tip-bottom"><i class="icon-home"></i> Release Approves</a> <a href="#" class="current"> Approves</a> </div>
  <h1>Document Control Approves</h1>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span8">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Document Control Approves - info</h5>
        </div>
        <div class="widget-content nopadding">
          <form class="form-horizontal edit-release">
            <div class="row-fluid">
              <div class="span6">
                <div class="control-group">
                  <label class="control-label">Release Propose No :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="doc_release_code" value="<?php echo $results->doc_release_code; ?>" readonly>
                    <input type="hidden" class="span11" name="doc_release_header_id" value="<?php echo $results->doc_release_header_id; ?>" readonly>
                  </div>
                </div>
              </div>
              <div class="span6">
                <div class="control-group">
                  <label class="control-label">Date :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="doc_release_date" value="<?php echo date('d F Y', strtotime($results->doc_release_date)); ?>" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="row-fluid">
              <div class="span12">
                <?php
                      // make doc_no
                      $doc_no = 'ILP-'.$this->Result_model->get_name_by_id('document', $results->doc_type_id, 'document_code');
                      $doc_no .= '-'.$this->Result_model->get_name_by_id('department', $results->department_id, 'department_code');
                      if ($results->doc_category_id < 10) {
                        $doc_category_id = '0'.$results->doc_category_id;
                      } else {
                        $doc_category_id = $results->doc_category_id;
                      }
                      $doc_no .= '-'.$doc_category_id;
                      if ($results->doc_no < 10) {
                        $doc_nomor_urut = '0'.$results->doc_no;
                      } else {
                        $doc_nomor_urut = $results->doc_no;
                      }
                      $doc_no .= '-'.$doc_nomor_urut;
                      // finish mak doc_no

                    //   make revise_no
                      $revisi_no = $results->revisi_no;
                      if ($revisi_no == NULL) {
                          $rev_no = '00';
                      } else {
                          $revisi_no > 9 ? $rev_no = $revisi_no : $rev_no = '0'.$revisi_no;
                      }
                    // finish make revise_no
                  ?>
                    <div class="control-group">
                      <label class="control-label">Document NO :</label>
                        <div class="controls controls-row">
                            <input type="text" class="span9 doc_no" value="<?= $doc_no; ?>" readonly>
                            <input type="text" class="span2 revise_no" value="<?= $rev_no; ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label">Document Name :</label>
                      <div class="controls">
                        <input type="text" class="span11" name="doc_title" value="<?= $results->doc_title; ?>">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label">Release Description :</label>
                      <div class="controls">
                        <input type="text" class="span11" name="description" value="<?= $results->description; ?>">
                      </div>
                    </div>
                    <div class="control-group doc_file">
                      <label class="control-label">Document Files</label>
                      <input type="hidden" class="span11" name="doc_file_old" value="<?= $results->doc_file; ?>">
                      <div class="controls">
                        <a target="_BLANK" href="<?php echo base_url('assets/files/release/'.$results->doc_file) ?>">
                          <span class="badge tombol badge-warning"><?= $results->doc_file; ?></span>
                        </a>
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label">Approve Note</label>
                      <div class="controls">
                        <input type="text" name="approve_note" class="span11">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label">Distribution To</label>
                      <div class="controls">
                      <?php 
                        $this->db->where('status', 1);
                        $departmen = $this->Result_model->getData('department');
                        foreach ($departmen as $key => $value) { ?>
                            <label>
                                <input type="checkbox" class="span1" name="distribution_to" />
                                <?= $value['department_code']; ?>
                            </label>
                      <?php } ?>
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label">Choose Action</label>
                      <div class="controls">
                        <label>
                        <input type="radio" class="span1" name="radios" />
                        Approve</label>
                        <label>
                        <input type="radio" class="span1" name="radios" />
                        Reject</label>
                        <label>
                        <input type="radio" class="span1" name="radios" />
                        Revise</label>
                      </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-success approve-release">Approve</button>
              <button type="submit" class="btn btn-danger">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

        <script type="text/javascript">
          $(document).ready(function() {
            $('button[type="submit"]').prop("disabled", false);
              var a=0;
              //binds to onchange event of your input field
              $('#upload_file').bind('change', function() {
                if ($('button:button').attr('disabled',true)){
                  $('button:button').attr('disabled',false);
                 }
                var ext = $('#upload_file').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['pdf']) == -1){
                   $('#error1').slideDown("slow");
                   a=0;
                   $('button:button').attr('disabled',true);
                 } else {
                   $('button:button').attr('disabled',false);
                   $('#error1').slideUp("slow");
                   $('div.doc_file').slideUp('slow');
                 }
              });

            $("select.doc_category").prop('disabled', false);
            $('body').on('change','select.doc_id', function() {
              var doc_category = $("select.doc_category").val();
              $("select.doc_category").prop('disabled', false);
              if (doc_category == '' || doc_category == null) {
                $("input.doc_no").val('ILP-'+$(this).val().split('/')[1]);
              } else {
                doc_no();
              }
            });

            $('body').on('change','select.doc_category', function() {
              doc_no();
            });

            function doc_no() {
              var doc_id = $("select.doc_id").val().split('/')[0];
              var doc_id_view = $("select.doc_id").val().split('/')[1];
              var department_id = '<?php echo $this->session->userdata('user')[0]['department_id']; ?>';
              var doc_category_id = $('select.doc_category').val();
              if (doc_category_id < 10) {
                var no = '0';
              } else {
                var no = '';
              }
              var dept_name = $("input[name=department_id]").val();
              $.ajax({
                url : '<?php echo base_url('result/make_doc_no') ?>'+'/'+doc_id+'/'+department_id+'/'+doc_category_id,
                success : function(response) {
                  $("input.doc_no").val('ILP-'+doc_id_view+'-'+dept_name+'-'+no+doc_category_id+'-'+response+'-00');
                  $("input[name=doc_no]").val(response);
                }
              })
            }

            $('form.edit-release').submit(function(e){
            e.preventDefault(); 
                 $.ajax({
                     url: '<?php echo base_url('result/doc_release_header/update');?>',
                     type: "post",
                     data: new FormData(this),
                     processData:false,
                     contentType:false,
                     cache:false,
                     async:false,
                      success: function(response){
                         if (Number(response) == Number(1)) {
                            PNotify.success({
                              text : 'Berhasil Update'
                            });
                            setTimeout(function() {
                              window.location.replace('<?php echo base_url('result/doc_release_header'); ?>')
                            }, 1200);
                          } else {
                            PNotify.error({
                              text : response
                            });
                          }
                      }
                 });
            });

          });
        </script>
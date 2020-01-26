<div id="content-header">
  <div id="breadcrumb"> <a href="<?php echo base_url('result/doc_release_header'); ?>" class="tip-bottom"><i class="icon-home"></i> Release Document Propose</a> <a href="#" class="current">add doc propose</a> </div>
  <h1>Form Add Doc Propose</h1>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span8">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Release Document Propose - info</h5>
        </div>
        <div class="widget-content nopadding">
          <form class="form-horizontal add-release">
            <div class="row-fluid">
              <div class="span6">
                <div class="control-group">
                  <label class="control-label">Release Propose No :</label>
                  <?php 
                    $count_all = $this->db->count_all('doc_release_header');
                    if ($count_all == 0) {
                      $doc_release_code = 'RDP-'.date('Ymd').'-001';
                    } else {
                      $id = explode('-', $this->Result_model->get_name_by_id('doc_release_header', $this->Result_model->get_max_by_id('doc_release_header'), 'doc_release_code'))[2] + 1;
                      if ($id < 9 || $id == 9) {
                        $maks_id = '00'.$id;
                      } elseif ($id > 9 || $id < 100) {
                        $maks_id = '0'.$id;
                      } else {
                        $maks_id = $id;
                      }
                      $doc_release_code = 'RDP-'.date('Ymd').'-'.$maks_id;
                    }
                   ?>
                  <div class="controls">
                    <input type="text" class="span11" name="doc_release_code" value="<?php echo $doc_release_code; ?>" readonly>
                  </div>
                </div>
              </div>
              <div class="span6">
                <div class="control-group">
                  <label class="control-label">Date :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="doc_release_date" value="<?php echo date('d F Y'); ?>" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="row-fluid">
              <div class="span12">
                    <div class="control-group">
                      <label class="control-label">Document NO :</label>
                        <div class="controls controls-row">
                          <input type="text" class="span1 m-wrap" readonly value="ILP" name="ilp">
                          <input type="hidden" class="span1 m-wrap doc_id" readonly>
                          <select class="span2 m-wrap doc_id" name="doc_type_id">
                            <option value="" disabled selected>pilih doc</option>
                            <?php
                              $this->db->where('status', 1);
                              $document = $this->Result_model->getData('document');
                              foreach ($document as $key => $value) { ?>
                                <option value="<?php echo $value['document_id']; ?>/<?php echo $value['document_code']; ?>"><?php echo $value['document_code']; ?></option>
                            <?php }
                            ?>
                          </select>
                          <input type="text" readonly name="department_id" value="<?php echo $this->Result_model->get_name_by_id('department', $this->session->userdata('user')[0]['department_id'], 'department_code'); ?>" class="span2 m-wrap">
                          <select class="span5 m-wrap doc_category" name="doc_category_id">
                            <option value="" disabled selected>pilih doc category</option>
                            <?php
                              $this->db->where('status', 1);
                              $doc_categories = $this->Result_model->get_by_name('doc_category','department_id', $this->session->userdata('user')[0]['department_id']);
                              foreach ($doc_categories as $key => $value) { ?>
                                <option value="<?php echo $value['doc_category_id']; ?>"><?php echo $value['doc_category_name']; ?></option>
                            <?php }
                            ?>
                          </select>
                          <input type="text" class="span1 m-wrap" readonly value="<?php echo '00'; ?>" name="doc_no">
                        </div>
                    </div>
                    <div class="control-group">
                      <div class="controls">
                        <input type="text" class="span11 doc_no" readonly>
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label">Document Name :</label>
                      <div class="controls">
                        <input type="text" class="span11" name="doc_title">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label">Release Description :</label>
                      <div class="controls">
                        <input type="text" class="span11" name="description">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label">Document Files</label>
                      <div class="controls">
                        <input type="file" name="doc_file" id="upload_file">
                        <p id="error1" style="display:none; color:#FF0000;">
                          Forrmat file yang disetujui sistem : (PDF).
                        </p>
                      </div>
                    </div>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-success add-release">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

        <script type="text/javascript">
          $(document).ready(function() {

            $('button[type="submit"]').prop("disabled", true);
              var a=0;
              //binds to onchange event of your input field
              $('#upload_file').bind('change', function() {
                if ($('button:button').attr('disabled',false)){
                  $('button:button').attr('disabled',true);
                 }
                var ext = $('#upload_file').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['pdf']) == -1){
                   $('#error1').slideDown("slow");
                   a=0;
                 } else {
                   $('button:button').attr('disabled',false);
                   $('#error1').slideUp("slow");
                 }
              });

            $("select.doc_category").prop('disabled', true);
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

            $('form.add-release').submit(function(e){
            e.preventDefault(); 
                 $.ajax({
                     url: '<?php echo base_url('result/doc_release_header/add');?>',
                     type: "post",
                     data: new FormData(this),
                     processData:false,
                     contentType:false,
                     cache:false,
                     async:false,
                      success: function(response){
                         if (Number(response) == Number(1)) {
                            PNotify.success({
                              text : 'Berhasil Simpan'
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
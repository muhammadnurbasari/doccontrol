<!--Footer-part-->
<!-- test -->
<!-- test Nurahman "New Push" -->
<div class="row-fluid">
  <div id="footer" class="span12"> 2019 &copy; Bashost</div>
</div>

        <!-- modal delete -->
        <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
            </div>
            <div class="modal-footer">
              <form action="<?= base_url('result/'.$table.'/delete'); ?>" method="post" class="delete">
                <input type="hidden" name="<?php echo $table; ?>_id" id="id">
                <button type="button" class="btn btn-danger hapus" data-dismiss="modal" aria-label="Close"><i class="icon-trash"></i></button>
                <button class="btn btn-warning " type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- modal change password -->
        <div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
              <div class="row-fluid">
                <div class="span12">
                  <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                      <h5>department-info</h5>
                    </div>
                    <div class="widget-content nopadding">
                      <form action="<?php echo base_url('result/change_password'); ?>" method="post" class="form-horizontal change">
                        <div class="control-group">
                          <label class="control-label">Password Old :</label>
                          <div class="controls">
                            <input type="password" class="span11" name="password_old" required>
                            <p class="taskStatus error" style="display: none;"><span class="pending"><i class="icon-info-sign"></i> Your password old is not valid</span></p>
                            <p class="taskStatus valid" style="display: none;"><span class="done"><i class="icon-ok-circle"></i> Valid</span></p>
                          </div>
                        </div>
                        <div class="control-group">
                          <label class="control-label">New Password :</label>
                          <div class="controls">
                            <input type="password" name="new_password" class="span11" required>
                          </div>
                        </div>
                        <div class="control-group">
                          <label class="control-label">Confirm New Password :</label>
                          <div class="controls">
                            <input type="password" name="confirm_new_password" class="span11" required>
                          </div>
                        </div>
                        <div class="form-actions">
                          <button type="button" class="btn btn-success change" data-dismiss="modal" aria-label="Close">Change Password</button>
                          <button class="btn btn-danger " type="button" data-dismiss="modal" aria-label="Close"> Cancel
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>

<!--end-Footer-part-->

<script src="<?= base_url('assets/'); ?>js/excanvas.min.js"></script> 
<script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script> 
<script src="<?= base_url('assets/'); ?>js/jquery.ui.custom.js"></script> 
<script src="<?= base_url('assets/'); ?>js/bootstrap.min.js"></script> 
<script src="<?= base_url('assets/'); ?>js/jquery.peity.min.js"></script> 
<script src="<?= base_url('assets/'); ?>js/fullcalendar.min.js"></script> 
<script src="<?= base_url('assets/'); ?>js/jquery.validate.js"></script> 
<script src="<?= base_url('assets/'); ?>js/matrix.form_validation.js"></script> 
<script src="<?= base_url('assets/'); ?>js/jquery.wizard.js"></script> 
<script src="<?= base_url('assets/'); ?>js/jquery.uniform.js"></script> 
<script src="<?= base_url('assets/'); ?>js/select2.min.js"></script> 
<script src="<?= base_url('assets/'); ?>js/matrix.popover.js"></script>
<script src="<?= base_url('assets/'); ?>js/jquery.dataTables.min.js"></script> 
<script src="<?= base_url('assets/'); ?>js/matrix.js"></script> 
<script src="<?= base_url('assets/'); ?>js/matrix.tables.js"></script>
<script src="<?= base_url('assets/'); ?>js/matrix.chat.js"></script> 
<!-- <script src="<?= base_url('assets/'); ?>js/bootstrap-wysihtml5.js"></script>  -->
<script src="<?= base_url('assets/'); ?>notify/PNotify.js"></script>  

<script type="text/javascript">

$(document).ready(function() {

  var $yield = $("div.yield");
  var table = '<?php echo $table ?>';
  var user_id = '<?= $this->session->userdata('user')[0]['user_id']; ?>';

  // logout
  $('p.logout').click(function() {
    var url_logout = '<?php echo base_url('result/logout'); ?>'
    $.ajax({
      url : url_logout,
      success : function(response) {
        if (Number(response) == Number(1)) {
          PNotify.error({
            text : 'Anda Telah Logout'
          })
          setTimeout(function() {
            window.location.replace('<?php echo base_url('result/index'); ?>')
          }, 500);
        }
      }
    });
  });

  // change password

        // validation password old
        $('input[name=password_old]').keyup(function() {
          $.ajax({
            url : '<?= base_url('result/validation_change_password/password_old'); ?>'+'/'+user_id,
            success : function(response) {
              if (Number(response) == Number(1)) {
                $('p.valid').slideDown('slow');
                $('p.error').slideUp('slow');
              } else {
                $('p.error').slideDown('slow');
                $('p.valid').slideUp('slow');
              }
            }
          })
        })
        // finish validation password old


  
  
  // finish change password

  // go to form add
  $('body').on('click','span.add', function() {
    $.ajax({
      url : '<?php echo base_url('result/ajax_load/'.$table.'/add'); ?>',
      success : function(response) {
        $yield.html(`
              <div id="content-header">
                <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> <?php echo $title; ?></a></div>
              </div>
              <img src="<?php echo base_url('assets/img/loading.gif'); ?>">
          `);
        setTimeout(function() {
          $yield.html(response);
        }, 1000);
      }
    })
  })

  // go to form edit
   $('body').on('click','span.edit', function() {
    var id = $(this).data('id');
    console.log(id)
    $.ajax({
      url : '<?php echo base_url('result/ajax_load/'.$table.'/'); ?>edit/'+id,
      success : function(response) {
        $yield.html(`
              <div id="content-header">
                <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> <?php echo $title; ?></a></div>
              </div>
              <img src="<?php echo base_url('assets/img/loading.gif'); ?>">
          `);
        setTimeout(function() {
          $yield.html(response);
        }, 1000);
      }
    })
  })

  // proses add
  $('body').on('click','button.add', function() {
    var form = $('form.add');
    var here = $(this);
    here.html('proses menyimpan...');
    $.ajax({
      url : form.attr('action'),
      data : form.serialize(),
      type : 'post',
      success : function(response) {
        here.html('Save');
        if (Number(response) == Number(1)) {
          PNotify.success({
            text : 'Berhasil Simpan'
          });
          setTimeout(function() {
            window.location.replace('<?php echo base_url('result/'); ?>'+table)
          }, 1000);
        } else {
          PNotify.error({
            text : response
          });
        }
      }
    });
  });

  // proses edit
  $('body').on('click','button.edit', function() {
    var form = $('form.edit');
    var here = $(this);
    here.html('proses update...');
    $.ajax({
      url : form.attr('action'),
      data : form.serialize(),
      type : 'post',
      success : function(response) {
        here.html('Update');
        if (Number(response) == Number(1)) {
          PNotify.success({
            text : 'Berhasil Update'
          });
          setTimeout(function() {
            window.location.replace('<?php echo base_url('result/'); ?>'+table)
          }, 1000);
        } else {
          PNotify.error({
            text : response
          });
        }
      }
    });
  });

  // modal delete
  $('body').on('click','span.hapus', function() {
    var id  = $(this).data('id');
    var name  = $(this).data('name');

    $("div.modal-header .modal-title").html('Yakin Hapus '+name+' ?');
    $("form input#id").val(id);
  });

  // proses hapus
  $('body').on('click','button.hapus', function() {
    var form = $('form.delete');
    var here = $(this);
    $.ajax({
      url : form.attr('action'),
      data : form.serialize(),
      type : 'post',
      success : function(response) {
          PNotify.error({
            text : 'Proses Hapus data Berhasil'
          });
          setTimeout(function() {
            window.location.replace('<?php echo base_url('result/'); ?>'+table)
          }, 1000);
      }
    });
  });

});
</script>
</body>
</html>























<div id="content-header">
  <div id="breadcrumb"> <a href="<?php echo base_url('result/document'); ?>" class="tip-bottom"><i class="icon-home"></i> documents</a> <a href="#" class="current">add document</a> </div>
  <h1>Form Add document</h1>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>document-info</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="<?php echo base_url('result/'.$table.'/add'); ?>" method="post" class="form-horizontal add">
            <div class="control-group">
              <label class="control-label">document code :</label>
              <div class="controls">
                <input type="text" class="span11" name="document_code" placeholder="document code" maxlength="4" required>
                <p class="taskStatus error" style="display: none;"><span class="pending"><i class="icon-info-sign"></i> Document Code sudah tersedia</span></p>
                <p class="taskStatus valid" style="display: none;"><span class="done"><i class="icon-ok-circle"></i> Valid</span></p>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">document name :</label>
              <div class="controls">
                <input type="text" name="document_name" class="span11" placeholder="document name" required>
              </div>
            </div>
            <div class="form-actions">
              <button type="button" class="btn btn-success add">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('body').on('keyup','input[name=document_code]', function(){
      var select_value = $(this).val();
      if (select_value == '' || select_value == null) {
        $("p.error").slideUp('slow');
        $("p.valid").slideUp('slow');
        $("button.add").prop('disabled', false);
      }
      $.ajax({
        url : '<?php echo base_url('result/validation/'.$table.'/document_code/') ?>'+select_value,
        success : function (response) {
          if (Number(response) == Number(0)) {
            $("p.error").slideDown('slow');
            $("p.valid").slideUp('slow');
            $("button.add").prop('disabled', true);
          } 
          if (Number(response) == Number(1)) {
            $("p.error").slideUp('slow');
            $("p.valid").slideDown('slow');
            $("button.add").prop('disabled', false);
          }  
        }
      })
    });
  })
</script>
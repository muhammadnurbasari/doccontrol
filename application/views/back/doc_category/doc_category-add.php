
<div id="content-header">
  <div id="breadcrumb"> <a href="<?php echo base_url('result/doc_category'); ?>" class="tip-bottom"><i class="icon-home"></i> doc categorys</a> <a href="#" class="current">add doc category</a> </div>
  <h1>Form Add doc category</h1>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>doc category-info</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="<?php echo base_url('result/'.$table.'/add'); ?>" method="post" class="form-horizontal add">
            <div class="control-group">
              <label class="control-label">doc category code :</label>
              <div class="controls">
                <input type="text" class="span11" name="doc_category_name" placeholder="doc category name" maxlength="100" required>
                <p class="taskStatus error" style="display: none;"><span class="pending"><i class="icon-info-sign"></i> Doc Category Name sudah tersedia</span></p>
                <p class="taskStatus valid" style="display: none;"><span class="done"><i class="icon-ok-circle"></i> Valid</span></p>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">department code :</label>
              <div class="controls">
                <input type="text" class="span11" name="department_code" value="<?php echo $this->Result_model->get_name_by_id('department', $this->session->userdata('user')[0]['department_id'], 'department_code'); ?>" required readonly>
                <input type="hidden" class="span11" name="department_id" value="<?php echo $this->session->userdata('user')[0]['department_id']; ?>" required readonly>
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
    $('body').on('keyup','input[name=doc_category_name]', function(){
      var select_value = $(this).val();
      console.log(select_value)
      if (select_value == '' || select_value == null) {
        $("p.error").slideUp('slow');
        $("p.valid").slideUp('slow');
        $("button.add").prop('disabled', false);
      }
      $.ajax({
        url : '<?php echo base_url('result/validation/'.$table.'/doc_category_name/') ?>'+select_value+'/department_id/'+$("input[name=department_id]").val(),
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
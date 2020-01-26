
<div id="content-header">
  <div id="breadcrumb"> <a href="<?php echo base_url('result/user'); ?>" class="tip-bottom"><i class="icon-home"></i> users</a> <a href="#" class="current">add user</a> </div>
  <h1>Form Add User</h1>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>User-info</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="<?php echo base_url('result/'.$table.'/add'); ?>" method="post" class="form-horizontal add">
            <div class="control-group">
              <label class="control-label">Username :</label>
              <div class="controls">
                <input type="text" class="span11" name="username" placeholder="username" maxlength="20" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Full Name :</label>
              <div class="controls">
                <input type="text" name="fullname" class="span11" placeholder="full name" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Password User</label>
              <div class="controls">
                <input type="password" name="password" class="span11" placeholder="Enter Password"  maxlength="10" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Address :</label>
              <div class="controls">
                <textarea class="span11" name="address" rows="6" placeholder="address"></textarea>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Email :</label>
              <div class="controls">
                <input type="email" name="email" maxlength="50" placeholder="email" class="span11" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Phone Number : </label>
              <div class="controls">
                <input type="number" name="phone_number" class="span11" placeholder="phone number" maxlength="15" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Department : </label>
              <div class="controls">
                <select class="span11" name="department" required>
                  <option value="" disabled selected>pilih...</option>
                  <?php 
                    $department = $this->db->get_where('department',['status' => 1])->result_array();
                    foreach ($department as $key => $value) : ?>
                      <option value="<?php echo $value['department_id']; ?>"><?php echo $value['department_code']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Access Level : </label>
              <div class="controls">
                <select class="span11" name="level" required disabled>
                </select>
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
  $('body').on('change','select[name=department]', function() {
    var id = $(this).val();
    $.ajax({
      url : '<?php echo base_url('result/ajax_set_dept_and_level/'); ?>'+id,
      success : function(response) {
        $("select[name=level]").removeAttr('disabled');
        if (response == 'QA') {
          $("select[name=level]").html(`<option value="" disabled selected>pilih...</option><option value="2">Head Of Dept</option>
                  <option value="3">Staff DC</option>`);
        }
        if (response == 'Management') {
          $("select[name=level]").html(`<option value="4">Head Of MR</option>`);
        }
        if (response == 'Other') {
          $("select[name=level]").html(`<option value="" disabled selected>pilih...</option><option value="1">Staff Dept</option>
                  <option value="2">Head Of Dept</option>`);
        }
        if (response == 'IT') {
          $("select[name=level]").html(`<option value="5">Admin System</option>`);
        }
      }
    });
  });
</script>






















<div id="content-header">
  <div id="breadcrumb"> <a href="<?php echo base_url('result/user'); ?>" class="tip-bottom"><i class="icon-home"></i> users</a> <a href="#" class="current">edit user</a> </div>
  <h1>Form Edit User</h1>
</div>
<div class="container-fluid">
  <?php //echo var_dump($results); ?>
  <hr>
  <div class="row-fluid">
    <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>User-info</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="<?php echo base_url('result/'.$table.'/update'); ?>" method="post" class="form-horizontal edit">
            <div class="control-group">
              <label class="control-label">Username :</label>
              <div class="controls">
                <input type="text" class="span11" name="username" placeholder="username" maxlength="20" required value="<?php echo $results->user_name; ?>">
                <input type="hidden" class="span11" name="<?php echo $table; ?>_id"  required value="<?php echo $results->user_id; ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Full Name :</label>
              <div class="controls">
                <input type="text" name="fullname" class="span11" placeholder="full name" required value="<?php echo $results->name; ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Address :</label>
              <div class="controls">
                <textarea class="span11" name="address" rows="6" placeholder="address"><?php echo $results->address; ?></textarea>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Email :</label>
              <div class="controls">
                <input type="email" name="email" maxlength="50" placeholder="email" class="span11" required value="<?php echo $results->email; ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Phone Number : </label>
              <div class="controls">
                <input type="number" name="phone_number" class="span11" placeholder="phone number" maxlength="15" required value="<?php echo $results->phone_number; ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Department : </label>
              <div class="controls">
                <select class="span11" name="department" required>
                  <option value="" disabled>pilih...</option>
                  <?php 
                    $department = $this->db->get_where('department',['status' => 1])->result_array();
                    foreach ($department as $key => $value) : 
                      if ($results->department_id == $value['department_id']) { ?>
                        <option value="<?php echo $value['department_id']; ?>" selected><?php echo $value['department_code']; ?></option>

                  <?php } else { ?>
                        <option value="<?php echo $value['department_id']; ?>"><?php echo $value['department_code']; ?></option>
                  <?php } ?>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Access Level : </label>
              <div class="controls">
                <input type="hidden" id="dept_value" value="<?php echo $results->department_id; ?>">
                <select class="span11" name="level" required>
                  <option value="" disabled selected>pilih...</option>

                  <?php 
                    $opt1 = '';
                    $opt2 = '';
                    $opt3 = '';
                    $opt4 = '';
                    $opt5 = '';

                    if ($results->level_id == 1) :
                      $opt1 = 'selected';
                    endif;

                    if ($results->level_id == 2) :
                      $opt2 = 'selected';
                    endif;

                    if ($results->level_id == 3) :
                      $opt3 = 'selected';
                    endif;

                    if ($results->level_id == 4) :
                      $opt4 = 'selected';
                    endif;

                    if ($results->level_id == 5) :
                      $opt5 = 'selected';
                    endif;

                   ?>
                  <option value="1" <?php echo $opt1; ?>>Staff Dept</option>
                  <option value="2" <?php echo $opt2 ?>>Head Of Dept</option>
                  <option value="3" <?php echo $opt3 ?>>Staff DC</option>
                  <option value="4" <?php echo $opt4 ?>>Head Of MR</option>
                  <option value="5" <?php echo $opt5 ?>>Admin System</option>
                </select>
              </div>
            </div>
            <div class="form-actions">
              <button type="button" class="btn btn-success edit">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    // var id = $("input#dept_value").val();
    // load_select_level(id);

    $("select[name=department]").click(function() {
      var dept_id = $(this).val();
      load_select_level(dept_id);
    })


    function load_select_level(dept_id) {
      $.ajax({
        url : '<?php echo base_url('result/ajax_set_dept_and_level/'); ?>'+dept_id,
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
    }

  })
</script>
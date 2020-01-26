
<div id="content-header">
  <div id="breadcrumb"> <a href="<?php echo base_url('result/department'); ?>" class="tip-bottom"><i class="icon-home"></i> departments</a> <a href="#" class="current">edit department</a> </div>
  <h1>Form edit department</h1>
</div>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span6">
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>department-info</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="<?php echo base_url('result/'.$table.'/update'); ?>" method="post" class="form-horizontal edit">
            <div class="control-group">
              <label class="control-label">Department Code :</label>
              <div class="controls">
                <input type="text" class="span11" name="department_code" placeholder="department code" maxlength="4" value="<?php echo $results->department_code; ?>" required>
                <input type="hidden" class="span11" name="<?php echo $table ?>_id" value="<?php echo $results->department_id; ?>" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Department Name :</label>
              <div class="controls">
                <input type="text" name="department_name" class="span11" placeholder="department name" value="<?php echo $results->department_name; ?>" required>
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

<div id="content-header">
  <div id="breadcrumb"> <a href="<?php echo base_url('result/doc_category'); ?>" class="tip-bottom"><i class="icon-home"></i> doc categorys</a> <a href="#" class="current">edit doc category</a> </div>
  <h1>Form edit doc category</h1>
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
          <form action="<?php echo base_url('result/'.$table.'/update'); ?>" method="post" class="form-horizontal edit">
            <div class="control-group">
              <label class="control-label">doc category code :</label>
              <div class="controls">
                <input type="text" class="span11" name="doc_category_name" placeholder="doc category name" value="<?php echo $results->doc_category_name; ?>" maxlength="100" required>
                <input type="hidden" class="span11" name="doc_category_id" value="<?php echo $results->doc_category_id; ?>" required>
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
              <button type="button" class="btn btn-success edit">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
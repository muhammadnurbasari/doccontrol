

<div id="content-header">
  <div id="breadcrumb"> <a href="<?php echo base_url('result/document'); ?>" class="tip-bottom"><i class="icon-home"></i> documents</a> <a href="#" class="current">edit document</a> </div>
  <h1>Form edit document</h1>
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
          <form action="<?php echo base_url('result/'.$table.'/update'); ?>" method="post" class="form-horizontal edit">
            <div class="control-group">
              <label class="control-label">document code :</label>
              <div class="controls">
                <input type="text" class="span11" name="document_code" placeholder="document code" value="<?php echo $results->document_code; ?>" maxlength="4" required>
                <input type="hidden" class="span11" name="document_id" value="<?php echo $results->document_id; ?>" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">document name :</label>
              <div class="controls">
                <input type="text" name="document_name" class="span11" placeholder="document name" value="<?php echo $results->document_name; ?>" required>
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
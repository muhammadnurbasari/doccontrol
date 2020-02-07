

<!--main-container-part-->
<div id="content" class="yield">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href=""class="tip-bottom"><i class="icon-home"></i> <?php echo $title; ?></a></div>
  </div>
<!--End-breadcrumbs-->
<?php //var_dump($this->session->userdata()); ?>
  <div class="container span8">   
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Form Elements</h5>
        </div>
        <div class="widget-content nopadding ">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Choose Report</label>
              <div class="controls">
                <select name="jenis">
                  <option value="" disabled selected>choose..</option>
                  <option value="release">Release</option>
                  <option value="expired">Expired</option>
                  <option value="destroyed">Destroyed</option>
                </select>
                <span class="help-block">Input tanggal mulai cetak laporan</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Date Start</label>
              <div class="controls">
                <input type="text" data-date-format="dd-mm-yyyy" class="datepicker span5">
                <span class="help-block">Input tanggal mulai cetak laporan</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Date Final</label>
              <div class="controls">
                <input type="text" data-date-format="dd-mm-yyyy" class="datepicker span5">
                <span class="help-block">Input tanggal akhir cetak laporan</span> </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-success">Save</button>
              <button type="submit" class="btn btn-primary">Reset</button>
              <button type="submit" class="btn btn-info">Edit</button>
              <button type="submit" class="btn btn-danger">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    <hr/>
  </div>  
</div>


<!--end-main-container-part-->





































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
          <h5>Form Report</h5>
        </div>
        <div class="widget-content nopadding ">
          <form class="form-horizontal report" action="<?php echo base_url('result/report/pdf'); ?>" method="POST" target="_BLANKS">
            <div class="control-group">
              <label class="control-label">Choose Report</label>
              <div class="controls">
                <select name="jenis" class="m-wrap" required>
                  <option value="release">Release</option>
                  <option value="expired">Expired</option>
                  <option value="destroyed">Destroyed</option>
                </select>
                <span class="help-block">Klik untuk memilih laporan</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Date Start</label>
              <div class="controls">
                <input type="text" data-date-format="dd-mm-yyyy" name="tgl_awal" class="datepicker span5" id="awal" required>
                <span class="help-block">Input tanggal mulai cetak laporan</span> </div>
            </div>
            <div class="control-group">
              <label class="control-label">Date Final</label>
              <div class="controls">
                <input type="text" data-date-format="dd-mm-yyyy" name="tgl_akhir" class="datepicker span5" id="akhir" required>
                <span class="help-block">Input tanggal akhir cetak laporan</span> </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-success pdf"><i class="icon-print"></i>  PRINT REPORT</button>
            </div>
          </form>
        </div>
      </div>
    <hr/>

    <!-- <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Form Print Pengesahan Document Release</h5>
        </div>
        <div class="widget-content nopadding ">
          <form class="form-horizontal report" action="<?php echo base_url('result/report/pengesahan'); ?>" method="POST" target="_BLANKS">
            <div class="control-group">
              <label class="control-label">Choose Document</label>
              <div class="controls">
                <select name="doc_release_header_id" class="m-wrap" required>
                  <?php foreach ($release as $key => $value): 
                      // make doc_no
                          $doc_no = 'ILP-'.$this->Result_model->get_name_by_id('document', $value['doc_type_id'], 'document_code');
                          $doc_no .= '-'.$this->Result_model->get_name_by_id('department', $value['department_id'], 'department_code');
                          if ($value['doc_category_id'] < 10) {
                            $doc_category_id = '0'.$value['doc_category_id'];
                          } else {
                            $doc_category_id = $value['doc_category_id'];
                          }
                          $doc_no .= '-'.$doc_category_id;
                          if ($value['doc_no'] < 10) {
                            $doc_nomor_urut = '0'.$value['doc_no'];
                          } else {
                            $doc_nomor_urut = $value['doc_no'];
                          }
                          $doc_no .= '-'.$doc_nomor_urut;
                          $revisi_no = $this->Result_model->get_name_by_id('doc_release_header', $value['doc_release_header_id'], 'revisi_no');
                          if ($revisi_no == NULL) {
                            $revisi_no = '00';
                          } else {
                            if ($revisi_no < 10) {
                              $revisi_no = '0'.$revisi_no;
                            } else {
                              $revisi_no = $revisi_no;
                            }
                          }
                          $doc_no .= '-'.$revisi_no;
                          // finish mak doc_no
                  ?>
                    <option value="<?php echo $value['doc_release_header_id']; ?>"><?php echo $doc_no; ?> --- <?php echo $value['doc_title']; ?></option>
                  <?php endforeach ?>
                </select>
                <span class="help-block">Klik untuk memilih document</span> </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary pdf"><i class="icon-print"></i>  PRINT LEMBAR PENGESAHAN</button>
            </div>
          </form>
        </div>
      </div> -->
  </div>  
</div>


<!--end-main-container-part-->

<script type="text/javascript">
  $(document).ready(function() {
    $('input.datepicker').datepicker();

    $('#awal').change(function() {
      console.log($(this).val())
    })
  })
</script>



































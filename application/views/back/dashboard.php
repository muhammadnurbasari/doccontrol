

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" class="tip-bottom"><i class="icon-home"></i> <?php echo $title; ?></a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
    <div class="quick-actions_homepage">
      <ul class="quick-actions">
        <li class="bg_lb"> <a href=""> <i class="icon-book"></i> <span class="label label-important"><?php echo count($noapprove) ?></span> Release Documents Propose </a> </li>
        <li class="bg_lg span3"> <a href=""> <i class="icon-check"></i><span class="label label-important"><?php echo count($progress) ?></span> Approves Propose</a> </li>
        <li class="bg_ly"> <a href=""> <i class="icon-reorder"></i><span class="label label-success"><?php echo count($release) ?></span> All Documents Release </a> </li>
        <li class="bg_lo"> <a href=""> <i class="icon-time"></i><span class="label label-success"><?php echo count($expired) ?></span> Expired Documents</a> </li>
      </ul>
    </div>
<!--End-Action boxes-->    

<!--Chart-box-->    
    <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-th-large"></i></span>
          <h5>Document Progress Table</h5>
        </div>
        <div class="widget-content nopadding" >
          <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>RDP NO</th>
                  <th>DATE</th>
                  <th>DOC NO</th>
                  <th>DOC NAME</th>
                  <th>CREATED BY</th>
                  <th>HEAD DEPT STATUS</th>
                  <th>DC STATUS</th>
                  <th>MR STATUS</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($dashboard as $key => $value): 
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
                  <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $value['doc_release_code'] ?></td>
                    <td><?php echo $value['doc_release_date'] ?></td>
                    <td><?php echo $doc_no ?></td>
                    <td><?php echo $value['doc_title'] ?></td>
                    <td><?php echo $this->Result_model->get_name_by_id('user', $value['created_by'], 'user_name') ?></td>
                    <td><?=  $value['approve_dept_by'] != NULL ? 'APPROVED' : 'WAITING' ?></td>
                    <td><?=  $value['approve_dc_by'] != NULL ? 'APPROVED' : 'WAITING' ?></td>
                    <td><?=  $value['approve_mr_by'] != NULL ? 'APPROVED' : 'WAITING' ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
        </div>
      </div>
    </div>
<!--End-Chart-box--> 
    <hr/>
  </div>  
</div>

<!--end-main-container-part-->



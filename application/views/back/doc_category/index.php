

<!--main-container-part-->
<div id="content" class="yield">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href=""class="tip-bottom"><i class="icon-home"></i> <?php echo $title; ?></a></div>
  </div>
<!--End-breadcrumbs-->

  <div class="container-fluid">   
      <h3><span class="badge tombol badge-info add">add <?php echo explode('_', $table)[0].' '.explode('_', $table)[1]; ?></span></h3>
      <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title bg_lg"><span class="icon"><i class="icon-th-large"></i></span>
            <h5><?php echo $title; ?> Table</h5>
          </div>
          <div class="widget-content nopadding" >
            <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Category Document Name</th>
                    <th>Department</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $no = 1;
                    foreach ($doc_categorys  as $key => $value):
                      $department = $this->db->get_where('department',['department_id' => $value['department_id']])->row()->department_code;
                  ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $value['doc_category_name']; ?></td>
                      <td><?php echo $department; ?></td>
                      <td>
                        <span class="badge tombol badge-success edit" data-id="<?php echo $value[$table.'_id']; ?>"><i class="icon-edit"></i></span>
                        <span class="badge tombol badge-important hapus" data-toggle="modal" data-target="#deletemodal" data-id="<?php echo $value[$table.'_id']; ?>" data-name="<?php echo $value['doc_category_name']; ?>"><i class="icon-trash"></i></span>
                      </td>  
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
          </div>
        </div>
      </div>
    <hr/>
  </div>  
</div>

<!--end-main-container-part-->



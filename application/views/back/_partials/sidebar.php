<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li><a href="<?php echo base_url('result'); ?>"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="submenu master"> <a href="#"><i class="icon icon-th-list"></i> <span>Master</span> <span class="label label-important master"></span></a>
      <ul>
        <li class="users" style="display : none;"><a href="<?php echo base_url('result/user'); ?>">Users</a></li>
        <li class="departments" style="display : none;"><a href="<?php echo base_url('result/department'); ?>">Departments</a></li>
        <li class="documents" style="display : none;"><a href="<?php echo base_url('result/document'); ?>">Documents</a></li>
        <li class="category_documents" style="display : none;"><a href="<?php echo base_url('result/doc_category'); ?>">Category Documents</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-file"></i> <span>Transaksi</span> <span class="label label-important transaksi"></span></a>
      <ul>
        <li class="release" style="display : none;"><a href="<?php echo base_url('result/doc_release_header'); ?>">Releases</a></li>
        <li class="approve" style="display : none;"><a href="<?php echo base_url('result/release_approves'); ?>">Approves</a></li>
        <li class="distribution" style="display : none;"><a href="<?php echo base_url('result/distributions'); ?>">Distributions</a></li>
        <li class="revise" style="display : none;"><a href="<?php echo base_url('result/notfound'); ?>">Revise</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i> <span>Arsip</span> <span class="label label-important arsip">4</span></a>
      <ul>
        <li style="display : none;" class="master_doc_list"><a href="<?php echo base_url('result/notfound'); ?>">Master Doc List</a></li>
        <li style="display : none;" class="expired_doc"><a href="<?php echo base_url('result/notfound'); ?>">Expired Doc</a></li>
        <li style="display : none;" class="destroyed"><a href="<?php echo base_url('result/notfound'); ?>">Destroyed</a></li>
        <li style="display : none;" class="external_doc"><a href="<?php echo base_url('result/notfound'); ?>">External Doc</a></li>
      </ul>
    </li>
    <li style="display : none;" class="report"><a href="<?php echo base_url('result/notfound'); ?>"><i class="icon icon-signal"></i> <span>Report</span></a> </li>
  </ul>
</div>
<!--sidebar-menu-->

<script>
  $(document).ready(function() {
    var level = '<?= $this->session->userdata('user')[0]['level_id']; ?>';
    access_staff_dept(level);
    access_head_of_dept(level);
    access_staff_dc(level);
    access_head_of_mr(level);
    admin_system(level);

    function access_staff_dept(level_id) {
      if (Number(level_id) == Number(1)) {
        $('li.category_documents').slideDown('slow');
        $('li.release').slideDown('slow');
        $('li.distribution').slideDown('slow');
        $('li.revise').slideDown('slow');
        $('li.master_doc_list').slideDown('slow');
        $('span.master').html('1');
        $('span.transaksi').html('3');
        $('span.arsip').html('1');
      }
    }

    function access_head_of_dept(level_id) {
      if (Number(level_id) == Number(2)) {
        $('li.category_documents').slideDown('slow');
        $('li.approve').slideDown('slow');
        $('li.distribution').slideDown('slow');
        $('li.master_doc_list').slideDown('slow');
        $('span.master').html('1');
        $('span.transaksi').html('2');
        $('span.arsip').html('1');
      }
    }

    function access_staff_dc(level_id) {
      if (Number(level_id) == Number(3)) {
        $('li.documents').slideDown('slow');
        $('li.category_documents').slideDown('slow');
        $('li.release').slideDown('slow');
        $('li.approve').slideDown('slow');
        $('li.distribution').slideDown('slow');
        $('li.revise').slideDown('slow');
        $('li.master_doc_list').slideDown('slow');
        $('li.expired_doc').slideDown('slow');
        $('li.destroyed').slideDown('slow');
        $('li.external_doc').slideDown('slow');
        $('li.report').slideDown('slow');
        $('span.master').html('2');
        $('span.transaksi').html('4');
        $('span.arsip').html('4');
      }
    }

    function access_head_of_mr(level_id) {
      if (Number(level_id) == Number(4)) {
        $('li.approve').slideDown('slow');
        $('li.master_doc_list').slideDown('slow');
        $('li.report').slideDown('slow');
        $('li.master').slideUp('slow');
        $('span.transaksi').html('1');
        $('span.arsip').html('1');
      }
    }

    function admin_system(level_id) {
      if (Number(level_id) == Number(5)) {
        $('li.documents').slideDown('slow');
        $('li.category_documents').slideDown('slow');
        $('li.departments').slideDown('slow');
        $('li.users').slideDown('slow');
        $('li.release').slideDown('slow');
        $('li.approve').slideDown('slow');
        $('li.distribution').slideDown('slow');
        $('li.revise').slideDown('slow');
        $('li.master_doc_list').slideDown('slow');
        $('li.expired_doc').slideDown('slow');
        $('li.destroyed').slideDown('slow');
        $('li.external_doc').slideDown('slow');
        $('li.report').slideDown('slow');
        $('span.master').html('4');
        $('span.transaksi').html('4');
        $('span.arsip').html('4');
      }
    }

  })
</script>
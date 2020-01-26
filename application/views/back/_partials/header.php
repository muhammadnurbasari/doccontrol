<!DOCTYPE html>
<html lang="en">
<head>
<title><?= $title; ?></title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/bootstrap.min.css" />
<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/uniform.css" />
<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/select2.css" />
<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/fullcalendar.css" />
<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/matrix-style.css" />
<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/matrix-media.css" />
<link href="<?= base_url('assets/'); ?>font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/jquery.gritter.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<link href="<?= base_url('assets/'); ?>notify/PNotifyBrightTheme.css" rel="stylesheet" />
<script src="<?= base_url('assets/'); ?>js/jquery-3.4.1.min.js"></script>
</head>
<body>
<style type="text/css">
  div#header h4{
    padding: 20px;
  }

  span.tombol {
    cursor: pointer;
  }
</style>
<!--Header-part-->
<div id="header">
  <h4><i class="icon-th-large"></i> DOC CONTROL</h4>
</div>
<!--close-Header-part--> 

<?php if ($this->session->userdata('user')[0]['level_id'] == 1): $level = 'Staff Dept'; endif ?>
<?php if ($this->session->userdata('user')[0]['level_id'] == 2): $level = 'Head Of Dept'; endif ?>
<?php if ($this->session->userdata('user')[0]['level_id'] == 3): $level = 'Staff DC'; endif ?>
<?php if ($this->session->userdata('user')[0]['level_id'] == 4): $level = 'Head Of MR'; endif ?>
<?php if ($this->session->userdata('user')[0]['level_id'] == 5): $level = 'Admin System'; endif ?>
<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text"><?php echo $this->session->userdata('user')[0]['user_name'] ?> | <?php echo $level; ?> | <?php echo $this->Result_model->get_name_by_id('department', $this->session->userdata('user')[0]['department_id'], 'department_code'); ?></span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li class="logout"><p class="logout" style="padding: 5px;"><i class="icon-key"></i> Log Out</p></li>
        <li class="change_password"><p class="change_password" style="padding: 5px;"><i class="icon-key"></i> Change password</p></li>
      </ul>
    </li>
  </ul>
</div>
<!--close-top-Header-menu-->
<style type="text/css">
  li.logout {
    cursor: pointer;
  }
</style>
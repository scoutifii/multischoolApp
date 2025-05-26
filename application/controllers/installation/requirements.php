<?php
$error_msg = false;
if (phpversion() < "5.4") {
    $error_msg = true;
    $requirement1 = "<span class='label label-warning'>Your PHP version is " . phpversion() . "</span>";
} else {
    $requirement1 = "<span class='label label-success'>v." . phpversion() . "</span>";
}

if (!extension_loaded('mysqli')) {
    $error_msg = true;
    $requirement2 = "<span class='label label-danger'><i class='fa fa-close'></i></span>";
} else {
    $requirement2 = "<span class='label label-success'><i class='fa fa-check-square-o'></i></span>";
}

if (!extension_loaded('gd')) {
    $error_msg = true;
    $requirement3 = "<span class='label label-danger'><i class='fa fa-close'></i></span>";
} else {
    $requirement3 = "<span class='label label-success'><i class='fa fa-check-square-o'></i></span>";
}

if (!extension_loaded('curl')) {
    $error_msg = true;
    $requirement4 = "<span class='label label-warning'><i class='fa fa-close'></i></span>";
} else {
    $requirement4 = "<span class='label label-success'><i class='fa fa-check-square-o'></i></span>";
}

if (!extension_loaded('mbstring')) {
    $error_msg = true;
    $requirement5 = "<span class='label label-danger'><i class='fa fa-close'></i></span>";
} else {
    $requirement5 = "<span class='label label-success'><i class='fa fa-check-square-o'></i></span>";
}

if (ini_get('allow_url_fopen') != "1") {
    $error_msg = true;
    $requirement6 = "<span class='label label-danger'><i class='fa fa-close'></i></span>";
} else {
    $requirement6 = "<span class='label label-success'><i class='fa fa-check-square-o'></i></span>";
}

if (!extension_loaded('zip')) {
    $error_msg = true;
    $requirement7 = "<span class='label label-danger'><i class='fa fa-close'></i></span>";
} else {
    $requirement7 = "<span class='label label-success'><i class='fa fa-check-square-o'></i></span>";
}

if (!is_really_writable($config_path)) {
    $error_msg = true;
    $requirement8 = "<span class='label label-danger'><i class='fa fa-close'></i></span>";
} else {
    $requirement8 = "<span class='label label-success'><i class='fa fa-check-square-o'></i></span>";
}

if (!is_really_writable(APPPATH . 'config/database.php')) {
    $error_msg = true;
    $requirement9 = "<span class='label label-danger'><i class='fa fa-close'></i></span>";
} else {
    $requirement9 = "<span class='label label-success'><i class='fa fa-check-square-o'></i></span>";
}

if (!is_really_writable(FCPATH . 'temp')) {
    $error_msg = true;
    $requirement10 = "<span class='label label-danger'><i class='fa fa-close'></i></span>";
} else {
    $requirement10 = "<span class='label label-success'><i class='fa fa-check-square-o'></i></span>";
}
?>

<?php
if ($error_msg) {
    echo '<div class="text-center alert alert-danger">Please fix the hosting/server requirements to proceed Global Multi School Installation.</div>';
} 
?>

<h3>Server Requirements</h3>
<table class="table table-hover">
    <thead>
        <tr>
            <th><b>Requirements</b></th>
            <th><b>Status</b></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>PHP 5.4+ </td>
            <td><?php echo $requirement1; ?></td>
        </tr>
        <tr>
            <td>MySQLi PHP Extension</td>
            <td><?php echo $requirement2; ?></td>
        </tr>
        <tr>
            <td>GD PHP Extension</td>
            <td><?php echo $requirement3; ?></td>
        </tr>
        <tr>
            <td>CURL PHP Extension</td>
            <td><?php echo $requirement4; ?></td>
        </tr>
        <tr>
            <td>MBString PHP Extension</td>
            <td><?php echo $requirement5; ?></td>
        </tr>
        <tr>
            <td>Allow allow_url_fopen</td>
            <td><?php echo $requirement6; ?></td>
        </tr>
        <tr>
            <td>Zip Extension</td>
            <td><?php echo $requirement7; ?></td>
        </tr>
        <tr>
            <td>config.php [application/config/config.php] Writable - Permissions 755</td>
            <td><?php echo $requirement8; ?></td>
        </tr>
        <tr>
            <td>database.php [application/config/database.php] Writable - Permissions 755</td>
            <td><?php echo $requirement9; ?></td>
        </tr>
        <tr>
            <td>/temp folder Writable - Permissions 755</td>
            <td><?php echo $requirement10; ?></td>
        </tr>
    </tbody>
</table>
<hr />

<?php if (!$error_msg) { ?>
    <?php echo form_open($this->uri->uri_string(), array('name' => 'requirements', 'id' => 'requirements', 'class'=>'form-horizontal form-label-left'), ''); ?>
    <input type="hidden" name="requirements" id="requirements" value="requirements" />
    <div class="text-right">
    <button type="submit" class="btn btn-primary">Go Next!</button>
    </div>
    <?php  form_close(); ?>   
<?php } ?>

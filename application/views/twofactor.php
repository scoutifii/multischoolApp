<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Two-factor Verification | <?php echo SMS; ?></title>
    <link href="<?php echo VENDOR_URL; ?>bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo VENDOR_URL; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet">    
    <link href="<?php echo CSS_URL; ?>custom.css" rel="stylesheet">
</head>
<body>
<div class="container" style="margin-top: 80px; max-width: 500px;">
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <h3>Two-factor Authentication</h3>
            <p>Please enter the 6-digit code from your authenticator app.</p>
        </div>
        <div class="panel-body">
            <div class="text-center">
                <p class="red"><?php echo $this->session->flashdata('error'); ?></p>
                <p class="green"><?php echo $this->session->flashdata('success'); ?></p>
            </div>

            <?php echo form_open(site_url('auth/twofactor'), array('id' => 'twofactor-form')); ?>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" value="<?php echo html_escape($username); ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Authentication Code</label>
                    <input type="text" name="code" class="form-control" placeholder="Enter 6-digit code" autocomplete="off" maxlength="6" required>
                </div>
                <button type="submit" class="btn btn-success btn-block">Verify</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
</body>
</html>

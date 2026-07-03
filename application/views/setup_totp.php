<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Setup Two-factor Authentication | <?php echo SMS; ?></title>
    <link href="<?php echo VENDOR_URL; ?>bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo VENDOR_URL; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet">    
    <link href="<?php echo CSS_URL; ?>custom.css" rel="stylesheet">
</head>
<body>
<div class="container" style="margin-top: 40px; max-width: 700px;">
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <h3>Setup Two-factor Authentication</h3>
            <?php if (!empty($enabled)): ?>
                <p class="text-success">Two-factor authentication is enabled for your account.</p>
            <?php else: ?>
                <p>Add your account to an authenticator app and confirm the one-time code.</p>
            <?php endif; ?>
        </div>
        <div class="panel-body">
            <div class="text-center">
                <p class="red"><?php echo $this->session->flashdata('error'); ?></p>
                <p class="green"><?php echo $this->session->flashdata('success'); ?></p>
            </div>

            <div class="row">
                <div class="col-md-6 text-center">
                    <p><strong>Scan this QR code</strong></p>
                    <img src="<?php echo html_escape($qr_url); ?>" alt="TOTP QR Code" class="img-responsive" style="margin: 0 auto;">
                </div>
                <div class="col-md-6">
                    <p><strong>Secret key</strong></p>
                    <p class="well" style="word-break: break-all;"><code><?php echo html_escape($secret); ?></code></p>
                    <p>Use this code in your authenticator app if scanning is not available.</p>
                </div>
            </div>

            <?php echo form_open(site_url('auth/setup_totp')); ?>
                <div class="form-group">
                    <label>Authenticator code</label>
                    <input type="text" name="code" class="form-control" placeholder="Enter 6-digit code" autocomplete="off" maxlength="6" required>
                </div>
                <button type="submit" class="btn btn-primary">Confirm and Enable</button>
                <?php if (!empty($enabled)): ?>
                    <a href="<?php echo site_url('auth/disable_totp'); ?>" class="btn btn-default">Disable TOTP</a>
                <?php endif; ?>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
</body>
</html>

Redirecting to PayTM....
<html>
<head>
    <script type="text/javascript">       
        function submit_pay_tm() {          
           document.forms.pay_tm.submit();           
        }
    </script>
</head>
<body onload="submit_pay_tm()">
    <form action="<?php echo $transactionURL ?>" method="post" name="pay_tm">
        <?php
            foreach($paytmParams as $name => $value) {
                echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
            }
	?>
        <input type="hidden" name="CHECKSUMHASH" value="<?php echo $paytmChecksum; ?>">
    </form>
</body>
</html>

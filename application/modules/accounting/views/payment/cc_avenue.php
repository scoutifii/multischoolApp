<?php

   // $checksum = $this->ccaencrypt->getchecksum($merchant_id, $amount, $order_id, $redirect_url, $working_key);
   // $merchant_data = 'Merchant_Id=' . $merchant_id . '&Amount=' . $amount . '&Order_Id=' . $order_id . '&Redirect_Url=' . $redirect_url . '&Cancel_Url=' . $cancel_url. '&billing_cust_name=' . $billing_cust_name . '&billing_cust_address=' . $billing_cust_address . '&billing_cust_country=' . $billing_cust_country . '&billing_cust_state=' . $billing_cust_state . '&billing_cust_city=' . $billing_city . '&billing_zip_code=' . $billing_zip . '&billing_cust_tel=' . $billing_cust_tel . '&billing_cust_email=' . $billing_cust_email . '&delivery_cust_name=' . $delivery_cust_name . '&delivery_cust_address=' . $delivery_cust_address . '&delivery_cust_country=' . $delivery_cust_country . '&delivery_cust_state=' . $delivery_cust_state . '&delivery_cust_city=' . $delivery_city . '&delivery_zip_code=' . $delivery_zip . '&delivery_cust_tel=' . $delivery_cust_tel . '&billing_cust_notes=' . $delivery_cust_notes . '&Checksum=' . $checksum;
   // $encrypted_data = $this->ccaencrypt->encrypt($merchant_data, $working_key); // Method for encrypting the data.
    
    $merchant_data = 'Name=' . $name . '&Aaddress=' . $address . '&Iid=' . $tid . '&Currency=' . $currency . '&Merchant_Id=' . $merchant_id . '&Amount=' . $amount . '&Order_Id=' . $order_id . '&Redirect_Url=' . $redirect_url . '&Cancel_Url=' . $cancel_url. '&billing_cust_name=' . $billing_cust_name . '&billing_cust_address=' . $billing_cust_address . '&billing_cust_country=' . $billing_cust_country . '&billing_cust_state=' . $billing_cust_state . '&billing_cust_city=' . $billing_city . '&billing_zip_code=' . $billing_zip . '&billing_cust_tel=' . $billing_cust_tel . '&billing_cust_email=' . $billing_cust_email . '&delivery_cust_name=' . $delivery_cust_name . '&delivery_cust_address=' . $delivery_cust_address . '&delivery_cust_country=' . $delivery_cust_country . '&delivery_cust_state=' . $delivery_cust_state . '&delivery_cust_city=' . $delivery_city . '&delivery_zip_code=' . $delivery_zip . '&delivery_cust_tel=' . $delivery_cust_tel . '&billing_cust_notes=' . $delivery_cust_notes;
    $encrypted_data = $this->ccaencrypt->encrypt($merchant_data, $working_key); // Method for encrypting the data.
    
?>

Redirecting to CCAvenue....
<html>
<head>
    <script type="text/javascript">       
        function submit_cc_avenue() {          
           document.forms.cc_avenue.submit();           
        }
    </script>
</head>
<body onload="submit_cc_avenue()">
    <form action="<?php echo $action; ?>" method="post" name="cc_avenue">
        <?php
        echo "<input type=hidden name=encRequest value=$encrypted_data>";
        echo "<input type=hidden name=Merchant_Id value=$merchant_id>";
        ?>
    </form>
</body>
</html>

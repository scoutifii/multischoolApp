<html>
<head>  
      <script>
        function payWithPaystack(){          
          var handler = PaystackPop.setup({
            key: '<?php echo $public_key; ?>',
            email: '<?php echo $email; ?>',
            amount: <?php echo $amount; ?>,
            currency: "NGN",
            ref: '<?php echo $reference; ?>', // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            callback: function(response){
                window.location = '<?php echo site_url('accounting/payment/pay_stack_success/'.$reference); ?>/'+response.transaction ;                
            },
            onClose: function(){
                //alert('Your payment has been cancel');  
                window.location = '<?php echo site_url('accounting/payment/pay_stack_cancel/'.$reference); ?>';
            }
          });
          handler.openIframe();
        }
      </script>     
      
      <style>
          .button{
            text-align: center;
            padding: 13px;
            color: fff;
            background: #01b75b;
            border: 0;
            font-size: 30px;
            border-radius: 5px;
            margin-top: 60px;
            cursor: pointer;
          }
      </style>
</head>
<body onload="payWithPaystack()">
    
    <form style="text-align: center;">
        <script src="https://js.paystack.co/v1/inline.js"></script>    
        <!--<button class="button" type="button" onclick="payWithPaystack()"> Confirm to Pay with PayStack</button>--> 
    </form>  
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            payWithPaystack();
        });
    </script>
  
</body>
</html>

  

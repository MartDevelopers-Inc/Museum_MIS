   <!-- Jquery Core Js -->
   <script src="assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
   <script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->

   <script src="assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
   <!-- Load Izi Alerts -->
   <!-- iZi Toast Js -->
   <script src="assets/plugins/iziToast/iziToast.min.js" type="text/javascript"></script>
   <?php if (isset($success)) { ?>
       <!--This code for injecting success alert-->
       <script>
           iziToast.success({
               title: 'Success',
               position: 'center',
               transitionIn: 'flipInX',
               transitionOut: 'flipOutX',
               transitionInMobile: 'fadeInUp',
               transitionOutMobile: 'fadeOutDown',
               message: '<?php echo $success; ?>',
           });
       </script>

   <?php } ?>

   <?php if (isset($err)) { ?>
       <!--This code for injecting error alert-->
       <script>
           iziToast.error({
               title: 'Error',
               timeout: 10000,
               resetOnHover: true,
               position: 'center',
               transitionIn: 'flipInX',
               transitionOut: 'flipOutX',
               transitionInMobile: 'fadeInUp',
               transitionOutMobile: 'fadeOutDown',
               message: '<?php echo $err; ?>',
           });
       </script>

   <?php } ?>

   <?php if (isset($info)) { ?>
       <!--This code for injecting info alert-->
       <script>
           iziToast.warning({
               title: 'Warning',
               position: 'center',
               transitionIn: 'flipInX',
               transitionOut: 'flipOutX',
               transitionIn: 'fadeInUp',
               transitionInMobile: 'fadeInUp',
               transitionOutMobile: 'fadeOutDown',
               message: '<?php echo $info; ?>',
           });
       </script>

   <?php }
    ?>
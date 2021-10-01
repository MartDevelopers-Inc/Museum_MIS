   <!-- Jquery Core Js -->
   <script src="assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
   <script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
   <script src="assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
   <script src="assets/plugins/autosize/autosize.js"></script> <!-- Autosize Plugin Js -->
   <!-- Load Izi Alerts -->
   <!-- iZi Toast Js -->
   <script src="assets/plugins/iziToast/iziToast.min.js" type="text/javascript"></script>
   <?php if (isset($success)) { ?>
       <!--This code for injecting success alert-->
       <script>
           iziToast.success({
               title: 'Success',
               position: 'topLeft',
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
               position: 'topLeft',
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
               position: 'topLeft',
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
   <!-- Jquery DataTable Plugin Js -->
   <script src="assets/bundles/datatablescripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->

   <script src="assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
   <script src="assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
   <script src="assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>
   <script src="assets/plugins/jquery-datatable/buttons/buttons.flash.min.js"></script>
   <script src="assets/plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>
   <script src="assets/plugins/jquery-datatable/buttons/buttons.print.min.js"></script>
   <script src="assets/js/pages/tables/jquery-datatable.js"></script>
   <script src="assets/js/pages/forms/basic-form-elements.js"></script>
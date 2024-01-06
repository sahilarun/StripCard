<script>
    $(document).on("click",".logout-btn",function(event) {
        event.preventDefault();
        var actionRoute =  "<?php echo e(setRoute('admin.logout')); ?>";
        var target      = "auth()->user()->id";
        var message     = `Are You Sure To <strong>Logout</strong>?`;
        openDeleteModal(actionRoute,target,message,"Logout","POST");
    });
</script><?php /**PATH E:\xampp-8.0.2\htdocs\strip_card\v-1.2.1\full_project\resources\views/admin/partials/auth-control.blade.php ENDPATH**/ ?>
<script>
    $(document).on("click",".logout-btn",function(event) {
        event.preventDefault();
        var actionRoute =  "{{ setRoute('admin.logout') }}";
        var target      = "auth()->user()->id";
        var message     = `Are You Sure To <strong>Logout</strong>?`;
        openDeleteModal(actionRoute,target,message,"Logout","POST");
    });
</script>
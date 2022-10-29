<footer class="main-footer">
    <strong>Copyright &copy; 2020-2021 <a href="#">Sports Book</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
</footer>
<script>
    function logout(e) {
        e.preventDefault();
        var result = confirm("Are you sure you want to logout?");
        if (result) {
            var logoutURL = "<?php echo base_url(); ?>logout";
            window.location.href = logoutURL;
        }
    }
</script>
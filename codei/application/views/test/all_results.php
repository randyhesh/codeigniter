<h1>included view</h1>


<button type="button" class="btn btn-primary" onclick="clickHere()" >Click</button>

<div id="ajax_work">

</div>

<script type="text/javascript">

    function clickHere() {

        alert("c");
      
        $.ajax({
            type: "POST",
//            dataType: "jsonp",
            url:  "<?php echo site_url(); ?>/test/check_ajax",
            //data: "id" + id,
            success: function (msg) {
                alert(msg);
                $('#ajax_work').html(msg);
            }
        });

    }

</script>
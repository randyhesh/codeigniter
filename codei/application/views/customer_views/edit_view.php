<div id="edit_model">
    <h3>Edit Customer</h3>

    <form id="edit_form" name="edit_form" method="POST">

        <input type="hidden" name="id_text" id="id_text" value="<?php
        if (!empty($customer)) {
            echo $customer->id;
        }
        ?>">

        <label>Name:</label>
        <input type="text" name="name_text" id="name_text" value="<?php
        if (!empty($customer)) {
            echo $customer->name;
        }
        ?>">
        <br>
        <label>Age:</label>
        <input type="text" name="age_text" id="age_text" value="<?php
               if (!empty($customer)) {
                   echo $customer->age;
               }
               ?>">

        <button type="submit">Save changes</button>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $("#edit_form").validate({
            rules: {
                name: {required: true}
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: js_site_url + "my_customer/edit_customer",
                    data: $('#edit_form').serialize(),
                    success: function (data) {
                        alert(data);
                    }
                });
            }
        });

    });

</script>
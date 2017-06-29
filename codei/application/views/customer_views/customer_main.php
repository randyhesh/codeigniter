<html>
    <title>Test APP</title>

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    </head>

    <script>
        var js_site_url =<?php echo site_url(); ?>
        var js_base_url =<?php echo base_url(); ?>
    </script>

    <body>
        <button type="button" name="add_btn" id="add_btn" style="color: red" onclick="view_add_customer()">Add</button>
        <table>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Age</th>
                <th>Action</th>
            </tr>
            <tbody>
                <?php
                if (!empty($customers)) {
                    foreach ($customers as $customer) {
                        ?>
                        <tr id="cust_<?php echo $customer->id; ?>">
                            <td><?php echo $customer->id; ?></td>
                            <td><?php echo $customer->name; ?></td>
                            <td><?php echo $customer->age; ?></td>
                            <td>
                                <a href="<?php echo site_url(); ?>/my_customer/load_edit_customer/<?php echo $customer->id; ?>">Edit</a>
                                <button type="button" name="del_btn" id="del_btn" onclick="del_customer('<?php echo $customer->id; ?>')">Delete</button>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </body>




    <div id="add_model" style="display: none">
        <h3>Add Customer</h3>

        <form id="add_form" name="add_form" method="POST">
            <label>Name:</label>
            <input type="text" name="name_text" id="name_text" value="">
            <br>
            <label>Age:</label>
            <input type="text" name="age_text" id="age_text" value="">

<!--            <input type="submit" name="add" id="add" value="Add">-->
            <button type="submit">Save changes</button>
        </form>
    </div>

</html>


<script type="text/javascript">

    $(document).ready(function () {
        
        alert(js_site_url);

        $("#add_form").validate({
            rules: {
                name: {required: true}
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: js_site_url + "my_customer/save_customer",
                    data: $('#add_form').serialize(),
                    success: function (data) {
                        alert(data);
                    }
                });
            }
        });

    });

    function view_add_customer() {
        $('#add_model').show();
    }

    function del_customer(id) {

        if (confirm("Are you sure you want to delete?")) {
            $.ajax({
                type: "POST",
                url: js_site_url + "my_customer/delete_customer",
                data: "id" + id,
                success: function (data) {
                    alert(data);
                    if (data == '1') {
                        alert("Successfully Added");
                        $('#cust_' + id).hide();
                    } else {
                        alert("Error");
                    }
                }
            });

        }
    }
</script>

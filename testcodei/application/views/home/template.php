<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CodeI</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>

        <div class="jumbotron text-center">
            <h1>Home</h1>            
        </div>

        <div class="container">
            <div class="row pull-right">
                <a type="button" href="<?php echo site_url(); ?>/home_controller/add_view" class="btn btn-primary">Add New</a>
            </div>

            <div class="row">
                <h2>All Result</h2>                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Default</td>
                            <td>Defaultson</td>
                            <td>
                                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="get_edit_content()">Edit</button>
                            </td>
                        </tr>                              
                    </tbody>
                </table>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body" id="edit_cont">
                        <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

    </body>
</html>

<script type="text/javascript">



    function get_edit_content() {

        $.ajax({
            type: "post",
            //dataType: "json",
            url: "<?php echo site_url(); ?>/home_controller/get_edit_content",
            data: {name: 'Edit Name'},
            success: function (data) {
                $('#edit_cont').html(data);
            },
            error: function (data) {
                alert("Error");
            },
        });
    }

</script>
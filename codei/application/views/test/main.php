<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Test</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script>
            var js_site_url ="<?php echo site_url(); ?>";
            var js_base_url ="<?php echo base_url(); ?>";
        </script>
    </head>
    <body>

        <div class="container">
            <h1><?php echo $page_title; ?></h1>
            <p>This is some text.</p> 

            <?php echo $content; ?>
        </div>


        <button type="button" class="btn btn-primary" onclick="clickA()">Primary</button>

        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Dropdown Example
                <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a href="#">HTML</a></li>
                <li><a href="#">CSS</a></li>
                <li><a href="#">JavaScript</a></li>
            </ul>
        </div>


        <div class="container">
            <h2>Contextual Classes</h2>
            <p>Contextual classes can be used to color table rows or table cells. The classes that can be used are: .active, .success, .info, .warning, and .danger.</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Default</td>
                        <td>Defaultson</td>
                        <td>def@somemail.com</td>
                        <td><button type="button" class="btn btn-info btn-mini" data-toggle="modal" data-target="#myModal">Open Modal</button></td>
                    </tr>      
                    <tr class="success">
                        <td>Success</td>
                        <td>Doe</td>
                        <td>john@example.com</td>
                    </tr>
                    <tr class="danger">
                        <td>Danger</td>
                        <td>Moe</td>
                        <td>mary@example.com</td>
                    </tr>
                    <tr class="info">
                        <td>Info</td>
                        <td>Dooley</td>
                        <td>july@example.com</td>
                    </tr>
                    <tr class="warning">
                        <td>Warning</td>
                        <td>Refs</td>
                        <td>bo@example.com</td>
                    </tr>
                    <tr class="active">
                        <td>Active</td>
                        <td>Activeson</td>
                        <td>act@example.com</td>
                    </tr>                   
                </tbody>
            </table>
        </div>



        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>


        <div class="container">
            <form>
                <h3><b>Form</b></h3>
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox"> Remember me</label>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>

    </body>
</html>

<script type="text/javascript">

    function clickA() {

        alert(js_site_url);

    }

</script>
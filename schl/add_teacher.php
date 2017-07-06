<link rel="stylesheet" href="<?php echo base_url(); ?>application_assets/css/croppie.css">
<script src="<?php echo base_url(); ?>application_assets/plugins/file_upload_plugin/croppie.js"></script>
<script src="<?php echo base_url(); ?>application_assets/plugins/file_upload_plugin/ajaxupload.3.5.js" type="text/javascript"></script>

<div class="row">
    <div class="col-lg-12">
        <h1><?php echo $page_title; ?></h1>
    </div>
    <div class="col-lg-8"></div>
</div>


<div class="row">
    <div class="col-lg-12 ">
        <div class="main-box no-header clearfix">
            <div class="main-box-body clearfix">
                <form name="add_teacher_form" id="add_teacher_form">
                    <div class="main-box-body clearfix">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Registration No <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" onkeyup="set_credentials('registration_no', 'user_name', 'password', 'c_password')" name="registration_no"  id="registration_no" <?php if ($is_auto_gen == '1') { ?> value="<?php echo $next_id; ?>" readonly="true"<?php } ?>/>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Date Of Joining <span style="color: red;">*</span></label>
                                <input type="text"  class="form-control datepick" name="join_date"  value="" id="join_date" readonly/>                                
                            </div>

                            <div class="form-group col-md-3">
                                <label> Branch <span style="color: red;">*</span></label>
                                <select id="branch_id" name="branch_id" class="form-control">
                                    <option value="" selected="selected">Select Branch</option>
                                    <?php foreach ($branches as $branch) { ?>
                                        <option value="<?php echo $branch->branch_id; ?>"><?php echo $branch->branch_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Category <span style="color: red;">*</span></label>
                                <select id="category_id" name="category_id" class="form-control">
                                    <option value="" selected="selected">Select Category</option>
                                    <?php foreach ($categories as $category) { ?>
                                        <option value="<?php echo $category->category_id; ?>"><?php echo $category->category; ?></option>
                                    <?php } ?>
                                </select>
                            </div> 

                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Designation <span style="color: red;">*</span></label>
                                <div id="designation_div">
                                <select id="designation_id" name="designation_id" class="form-control">
                                    <option value="" selected="selected">Select Designation</option>
                                    <?php foreach ($designations as $designation) { ?>
                                        <option value="<?php echo $designation->designation_id; ?>"><?php echo $designation->designation; ?></option>
                                    <?php } ?>
                                </select>
                                </div>
                            </div> 

                            <div class="form-group col-md-3">
                                <label>Department <span style="color: red;">*</span></label>
                                <div id="department_div">
                                <select id="department_id" name="department_id" class="form-control">
                                    <option value="" selected="selected">Select Department</option>
                                    <?php foreach ($departments as $department) { ?>
                                        <option value="<?php echo $department->dept_id; ?>"><?php echo $department->dept_name; ?></option>
                                    <?php } ?>
                                </select>
                                </div>
                            </div> 

                            <div class="form-group col-md-3">
                                <label> Staff Type <span style="color: red;">*</span></label>
                                <select id="staff_type" name="staff_type" class="form-control">
                                    <option value="" selected="selected">Select Staff</option>                
                                    <option value="TEACHER">Teacher</option>                
                                    <option value="OFFICER">Officer</option>
                                    <option value="COACH">Coach</option>
                                </select>

                                <span id="warning_container" style="color: red;"></span>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Grade Level </label>
                                <input type="text" class="form-control" name="grade_level"  id="grade_level" value="0"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>Contract Type <span style="color: red;">*</span></label>
                                <select id="contract_type_id" name="contract_type_id" class="form-control">
                                    <option value="" selected="selected">Select Contract type</option>
                                    <?php foreach ($contract_types as $contract_type) { ?>
                                        <option value="<?php echo $contract_type->contract_type_id; ?>"><?php echo $contract_type->contract_type; ?></option>
                                    <?php } ?>
                                </select>
                            </div> 

                            <div class="form-group col-md-3">
                                
                                <div class="checkbox-nice" style="vertical-align:middle;">                                       
                                    
                                    <input type="checkbox" id="chkbox" name="assigned_to_timetable" value="1" style="vertical-align:middle;">
                                    <label for="chkbox">Assign to time table</label>
                                </div>
                            </div> 
                           

                        </div>


                        <div class="tabs-wrapper">
                            <ul class="nav nav-tabs" id="tab_add_teacher">
                                <!-- Basic Details -->
                                <li class="active">
                                    <a data-toggle="tab" href="#basic_details">Personal Details</a>
                                </li>

                                <!-- Contact Details -->
                                <li>
                                    <a data-toggle="tab" href="#contact_details">Contact Info</a>
                                </li>

                                <!-- Login Details -->
                                <li>
                                    <a data-toggle="tab" href="#login_details">Login Details</a>
                                </li>

                            </ul>

                            <div class="tab-content">
                                <!-- Basic Details -->
                                <div id="basic_details" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label>First Name <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="first_name"  id="first_name"/>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Middle Name</label>
                                            <input type="text" class="form-control" name="middle_name"  id="middle_name"/>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Last Name <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="last_name"  id="last_name"/>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Name With Initials <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="initial_name"  id="initial_name"/>
                                        </div>

                                    </div>                                    
                                    <div class="row">   

                                        <div class="form-group col-md-3">
                                            <label> NIC / Passport ID <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="nic"  id="nic"/>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Date Of Birth <span style="color: red;">*</span></label>
                                            <input type="text"  class="form-control datepick" name="dob" id="dob"  readonly />                                             
                                        </div>                                        

                                        <div class="form-group col-md-3">
                                            <label>Race <span style="color: red;">*</span></label>                                            
                                            <select id="nationality" name="nationality" class="form-control">
                                                <option value="" selected="selected">Select Race</option>
                                                <?php foreach ($nationalities as $nationality) { ?>
                                                    <option value="<?php echo $nationality; ?>"><?php echo $nationality; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Religion <span style="color: red;">*</span></label>
                                            <select class="form-control" name="religion"  id="religion">
                                                <option value="" selected="selected">Select Religion</option>
                                                <?php
                                                foreach ($religions as $religion) {
                                                    ?>
                                                    <option value="<?php echo $religion; ?>" <?php if ($religion == $religion_def) { ?> selected="true"<?php } ?>><?php echo $religion; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="row">   

                                        <div class="form-group col-md-3">
                                            <label> Marital Status </label>
                                            <select id="marital_status" name="marital_status" class="form-control">
                                                <option value="" selected="selected">Select Marital Status</option>
                                                <option value="MARRIED">Married</option>
                                                <option value="UNMARRIED">Unmarried</option>
                                            </select>
                                        </div>

                                        <div class="form-group  col-md-3">
                                            <label> Blood Group <span style="color: red;">*</span></label>
                                            <select id="blood_group" name="blood_group" class="form-control">
                                                <option value="" selected="selected">Select Blood Group</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Gender <span style="color: red;">*</span></label>
                                            <div class="radio">
                                                <input id="optionsRadios1" type="radio" checked="true" value="Male" name="gender">
                                                <label for="optionsRadios1"> Male</label>

                                                <input id="optionsRadios2" type="radio" value="Female" name="gender">
                                                <label for="optionsRadios2"> Female</label>
                                            </div>
                                        </div>                                        

                                        <div class="form-group col-md-3">
                                            <label>School attend as Student </label>
                                            <input type="text" class="form-control" name="attend_school"  id="attend_school"/>
                                        </div>


                                    </div>

                                    <div class="row"> 

                                        <div class="form-group col-md-3">
                                            <label>EPF No/Pension Fund</label>
                                            <input type="text" class="form-control" name="epf_no"  id="epf_no"/>
                                        </div>
                                        
                                        <div class="form-group col-md-3">
                                        <label>Basic Salary <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="basic_salary"  id="basic_salary" onkeypress="return numbersonly(this, event, '.')"/>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Bank Paid <span style="color: red;">*</span></label>
                                        <div class="radio">
                                            <input id="optionsRadios12" type="radio" checked="true" value="1" name="bank_paid">
                                            <label for="optionsRadios12"> Yes</label>

                                            <input id="optionsRadios22" type="radio" value="0" name="bank_paid">
                                            <label for="optionsRadios22"> No</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Default Attendance <span style="color: red;">*</span></label>
                                        <div class="radio">
                                            <input id="optionsRadios13" type="radio" checked="true" value="1" name="default_attendance">
                                            <label for="optionsRadios13"> Yes</label>

                                            <input id="optionsRadios23" type="radio" value="0" name="default_attendance">
                                            <label for="optionsRadios23"> No</label>
                                        </div>
                                    </div>
                                        
                                    </div>

                                    <div class="row" id="teacher_only_div_add" style="display: none;">                                        
                                        <div class="form-group col-md-3">
                                            <label> School House </label>
                                            <select id="school_house" name="school_house" class="form-control">
                                                <option value="" selected="selected">Select School House</option>
                                                <?php foreach ($school_houses as $school_house) { ?>
                                                    <option value="<?php echo $school_house->school_house_id; ?>"><?php echo $school_house->school_house; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Class Teacher</label>
                                            <div class="radio">
                                                <input id="class_teacher_radio1" type="radio" checked="true" value="Y" name="class_teacher">
                                                <label for="class_teacher_radio1"> Yes</label>

                                                <input id="class_teacher_radio2" type="radio" value="N" name="class_teacher">
                                                <label for="class_teacher_radio2"> No</label>
                                            </div>
                                        </div>                                        
                                    </div>

                                    <div class="row">   
                                        <div class="form-group col-md-9">
                                            <label>Special Talents</label>
                                            <textarea class="form-control" name="special_talents"  id="special_talents" ></textarea>
                                        </div>
                                    </div>

                                     

                                    <div class="form-group col-md-9">

                                    </div>


                                </div>

                                <!-- Contact Details -->
                                <div id="contact_details" class="tab-pane fade in ">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Permanent Address 1 <span style="color: red;">*</span></label>
                                            <textarea class="form-control" name="permanent_address_1"  id="permanent_address_1" ></textarea>
                                        </div>


                                        <div class="form-group col-md-6">
                                            <label>Present Address 1</label>
                                            <textarea class="form-control" name="present_address_1"  id="present_address_1" ></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Street <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="permanent_street"  id="permanent_street"/>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Street</label>
                                            <input type="text" class="form-control" name="present_street"  id="present_street"/>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>City <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="permanent_city"  id="permanent_city"/>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>City </label>
                                            <input type="text" class="form-control" name="present_city"  id="present_city"/>
                                        </div>
                                    </div>


                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label>Telephone Number <span style="color: red;">*</span></label>
                                            <input type="text" onkeypress="return numbersonly(this, event, '.')" maxlength="10" class="form-control" name="home_no"  value="" id="home_no"/>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label>Mobile Number <span style="color: red;">*</span></label>
                                            <input type="text"  onkeypress="return numbersonly(this, event, '.')" maxlength="10" class="form-control" name="mobile"  value="" id="mobile"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Email <span style="color: red;">*</span></label>
                                            <input type="text"  class="form-control" name="email"  value="" id="email"/>
                                        </div>
                                    </div>                                 
                                </div>


                                <!-- Login Details -->
                                <div id="login_details" class="tab-pane fade in">

                                    <div class="row">
                                        <div class="container">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">Profile Image</div>
                                                <div class="panel-body">                                                            

                                                    <div class="row">
                                                        <div class="col-md-4 text-center">
                                                            <div id="upload-demo" style="width:300px"></div>
                                                        </div>

                                                        <div class="col-md-4" style="padding-top:30px;">
                                                            <strong>Select Image:</strong>
                                                            <br/>
                                                            <input type="file" id="upload">
                                                            <br/>
                                                            <button type="button" class="btn btn-success upload-result">Upload Image</button>
                                                        </div>

                                                        <div class="col-md-4" style="">
                                                            <div id="upload-demo-i" style="background:#e1e1e1;width:250px;padding:30px;height:250px;margin-top:30px">
                                                                <img class="img-thumbnail img-responsive" src="<?php echo base_url(); ?>uploads/profile_images/default_avatar.png"/>
                                                            </div>

                                                            <input type="hidden" name="teacher_avatar" id="teacher_avatar" value="default_avatar.png"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Username <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="user_name"  id="user_name"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Password <span style="color: red;">*</span></label>
                                            <input type="password" class="form-control" name="password"  id="password"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Confirm Password <span style="color: red;">*</span></label>
                                            <input type="password" class="form-control" name="c_password"  id="c_password"/>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Privilege Template <span style="color: red;">*</span></label>                                           
                                            <select id="user_privilege_template_id" name="user_privilege_template_id" class="form-control">
                                                <option value="" selected="selected">Select Privilege Template</option>
                                                <?php foreach ($privilege_templates as $privilege_template) { ?>
                                                    <option value="<?php echo $privilege_template->user_privilege_template_id; ?>"><?php echo $privilege_template->user_privilege_template; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group pull-right">
                                <label> </label>
                                <input class="btn btn-success" type="submit" value="Save" id="submit">
                                <input class="btn btn-danger" type="button" onclick="window.history.back();" value="Cancel">
                            </div>
                            <div id="fadeinsert" style="display: none">
                                <div class="alert alert-success">
                                    <i class="fa fa-check-circle fa-fw fa-lg"></i> 
                                    Staff saved successfully !!
                                </div>
                            </div>
                            <div class="col-lg-2"></div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $('#user_profile_menu').addClass('open');
    $('#user_profile_submenu').attr('style', 'display: block;');
    $('#manage_staff_menu').addClass('open');
    $('#manage_staff_submenu').attr('style', 'display: block;');
    $('#staff_submenu').addClass('active');

    $('#staff_type').change(function () {
        var staff_type = $('#staff_type').val();
        if (staff_type == "TEACHER") {
            $('#teacher_only_div_add').show();
        } else {
            $('#teacher_only_div_add').hide();
        }
    });

    $(document).ready(function () {

        $('.datepick').datetimepicker({
            format: 'Y-m-d',
            formatDate: 'Y-m-d',
            timepicker: false
        });

        $("#add_teacher_form").validate({
            ignore: "",
            invalidHandler: function (e, validator) {
                if (validator.errorList.length)
                    $('#tab_add_teacher a[href="#' + jQuery(validator.errorList[0].element).closest(".tab-pane").attr('id') + '"]').tab('show')
            },
            rules: {
                registration_no: {required: true},
                join_date: {required: true},
                branch_id: {required: true},
                designation_id: {required: true},
                department_id: {required: true},
                contract_type_id: {required: true},
                category_id: {required: true},
                staff_type: {required: true},
                grade_level: {
                    number: true
                },
                //basic details
                first_name: {required: true},
                last_name: {required: true},
                initial_name: {required: true},
                nic: {required: true},
                dob: {required: true},
                nationality: {required: true},
                religion: {required: true},
                blood_group: {required: true},
                gender: {required: true},
                default_attendance: {required: true},
                bank_paid: {required: true},
                basic_salary: {required: true},
                //contact details
                permanent_address_1: {required: true},
                permanent_street: {required: true},
                permanent_city: {required: true},
                home_no: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                },
                mobile: {required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                email: {
                    required: true,
                    email: true},
                //login details
                user_name: {required: true},
                password: {required: true},
                c_password: {required: true, equalTo: "#password"},
                user_privilege_template_id: {required: true},
            },
            submitHandler: function (form) {

                $('#user_name').removeClass('error').next().hide();
                var $form = $('#add_teacher_form');

                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url(); ?>/HR/teacher/add_teacher',
                    data: $form.serialize(),
                    success: function (msg) {

                        if (msg == 1) {
                            $('#fadeinsert').fadeIn();
                            $('#fadeinsert').fadeOut(4000);
                            window.location = '<?php echo site_url(); ?>/HR/teacher/manage_all_teachers';

                        } else if (msg == '3') {

                            $('#tab_add_teacher a[href="#login_details"]').tab('show');
                            $('#user_name').val("");
                            $('#user_name').addClass('error');
                            $('#user_name').after('<label class="error" generated="true">Username already exist.</label>');

                        } else {
                            alert("Error!")
                        }
                    },
                    error: function (msg) {
                        alert("Error!");
                    }

                });
            }

        });
    });

    function numbersonly(myfield, e, dec) {
        var key;
        var keychar;

        if (window.event)
            key = window.event.keyCode;
        else if (e)
            key = e.which;
        else
            return true;
        keychar = String.fromCharCode(key);

// control keys
        if ((key == null) || (key == 0) || (key == 8) ||
                (key == 9) || (key == 13) || (key == 27))
            return true;

// numbers
        else if ((("0123456789").indexOf(keychar) > -1))
            return true;

// decimal point jump
        else if (dec && (keychar == ".")) {
            myfield.form.elements[dec].focus();
            return false;
        } else {
            return false;
        }
    }


//    $(document).on('change', '#designation_id', function () {
//
//        var designation_id = $('#designation_id').val();
//
//        $.post(js_site_url + '/HR/staff/alert_staff_type', {designation_id: designation_id}, function (msg)
//        {
//            $('#warning_container').html('<label>' + msg + '</label>')
//        });
//    });


    $(document).on('change', '#category_id', function () {

        var category_id = $('#category_id').val();

        $.post(js_site_url + '/HR/staff/get_designation_for_staff_category', {category_id: category_id}, function (msg)
        {
            $('#designation_div').html(msg);
        });
        
        $.post(js_site_url + '/HR/staff/get_department_for_staff_category', {category_id: category_id}, function (msg)
        {
            $('#department_div').html(msg);
        });
    });

    function set_credentials(registration_no, username, password, c_password) {

        $('#' + username).val($('#' + registration_no).val().toUpperCase());
        $('#' + password).val($('#' + registration_no).val().toUpperCase());
        $('#' + c_password).val($('#' + registration_no).val().toUpperCase());
    }


    //image crop - square/circle
    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200, type: 'square'
        },
        boundary: {
            width: 250,
            height: 250
        }

    });


    $('#upload').on('change', function () {

        var reader = new FileReader();

        reader.onload = function (e) {
            $uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function () {
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);

    });


    $('.upload-result').on('click', function (ev) {

        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'}).then(function (resp) {
            $.ajax({
                url: js_site_url + '/HR/teacher/crop_and_save_image',
                type: "POST",
                data: {image: resp},
                success: function (data) {

                    var html = '<img src="' + resp + '" />';
                    $("#upload-demo-i").html(html);
                    $('#teacher_avatar').val(data);
                },
                error: function (msg) {
                    alert("Error!");
                }
            });
        });
    });


</script>

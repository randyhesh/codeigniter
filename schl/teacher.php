<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacher extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('SMS_LOGGED_IN')) {
            redirect(site_url() . '/login_controller');
        } else {

            $this->load->library('pagination');
            $this->load->library('pagination_custome');

            $this->load->library('encrypt');

            $this->load->model('COMMON/profile/profile_model');
            $this->load->model('COMMON/profile/profile_service');

            $this->load->model('COMMON/user/user_model');
            $this->load->model('COMMON/user/user_service');

            $this->load->model('HR/staff/staff_model');
            $this->load->model('HR/staff/staff_service');

            $this->load->model('HR/teacher/teacher_model');
            $this->load->model('HR/teacher/teacher_service');

            $this->load->model('SET/school_house/school_house_model');
            $this->load->model('SET/school_house/school_house_service');

            $this->load->model('SET/branch/branch_model');
            $this->load->model('SET/branch/branch_service');

            $this->load->model('COMMON/designation/designation_model');
            $this->load->model('COMMON/designation/designation_service');

            $this->load->model('COMMON/department/department_model');
            $this->load->model('COMMON/department/department_service');

            $this->load->model('COMMON/contract_types/contract_types_model');
            $this->load->model('COMMON/contract_types/contract_types_service');

            $this->load->model('HR/staff_category/staff_category_model');
            $this->load->model('HR/staff_category/staff_category_service');

            $this->load->model('HR/staff_talent/staff_talent_model');
            $this->load->model('HR/staff_talent/staff_talent_service');

            $this->load->model('HR/staff_dependent_children/staff_dependent_children_model');
            $this->load->model('HR/staff_dependent_children/staff_dependent_children_service');

            $this->load->model('HR/teacher_subject/teacher_subject_model');
            $this->load->model('HR/teacher_subject/teacher_subject_service');

            $this->load->model('HR/staff_experience/staff_experience_model');
            $this->load->model('HR/staff_experience/staff_experience_service');

            $this->load->model('HR/staff_qulification/staff_qulification_model');
            $this->load->model('HR/staff_qulification/staff_qulification_service');

            $this->load->model('SET/extra_curricular_coach/extra_curricular_coach_model');
            $this->load->model('SET/extra_curricular_coach/extra_curricular_coach_service');

            $this->load->model('COMMON/user_privilege_template/user_privilege_template_model');
            $this->load->model('COMMON/user_privilege_template/user_privilege_template_service');

            $this->load->model('SET/institute/institute_model');
            $this->load->model('SET/institute/institute_service');

            $this->load->model('SCHEDULE/time_table/time_table_service');

            $this->load->model('SET/branch_configuration/branch_configuration_service');

            $this->load->model('SET/grade_branch_configuration/grade_timetable_configuration_service');

            $this->load->model('SET/academic_year/academic_year_service');

            $this->load->model('LIB/lib_employee/lib_employee_service');

            $this->load->model('SET/periods/periods_service');

            $this->load->model('HR/teacher_setting/teacher_setting_model');
            $this->load->model('HR/teacher_setting/teacher_setting_service');

            $this->load->model('HR/student_assignment/student_assignment_model');
            $this->load->model('HR/student_assignment/student_assignment_service');
        }
    }

    /**
     * This is the controller function go to get all staff
     */
    function manage_all_teachers($start = "0") {

        $perm = new User_privilege_service();

        if ($perm->check_access('DISPLAY_STAFF')) {
            $staff_service = new Staff_service();
            $branch_service = new Branch_service();
            $institute_service = new Institute_service();

            $config = array();
            $config["base_url"] = site_url() . "/HR/teacher/manage_all_teachers";
            $config["total_rows"] = count($staff_service->get_all_staff('', '', $this->session->userdata('SMS_USER_BRANCH'), $this->session->userdata('SMS_USER_INSTITUTE')));
            $config["per_page"] = 10;
            $config["uri_segment"] = 4;
            $config["num_links"] = 4;
            $this->pagination->initialize($config);

            $data['page_title'] = "Manage Staff";
            $data["uri_segment"] = $config["uri_segment"];
            $data["links"] = $this->pagination->create_links();
            $data['teachers'] = $staff_service->get_all_staff($config["per_page"], $start, $this->session->userdata('SMS_USER_BRANCH'), $this->session->userdata('SMS_USER_INSTITUTE'));
            $data['branches'] = $branch_service->show_all_branches($this->session->userdata('SMS_USER_INSTITUTE'));
            $data['user_branch_id'] = $this->session->userdata('SMS_USER_BRANCH');
            $data['institutes'] = $institute_service->show_all_institutes();
            $data['user_institute'] = $this->session->userdata('SMS_USER_INSTITUTE');


            $partials = array('content' => 'HR/teacher/manage_teacher');
            $this->template->load('template/template', $partials, $data);
        } else {
            $this->template->load('template/access_denied');
        }
    }

    //Dhanushka- 2017.2.23
    //  View Staff assignment Details
    public function view_teacher_settings($profile_id) {

        $perm = new User_privilege_service();

//        if ($perm->check_access('DISPLAY_STAFF_ASSIGNMENT')) {
//        $staff_assignment_service = new Staff_assignment_service();
//        $academic_year_service = new Academic_year_service();
//        $teacher_service = new Teacher_service();
//        $branch_service = new Branch_service();
//        $section_service = new Section_service();
//        $institute_service = new Institute_service();
//        $grade_service = new Grade_service();
//        $class_service = new Class_service();
        $profile_service = new Profile_service();
        $teacher_service = new Teacher_service();
        $teacher_setting_service = new Teacher_setting_service();


        $profile_details = $profile_service->get_profile_from_profile_id($profile_id);
        $data['page_title_1'] = "Manage Settings for - " . $profile_details->first_name . " " . $profile_details->last_name;
        $data['teacher_settings'] = $teacher_setting_service->get_all_settings_for_teacher($profile_id);
        $teacher_details = $teacher_service->get_teacher_by_profile_id($profile_id);
        $data['teacher_id'] = $teacher_details->teacher_id;

        $partials = array('content' => 'HR/teacher_setting/teacher_settings');
        $this->template->load('template/template', $partials, $data);
//        } else {
//            $this->template->load('template/access_denied');
//        }
    }

    function insert_teacher_settings() {

        $perm = new User_privilege_service();
//        if ($perm->check_access('ADD_SUBJECT_SETTING')) {
        $teacher_setting_model = new Teacher_setting_model();
        $teacher_setting_service = new Teacher_setting_service();

        $teacher_setting_model->setNo_of_working_days_per_set($this->input->post('no_of_working_days_per_set'));
        $teacher_setting_model->setMax_no_of_consecutives_per_day($this->input->post('max_no_of_consecutives_per_day'));
        $teacher_setting_model->setTeacher_id($this->input->post('teacher_id'));
        $teacher_setting_model->setDel_ind('0');
        $teacher_setting_model->setAdded_by($this->session->userdata('SMS_EMPLOYEE_CODE'));
        $teacher_setting_model->setAdded_date(date('Y-m-d H:i:s'));

        echo $teacher_setting_service->insert_teacher_settings($teacher_setting_model);
//        } else {
//            $this->template->load('template/access_denied');
//        }
    }

    public function get_teacher_setting() {

        $teacher_setting_service = new Teacher_setting_service();

        $data['teacher_setting_detail'] = $teacher_setting_service->get_teacher_setting($this->input->post('teacher_setting_id'));

        echo $this->load->view('HR/teacher/update_subject_setting', $data, true);
    }

    /**
     * controller function to load staff per staff type     
     */
    function load_staff_type($start = "0") {

        $perm = new User_privilege_service();

        if ($perm->check_access('DISPLAY_STAFF')) {
            $staff_service = new Staff_service();

            $config = array();
            $config["base_url"] = site_url() . "/HR/teacher/load_staff_type";
            $config["total_rows"] = count($staff_service->get_all_staff_per_type('', '', $this->input->post('staff_type', TRUE), $this->input->post('branch_id', TRUE), $this->input->post('word', TRUE), $this->input->post('institute_id', TRUE)));
            $config["per_page"] = 10;
            $config["uri_segment"] = 4;
            $config["num_links"] = 4;
            $this->pagination_custome->initialize($config);

            $data["uri_segment"] = $config["uri_segment"];
            $data["links"] = $this->pagination_custome->create_links();
            $data['teachers'] = $staff_service->get_all_staff_per_type($config["per_page"], $start, $this->input->post('staff_type', TRUE), $this->input->post('branch_id', TRUE), $this->input->post('word', TRUE), $this->input->post('institute_id', TRUE));

            echo $this->load->view('HR/teacher/all_staff_table', $data);
        } else {
            $this->template->load('template/access_denied');
        }
    }

    function crop_and_save_image() {

        $data = $this->input->post('image', TRUE);

        //image data not coming here as shown in post in firebug,if this not working 
        //echo and check wht is captured and use str_replace to according to it
        //echo $data;
        $data = str_replace('[removed]', '', $data);

        //list($type, $data) = explode(';', $data);
        //list(, $data) = explode(',', $data);
        $data = base64_decode($data);

        $imageName = 'tea_' . time() . '.png';

        file_put_contents('./uploads/profile_images/teacher/' . $imageName, $data);

        echo $imageName;
    }

    /**
     * This is the controller function go to add teacher view
     */
    function add_teacher_view() {
        $perm = new User_privilege_service();

        if ($perm->check_access('ADD_STAFF')) {
            $branch_service = new Branch_service();
            $school_house_service = new School_house_service();
            $designation_service = new Designation_service();
            $department_service = new Department_service();
            $staff_category_service = new Staff_category_service();
            $privilege_template_service = new User_privilege_template_service();
            $setting_service = new Settings_service();
            $staff_service = new Staff_service();
            $contract_types_service = new Contract_types_service();

            $data['page_title'] = "Add New Staff";
            $data['branches'] = $branch_service->show_all_branches($this->session->userdata('SMS_USER_INSTITUTE'));
            $data['school_houses'] = $school_house_service->get_all_school_houses();
            $data['designations'] = $designation_service->show_all_designations();
            $data['departments'] = $department_service->show_all_departments();
            $data['categories'] = $staff_category_service->get_all_staff_category();
            $data['contract_types'] = $contract_types_service->show_all_contract_types();

            //registration no auto gen
            $data['is_auto_gen'] = $setting_service->get_default_value_by_parameter('IS_REGISTRATION_NO_AUTO_GEN', $this->session->userdata('SMS_USER_BRANCH'));
            $last_reg_no = $staff_service->get_last_registration_no();
            if (empty($last_reg_no)) {
                $next_id = 'R1001';
            } else {
                $last_reg_no = substr($last_reg_no->registration_no, 1); // get remaining nos except R
                $next_id = 'R' . ($last_reg_no + 1);
            }
            $data['next_id'] = $next_id;

            $data['religion_def'] = $setting_service->get_default_value_by_parameter('RELIGIONS', $this->session->userdata('SMS_USER_BRANCH'));
            $religions_con = $setting_service->get_values_by_parameter('RELIGIONS');
            $religions = array();
            foreach ($religions_con as $religion) {

                $religions[] = $religion->param_value;
            }
            $data['religions'] = $religions;

            $nationality_list = $setting_service->get_values_by_parameter('NATIONALITY');
            $nationalities = array();
            foreach ($nationality_list as $nationality) {

                $nationalities[] = $nationality->param_value;
            }
            $data['nationalities'] = $nationalities;

            $data['privilege_templates'] = $privilege_template_service->get_all_privilege_templates();

            $partials = array('content' => 'HR/teacher/add_teacher');
            $this->template->load('template/template', $partials, $data);
        } else {
            $this->template->load('template/access_denied');
        }
    }

    /**
     * This is the controller function to add a teacher
     */
    function add_teacher() {
        $perm = new User_privilege_service();

        if ($perm->check_access('ADD_STAFF')) {

            $profile_model = new Profile_model();
            $profile_service = new Profile_service();
            $user_model = new User_model();
            $user_service = new User_service();
            $staff_model = new Staff_model();
            $staff_service = new Staff_service();
            $teacher_model = new Teacher_model();
            $teacher_service = new Teacher_service();
            $staff_talent_model = new Staff_talent_model();
            $staff_talent_service = new Staff_talent_service();

            $check_user = $user_service->check_username($this->input->post('user_name', TRUE));

            if (empty($check_user)) {

                $this->db->trans_start();

                //profile
                $profile_model->setBranch_id($this->input->post('branch_id', TRUE));
                $profile_model->setProfile_type("STAFF");
                $profile_model->setProfile_image($this->input->post('teacher_avatar', TRUE));
                $profile_model->setNic($this->input->post('nic', TRUE));
                $profile_model->setDob($this->input->post('dob', TRUE));
                $profile_model->setName_with_initial($this->input->post('initial_name', TRUE));
                $profile_model->setFirst_name($this->input->post('first_name', TRUE));
                $profile_model->setMiddle_name($this->input->post('middle_name', TRUE));
                $profile_model->setLast_name($this->input->post('last_name', TRUE));
                $profile_model->setMobile($this->input->post('mobile', TRUE));
                $profile_model->setHome_phone($this->input->post('home_no', TRUE));
                $profile_model->setEmail($this->input->post('email', TRUE));
                $profile_model->setCity($this->input->post('city', TRUE));
                $profile_model->setPermanent_address_1($this->input->post('permanent_address_1', TRUE));

                //if present_address_1 is empty add permanent_address_1 to present address column
                if ($this->input->post('present_address_1', TRUE) == "") {
                    $profile_model->setPresent_address_1($this->input->post('permanent_address_1', TRUE));
                } else {
                    $profile_model->setPresent_address_1($this->input->post('present_address_1', TRUE));
                }

                $profile_model->setGender($this->input->post('gender', TRUE));
                $profile_model->setNationality($this->input->post('nationality', TRUE));
                $profile_model->setReligion($this->input->post('religion', TRUE));
                $profile_model->setDel_ind('0');
                $profile_model->setAdded_date(date('Y-m-d H:i:s'));
                $profile_model->setAdded_by($this->session->userdata('SMS_EMPLOYEE_CODE'));

                $profile_id = $profile_service->add_new_profile($profile_model);

                //user
                $user_model->setProfile_id($profile_id);
                $user_model->setUser_privilege_template_id($this->input->post('user_privilege_template_id', TRUE));
                $user_model->setUser_type("USER");
                $user_model->setUser_name($this->input->post('user_name', TRUE));
                $user_model->setUser_pass(md5($this->input->post('password', TRUE)));
                $user_model->setActive('1');
                $user_model->setDel_ind('0');
                $user_model->setAdded_date(date('Y-m-d H:i:s'));
                $user_model->setAdded_by($this->session->userdata('SMS_EMPLOYEE_CODE'));

                $user_id = $user_service->add_new_user($user_model);

                $basic_salary = $this->encrypt->encode($this->input->post('basic_salary', TRUE));

                //staff
                $staff_model->setProfile_id($profile_id);
                $staff_model->setDesignation_id($this->input->post('designation_id', TRUE));
                $staff_model->setCategory_id($this->input->post('category_id', TRUE));
                $staff_model->setDepartment_id($this->input->post('department_id', TRUE));
                $staff_model->setContract_type_id($this->input->post('contract_type_id', TRUE));
                $staff_model->setAssigned_to_timetable($this->input->post('assigned_to_timetable', TRUE));
                $staff_model->setStaff_type($this->input->post('staff_type', TRUE));
                $staff_model->setMarital_status($this->input->post('marital_status', TRUE));
                $staff_model->setGrade_level($this->input->post('grade_level', TRUE));
                $staff_model->setRegistration_no($this->input->post('registration_no', TRUE));
                $staff_model->setBlood_group($this->input->post('blood_group', TRUE));
                $staff_model->setReligion($this->input->post('religion', TRUE));
                $staff_model->setEpf_no($this->input->post('epf_no', TRUE));
                $staff_model->setAttend_school($this->input->post('attend_school', TRUE));
                $staff_model->setJoin_date($this->input->post('join_date', TRUE));
                $staff_model->setBasic_salary($basic_salary);
                $staff_model->setBank_paid($this->input->post('bank_paid', TRUE));
                $staff_model->setDefault_attendance($this->input->post('default_attendance', TRUE));
                $staff_model->setActive('1');
                $staff_model->setDel_ind('0');
                $staff_model->setAdded_by($this->session->userdata('SMS_EMPLOYEE_CODE'));
                $staff_model->setAdded_date(date('Y-m-d H:i:s'));
                $staff_model->setPermanent_street($this->input->post('permanent_street', TRUE));
                $staff_model->setPermanent_city($this->input->post('permanent_city', TRUE));
                $staff_model->setPresent_street($this->input->post('present_street', TRUE));
                $staff_model->setPresent_city($this->input->post('present_city', TRUE));

                $staff_id = $staff_service->insert_staff($staff_model);

                //staff_talent
                $staff_talent_model->setStaff_id($staff_id);
                $staff_talent_model->setStaff_talent($this->input->post('special_talents', TRUE));
                $staff_talent_model->setDel_ind('0');
                $staff_talent_model->setAdded_by($this->session->userdata('SMS_EMPLOYEE_CODE'));
                $staff_talent_model->setAdded_date(date('Y-m-d H:i:s'));

                $talent_msg = $staff_talent_service->insert_staff_talent($staff_talent_model);

                if ($this->input->post('staff_type', TRUE) == "TEACHER") {
                    //teacher
                    $teacher_model->setStaff_id($staff_id);
                    $teacher_model->setHouse_id($this->input->post('school_house', TRUE));
                    $teacher_model->setActive('1');
                    $teacher_model->setClass_teacher($this->input->post('class_teacher', TRUE));
                    $teacher_model->setDel_ind('0');
                    $teacher_model->setAdded_by($this->session->userdata('SMS_EMPLOYEE_CODE'));
                    $teacher_model->setAdded_date(date('Y-m-d H:i:s'));

                    $msg = $teacher_service->insert_teacher($teacher_model);
                }

                //2016-07-07 varuna - - insert data to lcs_employee & hr_employee_info - - payroll data START - - 
                //- - lcs_employee - -
                $datapayroll['Employee_Code'] = $profile_id;
                $datapayroll['employee_no'] = $this->input->post('registration_no', TRUE);
                $datapayroll['Employee_Name'] = $this->input->post('first_name', TRUE);
                $datapayroll['last_name'] = $this->input->post('last_name', TRUE);
                $datapayroll['full_name'] = $this->input->post('initial_name', TRUE);
                $datapayroll['Designation'] = $this->input->post('designation_id', TRUE);
                $datapayroll['Email'] = $this->input->post('email', TRUE);
                $datapayroll['Password'] = md5($this->input->post('password', TRUE));
                $datapayroll['birthday'] = $this->input->post('dob', TRUE);
                $datapayroll['nic'] = $this->input->post('nic', TRUE);
                if ($this->input->post('gender', TRUE) == "Male") {
                    $datapayroll['gender'] = "M";
                } else {
                    $datapayroll['gender'] = "F";
                }
                if ($this->input->post('marital_status', TRUE) == "UNMARRIED") {
                    $datapayroll['marital_status'] = "U";
                } else {
                    $datapayroll['marital_status'] = "M";
                }
//                $datapayroll['marital_status'] = $this->input->post('marital_status', TRUE);
                $datapayroll['address1'] = $this->input->post('permanent_address_1', TRUE);
                //if present_address_1 is empty add permanent_address_1 to present address column
                if ($this->input->post('present_address_1', TRUE) == "") {
                    $datapayroll['address2'] = $this->input->post('permanent_address_1', TRUE);
                } else {
                    $datapayroll['address2'] = $this->input->post('present_address_1', TRUE);
                }
                if ($this->input->post('permanent_city', TRUE) != "") {
                    $datapayroll['city'] = $this->input->post('permanent_city', TRUE);
                } else {
                    $datapayroll['city'] = $this->input->post('present_city', TRUE);
                }
                $datapayroll['mobile_no'] = $this->input->post('mobile', TRUE);
                $datapayroll['joined_date'] = $this->input->post('join_date', TRUE);
                $datapayroll['contract_type'] = $this->input->post('category_id', TRUE);
                $datapayroll['Status'] = '1';
                $datapayroll['added_by'] = $this->session->userdata('SMS_EMPLOYEE_CODE');
                $datapayroll['added_date'] = date('Y-m-d H:i:s');
                $datapayroll['Confirmation_Code'] = '0';
                $datapayroll['phone_extension'] = '0';
                $datapayroll['emp_cat_id'] = $this->input->post('category_id', TRUE);
                $datapayroll['mail_server'] = '0';
                $datapayroll['roster_id'] = '0';
                $datapayroll['company_id'] = $this->session->userdata('SMS_USER_INSTITUTE');
                $datapayroll['preferred_welcome_sys'] = '0';
                $datapayroll['resigned_date'] = '0000-00-00';
                $datapayroll['emp_image'] = '';
                $datapayroll['updated_by'] = $this->session->userdata('SMS_EMPLOYEE_CODE');
                $datapayroll['updated_date'] = date('Y-m-d H:i:s');
                //- - lcs_employee - -
                // - - hr_employee_info - -
                $datapayroll_hr_emp_info['employee_info_id'] = $profile_id;
                $datapayroll_hr_emp_info['Employee_Code'] = $profile_id;
                $datapayroll_hr_emp_info['basic_salary'] = $this->encrypt->encode($this->input->post('basic_salary', TRUE));
                $datapayroll_hr_emp_info['ot_entitle'] = 'N';
                $datapayroll_hr_emp_info['bank_paid'] = 'Y';
                $datapayroll_hr_emp_info['payroll_employee'] = '0';
                $datapayroll_hr_emp_info['payroll_added_date'] = $this->input->post('join_date', TRUE);
                $datapayroll_hr_emp_info['payroll_remove_date'] = '0000-00-00';
                $datapayroll_hr_emp_info['meal_deduct'] = 'Y';
                $datapayroll_hr_emp_info['default_attendance'] = 'N';
                $datapayroll_hr_emp_info['payeTax'] = 'MONTH';
                $datapayroll_hr_emp_info['del_ind'] = '0';
                $datapayroll_hr_emp_info['added_by'] = $this->session->userdata('SMS_EMPLOYEE_CODE');
                $datapayroll_hr_emp_info['added_date'] = date('Y-m-d H:i:s');
                $datapayroll_hr_emp_info['updated_by'] = $this->session->userdata('SMS_EMPLOYEE_CODE');
                $datapayroll_hr_emp_info['updated_on'] = date('Y-m-d H:i:s');
                // - - hr_employee_info - -
                $teacher_service->insert_payroll_data($datapayroll, $datapayroll_hr_emp_info);

                //2016-07-07 varuna - - insert data to lcs_employee & hr_employee_info - - payroll data END - -
                $this->db->trans_complete();
                echo $talent_msg;
            } else {

                //username already exist
                echo '3';
            }
        } else {
            $this->template->load('template/access_denied');
        }
    }

    /**
     * This is the controller function to upload a profile pic for teacher
     */
    function upload_teacher_avatar() {

        $uploaddir = './uploads/profile_images/teacher/';
        $unique_tag = 'tea_';

        $filename = $unique_tag . time() . '-' . basename($_FILES['uploadfile_tea']['name']); //this is the file name
        $file = $uploaddir . $filename; // this is the full path of the uploaded file

        if (move_uploaded_file($_FILES['uploadfile_tea']['tmp_name'], $file)) {
            echo $filename;
        } else {
            echo "error";
        }
    }

    /**
     * controller function to go to teacher edit view     
     */
    function edit_teacher_view($teacher_id) {

        $perm = new User_privilege_service();

        if ($perm->check_access('EDIT_STAFF')) {

            $branch_service = new Branch_service();
            $school_house_service = new School_house_service();
            $designation_service = new Designation_service();
            $department_service = new Department_service();
            $staff_category_service = new Staff_category_service();
            $teacher_service = new Teacher_service();
            $privilege_template_service = new User_privilege_template_service();
            $setting_service = new Settings_service();
            $contract_types_service = new Contract_types_service();

            $data['page_title'] = "Edit Teacher";
            $data['branches'] = $branch_service->show_all_branches($this->session->userdata('SMS_USER_INSTITUTE'));
            $data['school_houses'] = $school_house_service->get_all_school_houses();
            $data['categories'] = $staff_category_service->get_all_staff_category();
            $data['contract_types'] = $contract_types_service->show_all_contract_types();

            $teacher = $teacher_service->get_teacher($teacher_id);
            $basic_salary = 0.00;
            if (!empty($teacher->basic_salary)) {
                $basic_salary = $this->encrypt->decode($teacher->basic_salary);
            }

            $data['basic_salary'] = $basic_salary;
            $data['teacher'] = $teacher;
            $data['departments'] = $department_service->get_department_for_staff_category($data['teacher']->category_id);
            $data['designations'] = $designation_service->get_designation_for_staff_category($data['teacher']->category_id);

            $data['religion_def'] = $setting_service->get_default_value_by_parameter('RELIGIONS', $this->session->userdata('SMS_USER_BRANCH'));
            $religions_con = $setting_service->get_values_by_parameter('RELIGIONS');
            $religions = array();
            foreach ($religions_con as $religion) {

                $religions[] = $religion->param_value;
            }
            $data['religions'] = $religions;

            $nationality_list = $setting_service->get_values_by_parameter('NATIONALITY');
            $nationalities = array();
            foreach ($nationality_list as $nationality) {

                $nationalities[] = $nationality->param_value;
            }
            $data['nationalities'] = $nationalities;

            $data['privilege_templates'] = $privilege_template_service->get_all_privilege_templates();

            $partials = array('content' => 'HR/teacher/edit_teacher');
            $this->template->load('template/template', $partials, $data);
        } else {
            $this->template->load('template/access_denied');
        }
    }

    /**
     * controller function to update a teacher if staff type is teacher, 
     * else only update staff
     */
    function edit_teacher() {

        $perm = new User_privilege_service();

        if ($perm->check_access('EDIT_STAFF')) {
            $profile_model = new Profile_model();
            $profile_service = new Profile_service();
            $user_model = new User_model();
            $user_service = new User_service();
            $staff_model = new Staff_model();
            $staff_service = new Staff_service();
            $teacher_model = new Teacher_model();
            $teacher_service = new Teacher_service();
            $staff_talent_model = new Staff_talent_model();
            $staff_talent_service = new Staff_talent_service();

            $this->db->trans_start();

            //profile
            $profile_model->setProfile_id($this->input->post('profile_id', TRUE));
            $profile_model->setBranch_id($this->input->post('branch_id', TRUE));
            $profile_model->setProfile_type("STAFF");
            $profile_model->setProfile_image($this->input->post('teacher_avatar', TRUE));
            $profile_model->setNic($this->input->post('nic', TRUE));
            $profile_model->setDob($this->input->post('dob', TRUE));
            $profile_model->setName_with_initial($this->input->post('initial_name', TRUE));
            $profile_model->setFirst_name($this->input->post('first_name', TRUE));
            $profile_model->setMiddle_name($this->input->post('middle_name', TRUE));
            $profile_model->setLast_name($this->input->post('last_name', TRUE));
            $profile_model->setMobile($this->input->post('mobile', TRUE));
            $profile_model->setHome_phone($this->input->post('home_no', TRUE));
            $profile_model->setEmail($this->input->post('email', TRUE));
            $profile_model->setCity($this->input->post('city', TRUE));
            $profile_model->setPermanent_address_1($this->input->post('permanent_address_1', TRUE));

            //if present_address_1 is empty add permanent_address_1 to present address column
            if ($this->input->post('present_address_1', TRUE) == "") {
                $profile_model->setPresent_address_1($this->input->post('permanent_address_1', TRUE));
            } else {
                $profile_model->setPresent_address_1($this->input->post('present_address_1', TRUE));
            }

            $profile_model->setGender($this->input->post('gender', TRUE));
            $profile_model->setNationality($this->input->post('nationality', TRUE));
            $profile_model->setReligion($this->input->post('religion', TRUE));
            $profile_model->setDel_ind('0');
            $profile_model->setUpdate_date(date('Y-m-d H:i:s'));
            $profile_model->setUpdate_by($this->session->userdata('SMS_EMPLOYEE_CODE'));

            $profile_updated = $profile_service->update_profile($profile_model);

            $staff_type = "";
            if ($this->input->post('staff_type', TRUE) == 'Teacher') {
                $staff_type = "TEACHER";
            }
            if ($this->input->post('staff_type', TRUE) == 'Officer') {
                $staff_type = "OFFICER";
            }
            if ($this->input->post('staff_type', TRUE) == 'Coach') {
                $staff_type = "COACH";
            }

            //user  
            $user_model->setUser_privilege_template_id($this->input->post('user_privilege_template_id', TRUE));
            $user_model->setUser_id($this->input->post('user_id', TRUE));
            $user_model->setUser_name($this->input->post('user_name', TRUE));

            if ($this->input->post('c_old_password') == '0') {
                //didn't change password
                $user_model->setUser_pass($this->input->post('old_password', TRUE));
            } else {
                //password changed
                $user_model->setUser_pass(md5($this->input->post('password', TRUE)));
            }

            $user_model->setUpdate_date(date('Y-m-d H:i:s'));
            $user_model->setUpdate_by($this->session->userdata('SMS_EMPLOYEE_CODE'));

            $user_updated = $user_service->update_user_details($user_model);

            $basic_salary = $this->encrypt->encode($this->input->post('basic_salary', TRUE));

            //staff        
            $staff_model->setStaff_id($this->input->post('staff_id', TRUE));
            $staff_model->setDesignation_id($this->input->post('designation_id', TRUE));
            $staff_model->setCategory_id($this->input->post('category_id', TRUE));
            $staff_model->setDepartment_id($this->input->post('department_id', TRUE));
            $staff_model->setContract_type_id($this->input->post('contract_type_id', TRUE));
            $staff_model->setAssigned_to_timetable($this->input->post('assigned_to_timetable', TRUE));
            $staff_model->setStaff_type($staff_type);
            $staff_model->setMarital_status($this->input->post('marital_status', TRUE));
            $staff_model->setGrade_level($this->input->post('grade_level', TRUE));
            $staff_model->setRegistration_no($this->input->post('registration_no', TRUE));
            $staff_model->setBlood_group($this->input->post('blood_group', TRUE));
            $staff_model->setReligion($this->input->post('religion', TRUE));
            $staff_model->setEpf_no($this->input->post('epf_no', TRUE));
            $staff_model->setAttend_school($this->input->post('attend_school', TRUE));
            $staff_model->setJoin_date($this->input->post('join_date', TRUE));
            $staff_model->setBasic_salary($basic_salary);
            $staff_model->setBank_paid($this->input->post('bank_paid', TRUE));
            $staff_model->setDefault_attendance($this->input->post('default_attendance', TRUE));
            $staff_model->setUpdate_by($this->session->userdata('SMS_EMPLOYEE_CODE'));
            $staff_model->setUpdate_date(date('Y-m-d H:i:s'));
            $staff_model->setPermanent_street($this->input->post('permanent_street', TRUE));
            $staff_model->setPermanent_city($this->input->post('permanent_city', TRUE));
            $staff_model->setPresent_street($this->input->post('present_street', TRUE));
            $staff_model->setPresent_city($this->input->post('present_city', TRUE));

            $staff_updated = $staff_service->update_staff($staff_model);

            //staff_talent
            $staff_talent_model->setStaff_talent_id($this->input->post('staff_talent_id', TRUE));
            $staff_talent_model->setStaff_talent($this->input->post('special_talents', TRUE));
            $staff_talent_model->setUpdated_by($this->session->userdata('SMS_EMPLOYEE_CODE'));
            $staff_talent_model->setUpdated_date(date('Y-m-d H:i:s'));

            $staff_talent_updated = $staff_talent_service->update_staff_talent($staff_talent_model);

            if ($this->input->post('staff_type', TRUE) == "Teacher") {
                //teacher
                $teacher_model->setTeacher_id($this->input->post('teacher_id', TRUE));
                $teacher_model->setHouse_id($this->input->post('school_house', TRUE));
                $teacher_model->setClass_teacher($this->input->post('class_teacher', TRUE));
                $teacher_model->setUpdate_by($this->session->userdata('SMS_EMPLOYEE_CODE'));
                $teacher_model->setUpdate_date(date('Y-m-d H:i:s'));

                $teacher_updated = $teacher_service->update_teacher($teacher_model);
            }

            //2016-07-08 varuna - - update data to lcs_employee & hr_employee_info - - payroll data START - - 
            //- - lcs_employee - -
            $datapayroll['Employee_Code'] = $this->input->post('profile_id', TRUE);
            $datapayroll['employee_no'] = $this->input->post('registration_no', TRUE);
            $datapayroll['Employee_Name'] = $this->input->post('first_name', TRUE);
            $datapayroll['last_name'] = $this->input->post('last_name', TRUE);
            $datapayroll['full_name'] = $this->input->post('initial_name', TRUE);
            $datapayroll['Designation'] = $this->input->post('designation_id', TRUE);
            $datapayroll['Email'] = $this->input->post('email', TRUE);
            $datapayroll['Password'] = md5($this->input->post('password', TRUE));
            $datapayroll['birthday'] = $this->input->post('dob', TRUE);
            $datapayroll['nic'] = $this->input->post('nic', TRUE);
            if ($this->input->post('gender', TRUE) == "Male") {
                $datapayroll['gender'] = "M";
            } else {
                $datapayroll['gender'] = "F";
            }
            if ($this->input->post('marital_status', TRUE) == "UNMARRIED") {
                $datapayroll['marital_status'] = "U";
            } else {
                $datapayroll['marital_status'] = "M";
            }
            $datapayroll['address1'] = $this->input->post('permanent_address_1', TRUE);
            //if present_address_1 is empty add permanent_address_1 to present address column
            if ($this->input->post('present_address_1', TRUE) == "") {
                $datapayroll['address2'] = $this->input->post('permanent_address_1', TRUE);
            } else {
                $datapayroll['address2'] = $this->input->post('present_address_1', TRUE);
            }
            if ($this->input->post('permanent_city', TRUE) != "") {
                $datapayroll['city'] = $this->input->post('permanent_city', TRUE);
            } else {
                $datapayroll['city'] = $this->input->post('present_city', TRUE);
            }
//                $datapayroll['city'] = $this->input->post('permanent_city', TRUE);
//                $datapayroll['present_city'] = $this->input->post('present_city', TRUE);
            $datapayroll['mobile_no'] = $this->input->post('mobile', TRUE);
            $datapayroll['joined_date'] = $this->input->post('join_date', TRUE);
            $datapayroll['contract_type'] = $this->input->post('category_id', TRUE);
            $datapayroll['Status'] = '1';
            $datapayroll['added_by'] = $this->session->userdata('SMS_EMPLOYEE_CODE');
            $datapayroll['added_date'] = date('Y-m-d H:i:s');
            $datapayroll['Confirmation_Code'] = '0';
            $datapayroll['phone_extension'] = '0';
            $datapayroll['emp_cat_id'] = '0';
            $datapayroll['mail_server'] = '0';
            $datapayroll['roster_id'] = '0';
            $datapayroll['company_id'] = '0';
            $datapayroll['preferred_welcome_sys'] = '0';
            $datapayroll['resigned_date'] = '0000-00-00';
            $datapayroll['emp_image'] = '';
            $datapayroll['updated_by'] = $this->session->userdata('SMS_EMPLOYEE_CODE');
            $datapayroll['updated_date'] = date('Y-m-d H:i:s');
            //- - lcs_employee - -
            // - - hr_employee_info - -
            $datapayroll_hr_emp_info['employee_info_id'] = $this->input->post('profile_id', TRUE);
            $datapayroll_hr_emp_info['Employee_Code'] = $this->input->post('profile_id', TRUE);
            $datapayroll_hr_emp_info['basic_salary'] = $this->encrypt->encode($this->input->post('basic_salary', TRUE));
            $datapayroll_hr_emp_info['ot_entitle'] = 'N';
            $datapayroll_hr_emp_info['bank_paid'] = 'Y';
            $datapayroll_hr_emp_info['payroll_employee'] = '0';
            $datapayroll_hr_emp_info['payroll_added_date'] = $this->input->post('join_date', TRUE);
            $datapayroll_hr_emp_info['payroll_remove_date'] = '0000-00-00';
            $datapayroll_hr_emp_info['meal_deduct'] = 'Y';
            $datapayroll_hr_emp_info['default_attendance'] = 'N';
            $datapayroll_hr_emp_info['payeTax'] = 'MONTH';
            $datapayroll_hr_emp_info['del_ind'] = '0';
            $datapayroll_hr_emp_info['added_by'] = $this->session->userdata('SMS_EMPLOYEE_CODE');
            $datapayroll_hr_emp_info['added_date'] = date('Y-m-d H:i:s');
            $datapayroll_hr_emp_info['updated_by'] = $this->session->userdata('SMS_EMPLOYEE_CODE');
            $datapayroll_hr_emp_info['updated_on'] = date('Y-m-d H:i:s');
            // - - hr_employee_info - -
            $teacher_service->update_payroll_data($datapayroll, $datapayroll_hr_emp_info);

            //2016-07-08 varuna - - update data to lcs_employee & hr_employee_info - - payroll data START - -

            $this->db->trans_complete();

            if (($profile_updated == 1) && ($user_updated == 1) && ($staff_updated == 1) && ($staff_talent_updated == 1)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $this->template->load('template/access_denied');
        }
    }

    function check_passwords() {

        $old_pw = $this->input->post('old_password', TRUE);
        $confirm_old_pw = md5($this->input->post('c_old_pw', TRUE));

        if ($old_pw == $confirm_old_pw) {
            echo 1;
        } else {
            echo 0;
        }
    }

    /**
     * controller function to delete a teacher
     */
    function delete_teacher() {
        $perm = new User_privilege_service();

        if ($perm->check_access('DELETE_STAFF')) {

            $profile_service = new Profile_service();
            $user_service = new User_service();
            $staff_service = new Staff_service();
            $teacher_service = new Teacher_service();
            $staff_talent_service = new Staff_talent_service();

            $this->db->trans_start();

            //profile
            $profile_deleted = $profile_service->delete_profile($this->input->post('profile_id', TRUE));

            //user
            $user_deleted = $user_service->delete_user($this->input->post('user_id', TRUE));

            //staff
            $staff_deleted = $staff_service->delete_staff($this->input->post('staff_id', TRUE));

            //special talent
            $staff_talent_service->delete_staff_talent($this->input->post('staff_id', TRUE));

            //teacher
            $teacher_deleted = $teacher_service->delete_teacher($this->input->post('teacher_id', TRUE));

            //2016-07-08 varuna delete data from lcs_employee & hr_employee_info
            $teacher_service->delete_payroll_data($this->input->post('profile_id', TRUE));


            $this->db->trans_complete();

            if (($profile_deleted == 1) && ($user_deleted == 1) && ($staff_deleted == 1) && ($teacher_deleted == 1)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $this->template->load('template/access_denied');
        }
    }

    /**
     * controller function to go to teacher profile view
     */
    function teacher_profile_view($teacher_id, $staff_id) {

        $teacher_service = new Teacher_service();
        $staff_dependent_children_service = new Staff_dependent_children_service();
        $teacher_subject_service = new Teacher_subject_service();
        $staff_experience_service = new Staff_experience_service();
        $staff_qulification_service = new Staff_qulification_service();
        $extra_curricular_coach_service = new Extra_curricular_coach_service();
        $setting_service = new Settings_service();
        $branch_configuration_service = new Branch_configuration_service();

        $data['page_title'] = "Staff Profile";
        $data['teacher_id'] = $teacher_id;
        $data['staff_id'] = $staff_id;
        $data['teacher'] = $teacher_service->get_all_teacher_details($teacher_id);
        $data['children'] = $staff_dependent_children_service->get_staff_dependent_children($staff_id);
        $data['teacher_subjects'] = $teacher_subject_service->get_all_teacher_subjects($teacher_id);
        $data['work_exp_result'] = $staff_experience_service->get_teacher_work_experiences($staff_id);
        $data['qualification_list'] = $staff_qulification_service->get_staff_qualifications($staff_id);
        $data['activities'] = $extra_curricular_coach_service->get_extra_curricular_activities($staff_id);
        //teacher time table
        $data['config_list'] = $branch_configuration_service->get_branch_configuration_for_branch($this->session->userdata('SMS_USER_BRANCH'));
        $data['branch_id'] = $this->session->userdata('SMS_USER_BRANCH');
        $data['academic_year_id'] = $this->session->userdata('SMS_ACADEMIC_YEAR_ID');

        $data['religion_def'] = $setting_service->get_default_value_by_parameter('RELIGIONS', $this->session->userdata('SMS_USER_BRANCH'));
        $religions_con = $setting_service->get_values_by_parameter('RELIGIONS');
        $religions = array();
        foreach ($religions_con as $religion) {

            $religions[] = $religion->param_value;
        }
        $data['religions'] = $religions;

        $partials = array('content' => 'HR/teacher/teacher_profile');
        $this->template->load('template/template', $partials, $data);
    }

    function change_active_status() {

        $data['staff_id'] = $this->input->post('staff_id', TRUE);
        $data['teacher_id'] = $this->input->post('teacher_id', TRUE);
        echo $this->load->view('HR/teacher/change_status', $data);
    }

    function update_resign_date() {

        $perm = new User_privilege_service();

        if ($perm->check_access('EDIT_STAFF')) {
            $staff_model = new Staff_model();
            $staff_service = new Staff_service();

            $staff_model->setActive('0');
            $staff_model->setResign_date($this->input->post('resign_date', TRUE));
            $staff_model->setReason_for_leaving($this->input->post('leaving_reason', TRUE));
            $staff_model->setResign_letter_issue_date($this->input->post('resign_letter_issue_date', TRUE));
            $staff_model->setStaff_id($this->input->post('staff_id', TRUE));
            
            $staff_person = $staff_service->get_staff($this->input->post('staff_id', TRUE));
            $msg = $staff_service->update_resign_data($staff_model);
            //&& $staff_service->update_resign_data_history($staff_model,$staff_person);

            if ($this->input->post('teacher_id', TRUE) != '') {
                $teacher_service = new Teacher_service();
                $teacher_service->update_active_status($this->input->post('teacher_id', TRUE));
            }

            echo $msg;
        } else {
            $this->template->load('template/access_denied');
        }
    }

    function get_teachers_for_subject() {

        $setting_service = new Settings_service();
        $teacher_service = new Teacher_service();
        $lib_employee_service = new Lib_employee_service();

        //subject is a library period, so as the subject teacher have to get lib employees
//        $lib_emps = $lib_employee_service->get_lib_emps_for_subject($this->input->post('subject_id', TRUE));
        $lib_emps = $lib_employee_service->get_all_lib_employees($this->input->post('subject_id', TRUE), $this->input->post('branch_id', TRUE));

        if (empty($lib_emps)) {
            //subject is not a library period
            $teachers = $teacher_service->get_teachers_for_subject($this->input->post('subject_id', TRUE), $this->input->post('branch_id', TRUE));

            $day_id = $this->input->post('day_id', TRUE);
            $periods_id = $this->input->post('period_id', TRUE);
            $academic_year_id = $this->input->post('academic_year_id', TRUE);
            ?>

            <select id="teacher_id" name="teacher_id" class="form-control">   
                <option value="" selected="selected">Select Teacher</option>

                <?php
                foreach ($teachers as $teacher) {

                    $time_table_service = new Time_table_service();
                    $teacher_count = $time_table_service->get_class_subject_teacher($teacher->teacher_id, $day_id, $periods_id, $academic_year_id);

                    $working_periods = $time_table_service->get_teacher_working_period_count($teacher->teacher_id, $academic_year_id);
                    $default_periods = $setting_service->get_default_value_by_parameter('DEFAULT_NO_OF_PERIODS_TEACHER', $this->session->userdata('SMS_USER_BRANCH'));
                    $remaining_periods = $default_periods - $working_periods;

                    if (($teacher_count == 0) && ($remaining_periods > 0)) {
                        ?>
                        <option value="<?php echo $teacher->teacher_id; ?>"><?php echo ucfirst($teacher->first_name . ' ' . $teacher->last_name) . ' #' . $teacher->registration_no . ' | ' . $remaining_periods; ?></option>
                        <?php
                    }
                }
                ?>
            </select>

            <?php
        } else {
            //subject is a library period
            ?>
            <select id="teacher_id" name="teacher_id" class="form-control">   
                <option value="" selected="selected">Select Teacher</option>
                <?php
                foreach ($lib_emps as $lib_emp) {
                    ?>
                    <option value="<?php echo $lib_emp->teacher_id; ?>"><?php echo ucfirst($lib_emp->first_name . ' ' . $lib_emp->last_name) . ' #' . $lib_emp->registration_no . ' | ' . $lib_emp->library_name; ?></option>
                    <?php
                }
                ?>
            </select>
            <?php
        }
    }
    
    /*
 * kasun
 * 16.05.2017
 * 
 */

    function regenerate_staff_password($start = "0") {

        $perm = new User_privilege_service();

        if ($perm->check_access('GENERATE_STAFF_PASSWORDS')) {
            $staff_service = new Staff_service();
            $branch_service = new Branch_service();
            $institute_service = new Institute_service();

            $config = array();
            $config["base_url"] = site_url() . "/HR/teacher/regenerate_staff_password";
            $config["total_rows"] = count($staff_service->get_all_staff('', '', $this->session->userdata('SMS_USER_BRANCH'), $this->session->userdata('SMS_USER_INSTITUTE')));
            $config["per_page"] = 10;
            $config["uri_segment"] = 4;
            $config["num_links"] = 4;
            $this->pagination->initialize($config);

            $data['page_title'] = "Regenerate Login Passwords for Staff";
            $data["uri_segment"] = $config["uri_segment"];
            $data["links"] = $this->pagination->create_links();
            $data['teachers'] = $staff_service->get_all_staff($config["per_page"], $start, $this->session->userdata('SMS_USER_BRANCH'), $this->session->userdata('SMS_USER_INSTITUTE'));
            $data['branches'] = $branch_service->show_all_branches($this->session->userdata('SMS_USER_INSTITUTE'));
            $data['user_branch_id'] = $this->session->userdata('SMS_USER_BRANCH');
            $data['institutes'] = $institute_service->show_all_institutes();
            $data['user_institute'] = $this->session->userdata('SMS_USER_INSTITUTE');


            $partials = array('content' => 'HR/password_regeneration/staff/staff_password_regeneration');
            $this->template->load('template/template', $partials, $data);
        } else {
            $this->template->load('template/access_denied');
        }
    }

    
    /*
 * kasun
 * 16.05.2017
 * 
 */
    function search_staff_for_login($start = "0") {

        $perm = new User_privilege_service();

            $staff_service = new Staff_service();

            $config = array();
            $config["base_url"] = site_url() . "/HR/teacher/search_staff_for_login";
            $config["total_rows"] = count($staff_service->get_all_staff_per_type('', '', $this->input->post('staff_type', TRUE), $this->input->post('branch_id', TRUE), $this->input->post('word', TRUE), $this->input->post('institute_id', TRUE)));
            $config["per_page"] = 10;
            $config["uri_segment"] = 4;
            $config["num_links"] = 4;
            $this->pagination_custome->initialize($config);

            $data["uri_segment"] = $config["uri_segment"];
            $data["links"] = $this->pagination_custome->create_links();
            $data['teachers'] = $staff_service->get_all_staff_per_type($config["per_page"], $start, $this->input->post('staff_type', TRUE), $this->input->post('branch_id', TRUE), $this->input->post('word', TRUE), $this->input->post('institute_id', TRUE));

            echo $this->load->view('HR/password_regeneration/staff/staff_password_regeneration_content', $data);
   
    }

    /*
 * kasun
 * 16.05.2017
 * 
 */
    function generated_password_staff($start = '0') {


        $staff_service = new Staff_service();

        $staff_list = $this->input->post("staff_list", TRUE);

        $config = array();
        $config["base_url"] = site_url() . "/HR/guardian/generated_password_staff";
        $config["total_rows"] = count($staff_list);
        $config["per_page"] = 50;
        $config["uri_segment"] = 4;
        $config["num_links"] = 4;
        $this->pagination_custome->initialize($config);
        $data["uri_segment"] = $config["uri_segment"];
        $data["links"] = $this->pagination_custome->create_links();

        for ($i = 0; $i < count($staff_list); $i++) {
            $staff_id[$i] = $staff_service->get_staff_by_profile_id($staff_list[$i]);
            $data['teachers'][$i] = $staff_service->get_all_staff_details($staff_id[$i]->staff_id);
            $data['password'][$i] = $data['teachers'][$i]->staff_id . $data['teachers'][$i]->profile_id;
            //        $user_service->update_password($data['staff'][$i]->user_name,$data['password'][$i]);
        }

        echo $this->load->view('HR/password_regeneration/staff/staff_passwords', $data);
    }

    function print_staff_passwords() {

        $staff_service = new Staff_service();

        $data['page_title'] = "Regenerated Login Passwords for Staff";
        $staff_list = $_GET["staff_list"];

        for ($i = 0; $i < count($staff_list); $i++) {
            $staff_id[$i] = $staff_service->get_staff_by_profile_id($staff_list[$i]);
            $data['teachers'][$i] = $staff_service->get_all_staff_details($staff_id[$i]->staff_id);
            $data['password'][$i] = $data['teachers'][$i]->staff_id . $data['teachers'][$i]->profile_id;
        }

        $print_out = $this->load->view('HR/password_regeneration/staff/staff_passwords_print', $data, TRUE);
        $footer = $this->load->view('template/custom/pdf_footer', $data, TRUE);
        $this->load->library('MPDF56/mpdf');
        $mpdf = new Mpdf('utf-8', 'A4', 0, '', 15, 15, 0, 0, 0, 0, 'P');
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->simpleTables = true;
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($print_out);
        $mpdf->Output();
    }

}

<?php

//header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: http://localhost:4200');

//header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
include('config.php');

/**  Switch Case to Get Action from controller  * */
switch ($_GET['action']) {
    case 'add_emp' :
        add_employee();
        break;

    case 'get_emp' :
        get_employee();
        break;
    case 'edit_user' :
        edit_user();
        break;
    case 'edit_product' :
        edit_product();
        break;

    case 'delete_user' :
        delete_user();
        break;

    case 'update_user' :
        update_user();
        break;
    case 'save_date' :
        save_date();
        break;
    case 'login_user' :
        login_user();
        break;
       case 'check_login' :
        check_login();
        break;
}

/**  Function to Add Product  * */
function add_employee() {
    // print_r(json_decode($_POST['data']));
    $data = json_decode(file_get_contents("php://input"));
//print_r($data->firstname);die;
    $full_name = $data->fullname;
    $email = $data->email;
    $gender = $data->gender;   
    $phone = $data->phoneno;
    $copntactpreference = $data->copntactpreference;
    $dob = $data->dob;
    $department = $data->department;
    $isactive = $data->gender;

    $qry = 'INSERT INTO employee (fullname,email,gender,phoneno,copntactpreference,dob,department,isactive)
             values ("' . $full_name . '","' . $email . '","' . $gender . '",' . $phone . ',"' . $copntactpreference . '","' . $dob . '","' . $department . '","' . $isactive . '")';

    $qry_res = mysql_query($qry);
    if ($qry_res) {
        $arr = array('success' => 1);
        $jsn = json_encode($arr);
        // print_r($jsn);
    } else {
        $arr = array('success' => 0);
        $jsn = json_encode($arr);
        // print_r($jsn);
    }
    echo $jsn;
}

/**  Function to Get Product  * */
function get_employee() {
    $qry = mysql_query('SELECT * from employee ORDER BY id desc;');
    $data = array();
    while ($rows = mysql_fetch_array($qry)) {
        $data[] = array(
            "id" => $rows['id'],
            "fullname" => $rows['fullname'],
            "email" => $rows['email'],
            "gender" => $rows['gender'],
            "phoneno" => $rows['phoneno'],
            "copntactpreference" => $rows['copntactpreference'],
            "dob" => $rows['dob'],
            "department" => $rows['department'],
            "isactive" => $rows['isactive']
        );
    }
    //print_r(json_encode($data));
    echo json_encode($data);
}

function login_user() {
    $data = json_decode(file_get_contents("php://input"));
    $qry = mysql_query("SELECT * from contact_us where email = '$data->email'");
    $rows = mysql_fetch_array($qry);
    if (!empty($rows)) {
       $data =  array(
            "id" => $rows['id'],
            "username" => $rows['username'],
            "color" => $rows['color'],
            "email" => $rows['email'],
            "phone" => $rows['phone'],
            "state" => $rows['state'],
            "zip" => $rows['zip'],
            "website" => $rows['website'],
            "gender" => $rows['gender']
        );
        echo json_encode($data);
    } else {
        echo json_encode(array('error' => 1));
    }
}
function check_login() {
    $data = json_decode(file_get_contents("php://input"));
    $qry = mysql_query("SELECT * from user where email = '$data->email'");
    $rows = mysql_fetch_array($qry);
    if (!empty($rows)) {
       $data =  array(
            "id" => $rows['id'],
            "username" => $rows['username'],
            "color" => $rows['color'],
            "email" => $rows['email'],
            "phone" => $rows['phone'],
            "state" => $rows['state'],
            "zip" => $rows['zip'],
            "website" => $rows['website'],
            "gender" => $rows['gender'],
           "role" => $rows['role']
        );
        echo json_encode($data);
    } else {
        echo json_encode(array('error' => 1));
    }
}
/**  Function to Delete Product  * */
function delete_user() {
    $data = json_decode(file_get_contents("php://input"));
    $index = $data->userid;
    $del = mysql_query("DELETE FROM contact_us WHERE id = " . $index);
    if ($del) {
        $json = json_encode(array('success' => 1));
    } else {
        $json = json_encode(array('success' => 0));
    }
    echo $json;
}

/**  Function to Edit Product  * */
function edit_user() {
    $userid = $_GET['userid'];
    $qry = mysql_query('SELECT * from contact_us WHERE id=' . $userid);
    $data = array();
    while ($rows = mysql_fetch_array($qry)) {
        $data = array(
            "id" => $rows['id'],
            "username" => $rows['username'],
            "color" => $rows['color'],
            "email" => $rows['email'],
            "phone" => $rows['phone'],
            "state" => $rows['state'],
            "zip" => $rows['zip'],
            "website" => $rows['website'],
            "gender" => $rows['gender']
        );
    }
    echo json_encode($data);
    // return json_encode($data);
}

/** Function to Update Product * */
function update_user() {
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;
    $user_name = $data->username;
    $color = $data->color;
    $email = $data->email;
    $phone = $data->phone;
    $state = $data->state;
    $zip = $data->zip;
    $website = $data->website;
    $gender = $data->gender;

    $qry = "UPDATE contact_us set username='" . $user_name . "' , color='" . $color . "',
            email='" . $email . "',phone='" . $phone . "',state='" . $state . "',zip='" . $zip . "',website='" . $website . "',gender='" . $gender . "' WHERE id=" . $id;

    $qry_res = mysql_query($qry);

    if ($qry_res) {
        $arr = array('success' => 1);
        $jsn = json_encode($arr);
        // print_r($jsn);
    } else {
        $arr = array('success' => 0);
        $jsn = json_encode($arr);
        // print_r($jsn);
    }
    echo $jsn;
}

function save_date() {
    $data = json_decode(file_get_contents("php://input"));

    // print_r($data);

    $qry = "INSERT INTO user_detail (ud_fname,ud_email,ud_phone,ud_country) VALUES (" . $data->ud_fname . "," . $data->ud_email . "," . $data->ud_phone . "," . $data->ud_country . ")";

    $qry_res = mysql_query($qry);
    if ($qry_res) {
        $arr = array('msg' => "You are successfully register", 'error' => '');
        $jsn = json_encode($arr);
        // print_r($jsn);
    } else {
        $arr = array('msg' => "", 'error' => 'error please try again');
        $jsn = json_encode($arr);
        // print_r($jsn);
    }
}

?>
<?php

include "layout/header_script.php";


function valid_input($val){
  return !empty($val)?"{$val}": 0;
}

function save_student_photo($file, $student_id, $fallback, $max_size){
  if(!isset($file) || !is_array($file)){
    return $fallback;
  }

  if(!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE){
    return $fallback;
  }

  if($file['error'] !== UPLOAD_ERR_OK){
    return $fallback;
  }

  if($file['size'] > $max_size){
    return $fallback;
  }

  $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  $allowed_types = array(
    "jpg" => "image/jpeg",
    "jpeg" => "image/jpeg",
    "png" => "image/png"
  );

  if(!isset($allowed_types[$extension])){
    return $fallback;
  }

  if(!is_uploaded_file($file['tmp_name'])){
    return $fallback;
  }

  if(function_exists('finfo_open')){
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    if($finfo){
      $mime_type = finfo_file($finfo, $file['tmp_name']);
      finfo_close($finfo);

      if($mime_type !== $allowed_types[$extension]){
        return $fallback;
      }
    }
  }

  $target_dir = "upload/student_photo/";
  if(!is_dir($target_dir)){
    return $fallback;
  }

  $image_name = (int)$student_id.".".$extension;
  $target_path = $target_dir.$image_name;

  if(move_uploaded_file($file['tmp_name'], $target_path)){
    return $image_name;
  }

  return $fallback;
}

if(isset($_POST['test_data'])){
  $info=$_POST;
  unset($info['id']);
  $info['id1']=1;
  $data=json_encode($info);
  echo "$data";
}

if(isset($_POST['insert_name'])){
 
  $id=$student_ob->new_id();
	$info['id']=$id;
	$info['name']=$_POST['insert_name'];
	$info['nick']=$_POST['nick'];
	$info['father_name']=$_POST['father_name'];
	$info['mother_name']=$_POST['mother_name'];
	$info['personal_mobile']=$_POST['student_mobile'];
	$info['father_mobile']=$_POST['father_mobile'];
	$info['mother_mobile']=$_POST['mother_mobile'];
	$info['email']=$_POST['email'];
	$info['birth_day']=$_POST['birthday'];
	$info['gender']=$_POST['gender'];
	$info['religion']=$_POST['religion'];
	$info['address']=$_POST['address'];

	$info['school']=$_POST['school_name'];
	$info['ssc_rool']=valid_input($_POST['ssc_rool']);
	$info['ssc_reg']=valid_input($_POST['ssc_reg']);
	$info['ssc_board']=$_POST['ssc_board'];
	$info['ssc_result']=valid_input($_POST['ssc_result']);
    
  
	$info['date']=$db->date();

  $imagename = save_student_photo($_FILES['image'] ?? null, $id, "avatar.png", 2097152);

$info['photo']=$imagename;

$data=json_encode($info);
  echo "$data";
$db->sql_action("student","insert",$info,"no");
	
}

else if(isset($_POST['update'])){
    
  $info['id']=$_POST['student_id'];
  $id=$info['id'];
  $student_id=$_POST['student_id'];
  $info['name']=$_POST['name'];
  $info['nick']=$_POST['nick'];
  $info['father_name']=$_POST['father_name'];
  $info['mother_name']=$_POST['mother_name'];
  $info['personal_mobile']=valid_input($_POST['student_mobile']);

  $info['father_mobile']=valid_input($_POST['father_mobile']);
  $info['mother_mobile']=valid_input($_POST['mother_mobile']);
  $info['email']=$_POST['email'];
  $info['birth_day']=$_POST['birthday'];
  $info['gender']=$_POST['gender'];
  $info['religion']=$_POST['religion'];
  $info['address']=$_POST['address'];

  $info['school']=$_POST['school_name'];
  $info['ssc_rool']=valid_input($_POST['ssc_rool']);
  $info['ssc_reg']=valid_input($_POST['ssc_reg']);
  $info['ssc_board']=$_POST['ssc_board'];
  $info['ssc_result']=valid_input($_POST['ssc_result']);

  $current_photo = basename($student[$student_id]['photo']);
  $imagename = save_student_photo($_FILES['image'] ?? null, $id, $current_photo, 5097152);

if($imagename !== $current_photo){
 $info['photo']=$imagename;
}


//$site->myprint_r($info);

  $db->sql_action("student","update",$info,"no");
  echo "<script>alert('Successfully Update Student Information!');</script><script>document.location='student_profile.php?get_id=$id'</script>";
	
}

else if(isset($_POST['delete'])){

$student_id=$_POST['id'];
$info['id']=$student_id;

$payment_info=$payment->get_payment_info();
foreach ($payment_info as $key => $value) {
   $id=$value['id'];
   $sid=$value['student_id'];
   if($sid==$student_id){
    $info['id']=$id;
    $db->sql_action("payment","delete",$info,'no');
   }
}

foreach ($result_info as $key => $value) {
   $id=$value['id'];
   $sid=$value['student_id'];
   if($sid==$student_id){
    $info['id']=$id;
    $db->sql_action("result","delete",$info,'no');
   }
}
$info['id']=$student_id;
$db->sql_action("student","delete",$info,'yes');


}

?>

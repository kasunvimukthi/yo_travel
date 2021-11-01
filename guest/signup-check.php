<?php 
session_start(); 
include "db_conn.php";

    //Load Composer's autoloader
    require '../vendor/autoload.php';
  

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

if (isset($_POST['uname']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	$re_pass = validate($_POST['re_password']);
	$name = validate($_POST['name']);
	$Age = validate($_POST['age']);
	$Address = validate($_POST['address']);
	$Email_Address = validate($_POST['email_address']);
	$Phone_Number = validate($_POST['cnumber']);

	$user_data = 'uname='. $uname. '&name='. $name;


	if (empty($uname)) {
		$_SESSION['status'] = "User Name is required";
		$_SESSION['status_code'] ="info";
		header("Location: ../guest/index.php");
	    exit();
	}else if(empty($pass)){
		$_SESSION['status'] = "Password is required";
		$_SESSION['status_code'] ="info";
		header("Location: ../guest/index.php");
	    exit();
	}
	else if(empty($re_pass)){
		$_SESSION['status'] = "Re Password is required";
		$_SESSION['status_code'] ="info";
		header("Location: ../guest/index.php");
	    exit();
	}

	else if(empty($name)){
		$_SESSION['status'] = "Name is required";
		$_SESSION['status_code'] ="info";
		header("Location: ../guest/index.php");
	    exit();
	}

	else if(empty($Age)){
		$_SESSION['status'] = "Age is required";
		$_SESSION['status_code'] ="info";
		header("Location: ../guest/index.php");
	    exit();
	}

	else if(empty($Address)){
		$_SESSION['status'] = "Address is required";
		$_SESSION['status_code'] ="info";
		header("Location: ../guest/index.php");
	    exit();
	}

	else if(empty($Email_Address)){
		$_SESSION['status'] = "Email Address is required";
		$_SESSION['status_code'] ="info";
		header("Location: ../guest/index.php");
	    exit();
	}

	else if(empty($Phone_Number)){
		$_SESSION['status'] = "Phone Number is required";
		$_SESSION['status_code'] ="info";
		header("Location: ../guest/index.php");
	    exit();
	}

	else if($pass !== $re_pass){
		$_SESSION['status'] = "The confirmation password  does not match";
		$_SESSION['status_code'] ="info";
		header("Location: ../guest/index.php");
	    exit();
	}

	else{

		// hashing the password
        $pass = md5($pass);

	    $sql = "SELECT * FROM users WHERE Email_Address='$Email_Address' ";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			$_SESSION['status'] = "The E-mail is taken try another";
			$_SESSION['status_code'] ="info";
			header("Location: ../guest/index.php");
	        exit();
		}else {
           $sql2 = "INSERT INTO users(User_Name, Name, Password, Age, Address, Email_Address, Phone_Number ) VALUES('$uname','$name','$pass', '$Age', '$Address', '$Email_Address', '$Phone_Number')";
           $result2 = mysqli_query($conn, $sql2);
           if ($result2) {
			$_SESSION['status'] = "Your account has been created successfully";
			$_SESSION['status_code'] ="success";
			header("Location: ../guest/index.php");
			send_login_qr_code($Email_Address,$pass,$name);
	         exit();
           }else {
			$_SESSION['status'] = "unknown error occurred";
			$_SESSION['status_code'] ="error";
			header("Location: ../guest/index.php");
		        exit();
           }
		}
	}
	
}else{
	header("Location: index.php");
	exit();
}

function send_login_qr_code($Email_Address,$pass,$name)
    {
		require ('../vendor-QR/autoload.php');
        $barcode = new \Com\Tecnick\Barcode\Barcode();
        $targetPath = "qr-code/";


		
        $qr_detail = $Email_Address.$pass; 
        
        
        if (! is_dir($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $bobj = $barcode->getBarcodeObj('QRCODE,H', $qr_detail, - 16, - 16, 'black', array(
            - 2,
            - 2,
            - 2,
            - 2
        ))->setBackgroundColor('#f0f0f0');
        
        $imageData = $bobj->getPngData();
        
        $file2 =  $imageData;
        
		$mail = new PHPMailer(true);
         //Server settings
		// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication

		$mail->Host       = "smtp.gmail.com";                     //Set the SMTP server to send through
		$mail->Username   = "yotravelmail@gmail.com";                     //SMTP username
		$mail->Password   = "yotravel@password#1234";                               //SMTP password

		$mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
		$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		//Recipients
		$mail->setFrom("yotravelmail@gmail.com", "Yo-travel");
		$mail->addAddress($Email_Address);     //Add a recipient

		$mail->isHTML(true);
		
		$mail->addStringAttachment($file2, 'Yo-travel-login.png');
		$mail->Subject = "Successfully created a new account";

		$email_template = "
		<h2>Dear $name ,</h2>
		<h3>You have successfully created a new account on Yo-travel.com. You can access our system using your QR code. Your QR code is attached to this mail.</h3>
		<p>Yo-travel(PVT)Ltd</p>
		<p>Tel : 076 575 6616</p>
		<p>Address : 267/2,</p>
		<p>Ihalabiyanwila,</p>
		<p>Kadawatha</p>
		";

		$mail->Body = $email_template;
		$mail->send();

		}

<?php
    $jsondata = file_get_contents('php://input');
    $data = json_decode($jsondata);
    
    $toEmail = "matalav55@gmail.com";
    $fromEmail = "matalav55@gmail.com";

    $to = $toEmail;
    $subject = $data -> name;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $message = $data -> message;
    $email = $data -> email;
    $number = $data -> phone;
    $name = $data -> name;
    $headers .= 'From: '.$fromEmail.'<'.$fromEmail.'>' . "\r\n".'Reply-To: '.$fromEmail."\r\n" . 'X-Mailer: PHP/' . phpversion();
    $body = '<!doctype html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta name="viewport"
					  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
				<meta http-equiv="X-UA-Compatible" content="ie=edge">
				<title>Document</title>
			</head>
			<body>
			<span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">'.$message.'</span>
				<div class="container">
                 '.$name.'<br/>
                 Phone Number'.$number.'<br/>
                 Email: '.$email.'<br/>
                 '.$message.'<br/>
                    Regards<br/>
                  '.$fromEmail.'
				</div>
			</body>
			</html>';
    $result = mail($to, $subject, $body, $headers);
    if($result){
        $jsonresponse = array('code' => '200', 'status' => 'success');
        echo json_encode($jsonresponse);
    }else{
        $jsonresponse = array('code' => '500', 'status' => 'failure');
        echo json_encode($jsonresponse);
    }
?>
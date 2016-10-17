<?php
$MSG= array(
"SIGNUP_SUCCESS"=>"",
"SIGNUP_ERROR"=>"",

"LOGIN_SUCCESS"=>"",
"LOGIN_NOTFOUND"=>"",
"LOGIN_ERROR"=>"",

"UPDATE_USER_SUCCESS"=>"",
"UPDATE_USER_ERROR"=>"",

"DELETE_USER_SUCCESS"=>"",
"DELETE_USER_ERROR"=>"",

"GET_USER_SUCCESS"=>"",
"GET_USER_NOTFOUND"=>"",
"GET_USER_ERROR"=>"",


"RESET_PASSWORD_SUCCESS"=>"",
"RESET_PASSWORD_NOTFOUND"=>"",
"RESET_PASSWORD_ERROR"=>"",

"CONTACT_US_SUCCESS"=>"",
"CONTACT_US_ERROR"=>"",

"REGISTER_DEVICE_SUCCESS"=>"",
"REGISTER_DEVICE_ERROR"=>"",

"REPORT_INCIDENT_SUCCESS"=>"",
"REPORT_INCIDENT_ERROR"=>"",

"ALERT_SOS_TRACKING_SUCCESS"=>"",
"ALERT_SOS_TRACKING_ERROR"=>"",

"UPDATE_SOS_TRACKING_SUCCESS"=>"",
"UPDATE_SOS_TRACKING_ERROR"=>"",

"STOP_SOS_TRACKING_SUCCESS"=>"",
"STOP_SOS_TRACKING_ERROR"=>"",

"ADD_CONTACTS_SUCCESS"=>"",
"ADD_CONTACTS_ERROR"=>"",
	);

function SIGNUP($conn)
{
  
  $sql = $conn->prepare("INSERT INTO user VALUES ('', '', ?, ?, ?, ?, ?, ?, now(),'', 0)");
		$sql->bind_param("ssssss", $email, $password, $birthday, $contact, $city, $gender);
		
		$email = $_REQUEST["EMAIL"];
		$password = $_REQUEST["PASSWORD"];
		$birthday = $_REQUEST["BIRTHDAY"];
		$contact = $_REQUEST["CONTACT"];
        $city = $_REQUEST["CITY"];
        $gender = $_REQUEST["GENDER"];

		
		if ($sql->execute())
			{
				$json["STATUS"] = "SUCCESS";
				$json["MESSAGE"] = $MSG["SIGNUP_SUCCESS"];

			}
		else
			{
				$json["STATUS"] = "ERROR";
				$json["MESSAGE"] = $MSG["SIGNUP_ERROR"].$sql->error;
			}

		$sql->close();

	
	return json_encode($json);

#function ends
}

function LOGIN($conn)
{
	
	$sql = $conn->prepare("SELECT * FROM user WHERE  email = ? AND password = ? AND status != 2");
	$sql->bind_param("ss", $email, $password);

	$email = $_REQUEST["EMAIL"];
	$password = $_REQUEST["PASSWORD"];

	if($sql->execute()){
	    $json["STATUS"] = "SUCCESS";
		$json["MESSAGE"] =  $MSG["LOGIN_SUCCESS"];
		$sql->bind_result($user_id, $email, $nickname, $password, $birthday, $contact, $city, $gender, $signup_date, $reason, $status);
		$count =0;
		while($sql->fetch())
		{
			$_data["user_id"] = $user_id;
			$_data["email"] = $email;
			$_data["password"] = $password;
			$json["DATA"][] = $_data;
			$count++;
		}
		if ($count == 0)
		{
			$json["STATUS"] = "NOTFOUND";
			$json["MESSAGE"] = $MSG["LOGIN_NOTFOUND"];
	    }
	}
	else{
		$json["STATUS"] = "ERROR";
		$json["MESSAGE"] = $MSG["LOGIN_ERROR"];
		return json_encode($json);
	}
	
	
	
	$sql->close();
	return json_encode($json);
	#function ends
} 

 
function UPDATE_USER($conn)
{
	$sql = $conn->prepare("UPDATE user SET  nickname = ?, email = ?, birthday = ?, contact = ?, gender = ? WHERE user_id = ?");
	
	$sql->bind_param("sssssi", $nickname, $email, $contact, $birthday, $gender, $user_id);
	
	$user_id = $_REQUEST["USER_ID"];
	$nickname = $_REQUEST["NICKNAME"];
	$email = $_REQUEST["EMAIL"];
	$birthday = $_REQUEST["BIRTHDAY"];
	$contact = $_REQUEST["CONTACT"];
	$gender = $_REQUEST["GENDER"];

	if ($sql->execute())
	{
		$json["STATUS"] = "SUCCESS";
		$json["MESSAGE"] = $MSG["UPDATE_USER_SUCCESS"];

	}
	else
	{
		$json["STATUS"] = "ERROR";
		$json["MESSAGE"] = $MSG["UPDATE_USER_ERROR"] .$mysql->error;
	}

	$sql->close();


return json_encode($json);

#function ends
  
}


function DELETE_USER($conn)
{	
	$sql = $conn->prepare("UPDATE user SET reason = ?, status = 2 WHERE user_id = ?");
	$sql->bind_param("si", $reason, $user_id);
	$reason = $_REQUEST["REASON"];
	$user_id = $_REQUEST["USER_ID"];
	if ($sql->execute())
	{
		$json["STATUS"] = "SUCCESS";
		$json["MESSAGE"] = $MSG["DELETE_USER_SUCCESS"];

	}
	else
	{
		$json["STATUS"] = "ERROR";
		$json["MESSAGE"] = $MSG["DELETE_USER_ERROR"]. $sql->error;
	}

	

	$sql->close();
	
	return json_encode($json);

#function ends
  
}

 function GET_USER($conn)
{  
    $sql = $conn->prepare("SELECT * FROM user WHERE email = ?");
	$sql->bind_param("s", $email);
	$email = $_REQUEST["EMAIL"];
	if($sql->execute())
	{
		$json["STATUS"] = "SUCCESS";
		$json["MESSAGE"] =$MSG["GET_USER_SUCCESS"];
		$sql->bind_result($user_id, $email, $nickname, $password, $birthday, $contact, $city, $gender, $signup_date, $reason, $status);
	    $count =0;
		while ($sql->fetch())
		{
			$_data["email"] = $email;
			$_data["nickname"] = $nickname;
			$_data["password"] = $password;
			$_data["birthday"] = $birthday;
			$_data["contact"] = $contact;
			$_data["city"] = $city;
			$_data["gender"] = $gender;
			$_data["signup_date"] = $signup_date;
			$_data["status"] = $status;
			$json["DATA"][] = $_data;
			unset($_data);
			$count++;
		}
		if ($count == 0)
		{
			$json["STATUS"] = "NOTFOUND";
			$json["MESSAGE"] = $MSG["GET_USER_NOTFOUND"];

		}
	}
	else
	{	
		$json["STATUS"] = "ERROR";
		$json["MESSAGE"] =  $MSG["GET_USER_ERROR"]. $sqli->error;
		return json_encode($json);
	}
	
	$sql->close();
		
	return json_encode($json);

#function ends
}

 
 function RESET_PASSWORD($conn){   
  
    $sql = $conn->prepare("SELECT * FROM user WHERE  email = ?");
	$sql->bind_param("s",$email);
    $email = $_REQUEST["EMAIL"];
	if($sql->execute()){
	    $json["STATUS"] = "SUCCESS";
		$sql->bind_result($user_id, $email, $nickname, $password, $birthday, $contact, $city, $gender, $signup_date, $reason, $status);
	    $count =0;
		while ($sql->fetch())
		{
			$_data["email"] = $email;
			$json["DATA"][] = $_data;
			unset($_data);
			$count++;

            mail(to, subject, message);
            $json["MESSAGE"] =$MSG["RESET_PASSWORD_SUCCESS"];
        }
		if ($count == 0)
		{
			$json["STATUS"] = "NOTFOUND";
			$json["MESSAGE"] = $MSG["RESET_PASSWORD_NOTFOUND"];

		}
	}
	else{

		$json["STATUS"] = "ERROR";
        $json["MESSAGE"] = $MSG["RESET_PASSWORD_ERROR"];
		
	}
	$sql->close();
	return json_encode($json);
	#function ends
} 

function CONTACT_US($conn)
{
  
  $sql = $conn->prepare("INSERT INTO contact_us VALUES ('', ?, ?, ?, now(), 0)");
		$sql->bind_param("sss", $email, $title, $message);
		
		$email = $_REQUEST["EMAIL"];
		$title = $_REQUEST["TITLE"];
		$message = $_REQUEST["MESSAGE"];

		
		if ($sql->execute())
			{
				$json["STATUS"] = "SUCCESS";
				$json["MESSAGE"] = $MSG["CONTACT_US_SUCCESS"];

			}
		else
			{
				$json["STATUS"] = "ERROR";
				$json["MESSAGE"] = $MSG["CONTACT_US_ERROR"]. $sql->error;
			}

		$sql->close();

	
	return json_encode($json);

#function ends
}

function REGISTER_DEVICE($conn)
{
  
  $sql = $conn->prepare("INSERT INTO device VALUES ('', ?, now(), 0)");
		$sql->bind_param("s", $email);
		$email = $_REQUEST["EMAIL"];
        if ($sql->execute())
			{

				$json["STATUS"] = "SUCCESS";
				$json["MESSAGE"] = $MSG["REGISTER_DEVICE_SUCCESS"];

			}
		else
			{
				$json["STATUS"] = "ERROR";
				$json["MESSAGE"] = $MSG["REGISTER_DEVICE_ERROR"]. $sql->error;
			}

		$sql->close();

	
	return json_encode($json);

#function ends
}


function REPORT_INCIDENT($conn)
{
  
  $sql = $conn->prepare("INSERT INTO report_incident VALUES ('', ?, ?, ?, ?, ?, ?, now(), 0)");
		$sql->bind_param("ssssss", $email, $latitude, $longitude, $datetime, $incident, $victim);
		$email = $_REQUEST["EMAIL"];
		$latitude = $_REQUEST["LATITUDE"];
		$longitude = $_REQUEST["LONGITUDE"];
		$datetime = $_REQUEST["DATETIME"];
		$incident = $_REQUEST["INCIDENT"];
		$victim = $_REQUEST["VICTIM"];
		
        if ($sql->execute())
			{
				
				$json["STATUS"] = "SUCCESS";
				$json["MESSAGE"] = $MSG["REPORT_INCIDENT_SUCCESS"];

			}
		else
			{
				$json["STATUS"] = "ERROR";
				$json["MESSAGE"] = $MSG["REPORT_INCIDENT_ERROR"]. $sql->error;
			}

		$sql->close();

	
	return json_encode($json);

#function ends
}


function ALERT_SOS_TRACKING($conn)
{
  
  $sql = $conn->prepare("INSERT INTO sos_tracking VALUES ('', ?, ?, ?, 0, 0, '', 0)");
		$sql->bind_param("sss", $email, $latitude, $logitude);
		$email = $_REQUEST["EMAIL"];
		$latitude = $_REQUEST["LATITUDE"];
		$logitude = $_REQUEST["LONGITUDE"];
		
        if ($sql->execute())
			{
				
				$json["STATUS"] = "SUCCESS";
				$json["MESSAGE"] = $MSG["ALERT_SOS_TRACKING_SUCCESS"];

			}
		else
			{
				$json["STATUS"] = "ERROR";
				$json["MESSAGE"] = $MSG["ALERT_SOS_TRACKING_ERROR"]. $sql->error;
			}

		$sql->close();

	
	return json_encode($json);

    #function ends
}

function UPDATE_SOS_TRACKING($conn)
{
  
        $sql = $conn->prepare("UPDATE sos_tracking SET email = ?, latitude = ?,  logitude = ? WHERE tracking_id = ?");
		$sql->bind_param("sssi", $email, $latitude, $logitude, $tracking_id);
		$tracking_id = $_REQUEST["TRACKING_ID"];
		$email = $_REQUEST["EMAIL"];
		$latitude = $_REQUEST["LATITUDE"];
		$logitude = $_REQUEST["LONGITUDE"];
		
        if ($sql->execute())
			{
				
				$json["STATUS"] = "SUCCESS";
				$json["MESSAGE"] = $MSG["UPDATE_SOS_TRACKING_SUCCESS"];

			}
		else
			{
				$json["STATUS"] = "ERROR";
				$json["MESSAGE"] = $MSG["UPDATE_SOS_TRACKING_ERROR"]. $sql->error;
			}

		$sql->close();

	
	return json_encode($json);

     #function ends
}

function STOP_SOS_TRACKING($conn)
{
  
        $sql = $conn->prepare("UPDATE sos_tracking SET reached = 1, safe = 1, remarks = ?, status = 1 WHERE email = ?");
		$sql->bind_param("sssi", $email, $remarks);
		$email = $_REQUEST["EMAIL"];
		$remarks = $_REQUEST["REMARKS"];
		if ($sql->execute())
			{
				
				$json["STATUS"] = "SUCCESS";
				$json["MESSAGE"] = $MSG["STOP_SOS_TRACKING_SUCCESS"];

			}
		else
			{
				$json["STATUS"] = "ERROR";
				$json["MESSAGE"] = $MSG["STOP_SOS_TRACKING_ERROR"]. $sql->error;
			}

		$sql->close();

	
	return json_encode($json);

     #function ends
}

function ADD_CONTACTS($conn)
{
  
  $sql = $conn->prepare("INSERT INTO add_contacts VALUES ('' , ? , explode(?), now(), 0)");
		$sql->bind_param("ss", $email, $contacts);
		$email = $_REQUEST["EMAIL"];
		$contacts = $_REQUEST["CONTACTS"];
		
        if ($sql->execute())
			{
				
				$json["STATUS"] = "SUCCESS";
				$json["MESSAGE"] = $MSG["ADD_CONTACTS_SUCCESS"];

			}
		else
			{
				$json["STATUS"] = "ERROR";
				$json["MESSAGE"] = $MSG["ADD_CONTACTS_ERROR"]. $sql->error;
			}

		$sql->close();

        return json_encode($json);

    #function ends
}	

?>
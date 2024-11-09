<?php  

require_once 'dbConfig.php';

function getAllUsers($pdo) {
	$sql = "SELECT * FROM coaches 
			ORDER BY first_name ASC";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getUserByID($pdo, $id) {
	$sql = "SELECT * from coaches WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function searchForAUser($pdo, $searchQuery) {
	
	$sql = "SELECT * FROM coaches WHERE 
			CONCAT(first_name,last_name,email,gender,
				address,specialization,years_of_experience,date_added) 
			LIKE ?";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute(["%".$searchQuery."%"]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}



function insertNewUser($pdo, $first_name, $last_name, $email, 
	$gender, $address, $specialization, $years_of_experience) {
        $response = array();
	    

	$sql = "INSERT INTO coaches 
			(
				first_name,
				last_name,
				email,
				gender,
				address,
				specialization,
				years_of_experience
				
			)
			VALUES (?,?,?,?,?,?,?)
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([
		$first_name, $last_name, $email, 
		$gender, $address, $specialization, 
		$years_of_experience
	]);

	if ($executeQuery) {
		$response = array(
            "status" => "200",
            "message" => "User successfully inserted!"
        );
	}
    else {
        $response = array(
            "status" => "400",
            "message" => "An error occured with the query!"
        );
    }
    
    return $response;
}

function editUser($pdo, $first_name, $last_name, $email, $gender, 
	$address, $specialization, $years_of_experience, $id) {

	$sql = "UPDATE coaches
				SET first_name = ?,
					last_name = ?,
					email = ?,
					gender = ?,
					address = ?,
					specialization = ?,
					years_of_experience = ?
				WHERE id = ? 
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, $email, $gender, 
		$address, $specialization, $years_of_experience, $id]);

	if ($executeQuery) {
		return true;
	}

}


function deleteUser($pdo, $id) {
	$sql = "DELETE FROM coaches 
			WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);

	if ($executeQuery) {
		return true;
	}
}




?>
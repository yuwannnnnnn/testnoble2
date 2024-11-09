<?php  

require_once 'dbConfig.php';
require_once 'models.php';


if (isset($_POST['insertUserBtn'])) {
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$email = trim($_POST['email']);
	$gender = trim($_POST['gender']);
    $address = trim($_POST['address']);
    $specialization = trim($_POST['specialization']);
    $years_of_experience = trim($_POST['years_of_experience']);
    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($gender) && !empty($address) && !empty($specialization) && !empty($years_of_experience)){
        $insertUser = insertNewUser($pdo,$_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['gender'], $_POST['address'], $_POST['specialization'], $_POST['years_of_experience']);

                if ($insertUser['status' == '200']) {
                    $_SESSION['message'] = $insertUser['message'];
                    $_SESSION['status'] = $insertUser['status'];
                    header("Location: ../index.php");
                }
                else {
                    $_SESSION['message'] = $insertUser['message'];
                    $_SESSION['status'] = $insertUser['status'];
                    header("Location: ../index.php");
                }
    }
    else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = "400";
		header("Location: ../index.php");
    }
}


if (isset($_POST['editUserBtn'])) {
	$editUser = editUser($pdo,$_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['gender'], $_POST['address'], $_POST['specialization'], $_POST['years_of_experience'], $_GET['id']);

	if ($editUser) {
		$_SESSION['message'] = "Successfully edited!";
		header("Location: ../index.php");
	}
}

if (isset($_POST['deleteUserBtn'])) {
	$deleteUser = deleteUser($pdo,$_GET['id']);

	if ($deleteUser) {
		$_SESSION['message'] = "Successfully deleted!";
		header("Location: ../index.php");
	}
}

if (isset($_GET['searchBtn'])) {
	$searchForAUser = searchForAUser($pdo, $_GET['searchInput']);
	foreach ($searchForAUser as $row) {
		echo "<tr> 
				<td>{$row['id']}</td>
				<td>{$row['first_name']}</td>
				<td>{$row['last_name']}</td>
				<td>{$row['email']}</td>
				<td>{$row['gender']}</td>
				<td>{$row['address']}</td>
				<td>{$row['specialization']}</td>
				<td>{$row['years_of_experience']}</td>
			  </tr>";
	}
}

?>
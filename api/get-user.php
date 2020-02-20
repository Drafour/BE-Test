<?php
  //http://127.0.0.1/be-test/api/get-user?code=G1Xzeahb&username=adminmantap

  try {
    //if get exists
    if (isset($_GET['code']) && isset($_GET['username'])) {
      //if contents of get are not empty
      if (!empty($_GET['code']) && !empty($_GET['username'])) {
        //include database
        include_once '../cfg/db.php';

        //start connecting to database
        $database = new Database();
        $conn     = $database->getConnection();

        $code     = $_GET['code'];
        $username = $_GET['username'];

        $check_user = "SELECT
                         u.id
                       FROM
                         users u
                       JOIN
                         roles r
                       ON
                         r.id = u.role_id
                       WHERE
                         u.data->>'user_code' = '".$code."'";

        $stmt_check_user = $conn->prepare($check_user);
        $stmt_check_user->execute();
        $check_user_rows = $stmt_check_user->rowCount();

        //if user exists
        if ($check_user_rows > 0) {
          $get_user = "SELECT
                         u.id,
                         u.data->>'username' as username,
                         u.data->>'email' as email,
                         r.data->>'role_name' as type
                       FROM
                         users u
                       JOIN
                         roles r
                       ON
                         r.id = u.role_id
                       WHERE
                         u.data->>'username' = '".$username."'";

          $stmt_user   = $conn->prepare($get_user);
          $stmt_user->execute();
          $user_rows   = $stmt_user->rowCount();
          $result_user = $stmt_user->fetchAll();

          //if user exists
          if ($user_rows > 0) {
            foreach ($result_user as $row) {
              $data_status = array(
                'status'  => 1,
                'message' => 'Success.',
                'result'  => ''
              );

              $data_user = array(
                'id'       => $row['id'],
                'username' => $row['username'],
                'email'    => $row['email'],
                'type'     => $row['type']
              );

              $data_status['result'] = $data_user;

              $dataJSONStatus = json_encode($data_status);

              echo $dataJSONStatus;
            }  //end of foreach
          }
          //if user doesn't exists
          else {
            $data_status = array(
              'status'  => 500,
              'message' => 'User not found.',
              'result'  => ''
            );

            $dataJSONStatus = json_encode($data_status);

            echo $dataJSONStatus;
          }
        }
        //if user doesn't exists
        else {
          $data_status = array(
            'status'  => 200,
            'message' => 'Incorrect code.',
            'result'  => ''
          );

          $dataJSONStatus = json_encode($data_status);

          echo $dataJSONStatus;
        }

        //stop connection
        $conn = null;
      }
      //if the get contents are empty
      else {
        $data_status = array(
          'status'  => 100,
          'message' => 'Incomplete parameters.',
          'result'  => ''
        );

        $dataJSONStatus = json_encode($data_status);

        echo $dataJSONStatus;
      }
    }
    //if get doesn't exists
    else {
      $data_status = array(
        'status'  => 100,
        'message' => 'Incomplete parameters.',
        'result'  => ''
      );

      $dataJSONStatus = json_encode($data_status);

      echo $dataJSONStatus;
    }
  }
  catch (PDOException $e) {
    //do nothing
  }
?>

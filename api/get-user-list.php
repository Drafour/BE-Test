<?php
  //http://127.0.0.1/be-test/api/get-user-list?code=G1Xzeahb&page=1

  try {
    //if get exists
    if (isset($_GET['code']) && isset($_GET['page'])) {
      //if contents of get are not empty
      if (!empty($_GET['code']) && !empty($_GET['page'])) {
        //include database
        include_once '../cfg/db.php';

        //start connecting to database
        $database = new Database();
        $conn     = $database->getConnection();

        $code   = $_GET['code'];
        $offset = $_GET['page'] - 1;

        //if offset less than 0
        if ($offset < 0) {
          $data_status = array(
            'status'  => 300,
            'message' => 'Incorrect page.',
            'result'  => ''
          );

          $dataJSONStatus = json_encode($data_status);

          echo $dataJSONStatus;
        }
        //if offset less than equal to 0
        else {
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
                           data->>'username' as username,
                           data->>'email' as email,
                           CASE data->>'is_active'
                             WHEN 'true' THEN 'active'
                             WHEN 'false' THEN 'inactive'
                           END AS status
                         FROM
                           users
                         ORDER BY
                           username ASC
                         LIMIT 5 OFFSET ".$offset."";

            $stmt_user   = $conn->prepare($get_user);
            $stmt_user->execute();
            $user_rows   = $stmt_user->rowCount();
            $result_user = $stmt_user->fetchAll();

            //if user list exists
            if ($user_rows > 0) {
              $data_user_result = array();

              foreach ($result_user as $row) {
                $data_user = array(
                  'username' => $row['username'],
                  'email'    => $row['email'],
                  'status'   => $row['status']
                );

                $data_user_result[] = $data_user;

                // $dataJSONUser = json_encode($data_user);

                // echo $dataJSONUser;
              }  //end of foreach

              // die(var_dump($data_user_result));

              $data_status = array(
                'status'  => 1,
                'message' => 'Success.',
                'result'  => ''
              );

              $data_status['result'] = $data_user_result;

              $dataJSONStatus = json_encode($data_status);

              echo $dataJSONStatus;
            }
            //if user list doesn't exists
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

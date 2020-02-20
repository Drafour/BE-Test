<?php
  //http://127.0.0.1/be-test/api/delete-user?code=G1Xzeahb&id=3e750878-34a3-441a-b1b2-51f6932a8881

  try {
    //if get exists
    if (isset($_GET['code']) && isset($_GET['id'])) {
      //if contents of get are not empty
      if (!empty($_GET['code']) && !empty($_GET['id'])) {
        //include function
        include_once '../cfg/function.php';

        //include database
        include_once '../cfg/db.php';

        date_default_timezone_set('Asia/Jakarta');
        $date_modified = date('Y-m-d H:i:s');

        //start connecting to database
        $database = new Database();
        $conn     = $database->getConnection();

        $code = $_GET['code'];
        $id   = $_GET['id'];

        $check_user_code = "SELECT
                              u.id
                            FROM
                              users u
                            JOIN
                              roles r
                            ON
                              r.id = u.role_id
                            WHERE
                              u.data->>'user_code' = '".$code."'";

        $stmt_check_user_code = $conn->prepare($check_user_code);
        $stmt_check_user_code->execute();
        $check_user_code_rows = $stmt_check_user_code->rowCount();

        //if user with code exists
        if ($check_user_code_rows > 0) {
          $check_user_role = "SELECT
                                u.id
                              FROM
                                users u
                              JOIN
                                roles r
                              ON
                                r.id = u.role_id
                              WHERE
                                u.data->>'user_code' = '".$code."' AND
                                r.data->>'role_name' = 'Admin'";

          $stmt_check_user_role = $conn->prepare($check_user_role);
          $stmt_check_user_role->execute();
          $check_user_role_rows = $stmt_check_user_role->rowCount();

          //if user with role admin exists
          if ($check_user_role_rows > 0) {
            $get_user = "SELECT
                           data->>'email' as email,
                           data->>'phone' as phone,
                           data->>'password' as password,
                           data->>'username' as username,
                           data->>'last_name' as last_name,
                           data->>'user_code' as user_code,
                           data->>'first_name' as first_name
                         FROM
                           users
                         WHERE
                           id = '".$id."'";

            $stmt_user   = $conn->prepare($get_user);
            $stmt_user->execute();
            $user_rows   = $stmt_user->rowCount();
            $result_user = $stmt_user->fetchAll();

            //if user exists
            if ($user_rows > 0) {
              foreach ($result_user as $row) {
                $data_user = array(
                  'email'      => $row['email'],
                  'phone'      => $row['phone'],
                  'password'   => $row['password'],
                  'username'   => $row['username'],
                  'is_active'  => false,
                  'last_name'  => $row['last_name'],
                  'user_code'  => $row['user_code'],
                  'first_name' => $row['first_name'],
                  'last_login' => 0
                );

                $data = json_encode($data_user);

                $delete_user = "UPDATE
                                  users
                                SET
                                  data       = '".$data."',
                                  deleted_at = '".$date_modified."'
                                WHERE
                                  id = '".$id."'";

                $conn->exec($delete_user);

                $data_status = array(
                  'status'  => 1,
                  'message' => 'Success.',
                  'result'  => ''
                );

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
          //if user with role admin doesn't exists
          else {
            $data_status = array(
              'status'  => 600,
              'message' => 'You don\'t have permission.',
              'result'  => ''
            );

            $dataJSONStatus = json_encode($data_status);

            echo $dataJSONStatus;
          }
        }
        //if user with code doesn't exists
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

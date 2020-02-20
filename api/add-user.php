<?php
  //http://127.0.0.1/be-test/api/add-user?code=G1Xzeahb&username=mimin&first_name=Mimin&last_name=Surimin&email=mimin@yahoo.com&password=qwerty123&phone=081234567890&role=Admin

  try {
    //if get exists
    if (isset($_GET['code']) && isset($_GET['username']) && isset($_GET['first_name']) && isset($_GET['last_name']) && isset($_GET['email']) && isset($_GET['password']) && isset($_GET['phone']) && isset($_GET['role'])) {
      //if contents of get are not empty
      if (!empty($_GET['code']) && !empty($_GET['username']) && !empty($_GET['first_name']) && !empty($_GET['last_name']) && !empty($_GET['email']) && !empty($_GET['password']) && !empty($_GET['phone']) && !empty($_GET['role'])) {
        //include function
        include_once '../cfg/function.php';

        //include database
        include_once '../cfg/db.php';

        date_default_timezone_set('Asia/Jakarta');
        $date_created = date('Y-m-d H:i:s');

        //start connecting to database
        $database = new Database();
        $conn     = $database->getConnection();

        $code       = $_GET['code'];
        $id         = generate_uuid();
        $username   = $_GET['username'];
        $first_name = $_GET['first_name'];
        $last_name  = $_GET['last_name'];
        $email      = $_GET['email'];
        $password   = encrypt_password($_GET['password']);
        $phone      = $_GET['phone'];
        $role       = ucwords(strtolower($_GET['role']));
        $user_code  = generate_code(8);

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
            $get_role = "SELECT
                           id
                         FROM
                           roles
                         WHERE
                           data->>'role_name' = '".$role."'";

            $stmt_role   = $conn->prepare($get_role);
            $stmt_role->execute();
            $role_rows   = $stmt_role->rowCount();
            $result_role = $stmt_role->fetchAll();

            //if role exists
            if ($role_rows > 0) {
              foreach ($result_role as $row) {
                $role_id = $row['id'];
              }  //end of foreach

              $check_user_username = "SELECT
                                        id
                                      FROM
                                        users
                                      WHERE
                                        data->>'username' = '".$username."'";

              $stmt_check_user_username = $conn->prepare($check_user_username);
              $stmt_check_user_username->execute();
              $check_user_username_rows = $stmt_check_user_username->rowCount();

              //if user with username exists
              if ($check_user_username_rows > 0) {
                $data_status = array(
                  'status'  => 700,
                  'message' => 'Username already exists.',
                  'result'  => ''
                );

                $dataJSONStatus = json_encode($data_status);

                echo $dataJSONStatus;
              }
              //if user with username doesn't exists
              else {
                $check_user_email = "SELECT
                                       id
                                     FROM
                                       users
                                     WHERE
                                       data->>'email' = '".$email."'";

                $stmt_check_user_email = $conn->prepare($check_user_email);
                $stmt_check_user_email->execute();
                $check_user_email_rows = $stmt_check_user_email->rowCount();

                //if user with email exists
                if ($check_user_email_rows > 0) {
                  $data_status = array(
                    'status'  => 800,
                    'message' => 'Email already exists.',
                    'result'  => ''
                  );

                  $dataJSONStatus = json_encode($data_status);

                  echo $dataJSONStatus;
                }
                //if user with email doesn't exists
                else {
                  $data_user = array(
                    'email'      => $email,
                    'phone'      => $phone,
                    'password'   => $password,
                    'username'   => $username,
                    'is_active'  => true,
                    'last_name'  => $last_name,
                    'user_code'  => $user_code,
                    'first_name' => $first_name,
                    'last_login' => 0
                  );

                  $data = json_encode($data_user);

                  $insert_user = "INSERT INTO
                                    users
                                  VALUES
                                    ('".$id."',
                                     '".$data."',
                                     '".$role_id."',
                                     '".$date_created."',
                                     null)";

                  $conn->exec($insert_user);

                  $data_status = array(
                    'status'  => 1,
                    'message' => 'Success.',
                    'result'  => ''
                  );

                  $data_user = array(
                    'id'   => $id,
                    'code' => $user_code
                  );

                  $data_status['result'] = $data_user;

                  $dataJSONStatus = json_encode($data_status);

                  echo $dataJSONStatus;
                }
              }
            }
            //if role doesn't exists
            else {
              $data_status = array(
                'status'  => 400,
                'message' => 'Incorrect role.',
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

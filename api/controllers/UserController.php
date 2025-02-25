<?php

namespace App\Controllers;

use \PDO;
use \PDOException;
use App\Models\User;
use App\Models\Datatable;

use App\Helpers\HelperFunctions;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Firebase\JWT\JWT;

class UserController
{
    public $user = null;
    public $datatable = null;
    public $data = null;


    public function __construct($data = array())
    {
        $this->user = new User($data);
        $this->datatable = new Datatable($data);
        $this->data = $data;
    }

    public function create()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO users(first_name, last_name, phone, email, username, password, avatar) VALUES(?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE first_name = ?, last_name = ?, email = ?, phone = ?, password = ?, avatar = ?");
            $query->execute(array($this->user->first_name, $this->user->last_name, $this->user->phone, $this->user->email, $this->user->username, password_hash($this->user->password, PASSWORD_DEFAULT), $this->user->avatar, $this->user->first_name, $this->user->last_name, $this->user->email, $this->user->phone, password_hash($this->user->password, PASSWORD_DEFAULT), $this->user->avatar));
            $this->user->id = $connection->lastInsertId();

            return (object) array(
                'status' => 1,
                'message' => 'User created',
            );
        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            http_response_code(500);
            return (object) array(
                'status' => 0,
                'message' => $e->getMessage() .": ".$e->getTraceAsString()
            );
        }
    }
    public function update(User $user)
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, username = ?, biography = ?, phone = ?, avatar = ? WHERE id = ?");
            $query->execute(array($user->first_name, $user->last_name, $user->email, $user->username, $user->biography, $user->phone, $user->avatar, $user->id));
            return array(
                'status' => 1,
                'message' => 'User updated'
            );
        } catch (PDOException $e) {
            return array(
                'status' => 0,
                'message' => $e->getMessage()
            );
        }
    }
    public function delete()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("DELETE FROM users WHERE id = ?");
            $query->execute(array($user->id));
             DatabaseController::disconnect();
            $user->delete_file($user->avatar);
            echo json_encode(array(
                'status' => 1,
                'title' => '<span class="text-success"><span class="fa fa-check"></span> Success!</span>',
                'message' => '<p>User deleted successfully.</p>',
                'id' => $user->id
            ));
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'title' => '<span class="text-danger"><span class="fa fa-warning"></span> Error!</span>',
                'message' => $e->getMessage()
            ));
        }
    }
    public function changePassword()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE users SET password = ? WHERE id = ?");
            $query->execute(array(password_hash($user->password, PASSWORD_DEFAULT), $user->id));
             DatabaseController::disconnect();
            echo json_encode(array(
                'status' => 1,
                'message' => 'You\'ve changed your password successfully.'
            ));
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage()
            ));
        }
    }
    public function requestPasswordReset()
    {
        try {
            User::checkEmail($user->email);
            $user = User::getByEmail($user->email);
            $token = HelperFunctions::encryptData($user->id);

            echo json_encode(array(
                'status' => 1,
                'message' => 'An email with instructions has been sent to ' . $user->email
            ));


            $subject = "Password Reset Request";
            $email_body[] = array(
                "type" => "body",
                "content" => "
                        <p>Dear " . $user->first_name . ",</p>
                        <p>Someone, probably you, has requested for a change of password under the account email " . $user->email . ". </p>
                        <p>If that was not you, please ignore this email. However, if it's you trying to reset your password, please click the link below</p>
                    "
            );
            $email_body[] = array(
                "type" => "button",
                'link' => DIRADMIN . "/request-password-reset/" . $token,
                'action' => "Reset Password"
            );

            $email_data = array();
            $email_data['subject'] = $subject;
            $email_data['recipient_name'] = $user->first_name . " " . $user->last_name;
            $email_data['recipient_email'] = $user->email;
            $email_data['content_sections'] = $email_body;

            HelperFunctions::sendEmail($email_data);
        } catch (\Exception $e) {
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage()
            ));
        }
    }
    public function resetPassword()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE users SET password = ? WHERE id = ?");
            $query->execute(array(password_hash($user->password, PASSWORD_DEFAULT), $user->id));
             DatabaseController::disconnect();
            $user = self::getById($user->id);

            echo json_encode(array(
                'status' => 1,
                'message' => $user->first_name . ' ' . $user->last_name . '\'s password has been reset successfully'
            ));

            $subject = SITETITLE . ' password has been Reset';
            $email_body[] = array(
                "type" => "body",
                "content" => "
                        <p>Dear " . $user->first_name . ",</p>
                        <p>Your user password has been reset. Please use the following credentials to access your user account: </p>
                    "
            );
            $email_body[] = array(
                "type" => "more_details",
                "content" => "
                        <p>Email: <strong>" . $user->email . "</strong></p>
                        <p>Password: <strong>" . $user->password . "</strong></p>
                    "
            );
            $email_body[] = array(
                "type" => "body",
                "content" => "
                        <p>Kindly click the button below to login.</p>
                    "
            );
            $email_body[] = array(
                "type" => "button",
                'link' => DIRADMIN,
                'action' => "Login"
            );

            $email_data = array();
            $email_data['subject'] = $subject;
            $email_data['recipient_name'] = $user->first_name . " " . $user->last_name;
            $email_data['recipient_email'] = $user->email;
            $email_data['content_sections'] = $email_body;

            HelperFunctions::sendEmail($email_data);
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage()
            ));
        }
    }
    public function updateUserStatus()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("UPDATE users SET active = ? WHERE id = ?");
            $query->execute(array($user->active, $user->id));
             DatabaseController::disconnect();
            $user = self::getById($user->id);

            echo json_encode(array(
                'status' => 1,
                'message' => $user->first_name . ' ' . $user->last_name . '\'s account status has been updated successfully'
            ));
        } catch (PDOException $e) {
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage()
            ));
        }
    }
    public static function check_user($username)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT COUNT(id) FROM users WHERE username = ?");
        $query->execute(array($username));
        $count = $query->fetchColumn();
         DatabaseController::disconnect();
        if ($count > 0) {
            $valid = false;
        } else {
            $valid = true;
        }
        return $valid;
    }
    public static function checkEmail($email)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT COUNT(id) FROM users WHERE email = ?");
        $query->execute(array($email));
        $count = $query->fetchColumn();
         DatabaseController::disconnect();
        $valid = false;
        if ($count) {
            return true;
        } else {
            http_response_code(522);
            throw new \Exception("Email not found in database");
        }
    }
    public static function getById($id)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT users.* FROM users WHERE users.id = ? ");
        $query->execute(array($id));
         DatabaseController::disconnect();
        $result = $query->fetch(PDO::FETCH_OBJ);

        return new User((array)$result);
    }
    public function getByEmail($email)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT users.* FROM users WHERE users.email = ?");
        $query->execute(array($email));
         DatabaseController::disconnect();
        $result = $query->fetch(PDO::FETCH_OBJ);

        return new User((array)$result);
    }
    public static function getUserRoles($user_id)
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT roles.*, user_role.* FROM user_role LEFT JOIN roles ON user_role.role_id = roles.role_id WHERE user_role.user_id = ?");
        $query->execute(array($user_id));
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public static function current_user()
    {
        if (!empty($_SESSION['user'])) {
            $email = $_SESSION['user'];
        } else {
            $email = 0;
        }
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM users WHERE email = ?");
        $query->execute(array($email));
        $result = $query->fetch();
        return new User($result);
    }
    public static function getList()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM users");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public function dataTable()
    {
        $connection =  DatabaseController::connect();
        $query = "SELECT users.*, DATE_FORMAT(users.created_at, '%b %e, %Y %l:%i%p') AS created_at FROM users ";
        $query_params = array();
        $keyword = (isset($this->datatable->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        if (isset($this->datatable->search['value'])) {
            $query .= "WHERE users.first_name LIKE ? ";
            $query .= "OR users.last_name LIKE ? ";
            $query .= "OR users.phone LIKE ? ";
            $query .= "OR users.email LIKE ? ";
            $query .= "OR users.username LIKE ? ";
            for ($i = 0; $i < 5; $i++) {
                $query_params[] = $keyword;
            }
        }
        if (isset($this->datatable->order)) {
            $order_col = $this->datatable->order['0']['column'];
            $column = '';
            switch ($order_col) {
                case 1:
                    $column = 'users.first_name';
                    break;

                default:
                    $query .= "ORDER BY users.id ASC ";
                    break;
            }
            $query .= "ORDER BY " . $column . " " . $this->datatable->order['0']['dir'] . " ";
        } else {
            $query .= "ORDER BY users.id DESC ";
        }
        if ($this->datatable->length != '-1') {
            $query .= 'LIMIT ' . $this->datatable->start . ', ' . $this->datatable->length;
        }
        $statement = $connection->prepare($query);
        $statement->execute($query_params);
         DatabaseController::disconnect();
        $results = $statement->fetchAll(PDO::FETCH_OBJ);

        $data = array();
        foreach ($results as $row) {
            if ($row->active) {
                $status = '<span class="badge badge-sm bg-success">Active</span>';
                $activation_button = '<a href="#" data-id="' . $row->id . '" avatar="' . $row->avatar . '" name="' . $row->first_name . ' ' . $row->last_name . '" class="btn btn-outline-warning btn-sm deactivate-user-btn" data-toggle="modal" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivate user"><i class="fa fa-user-alt-slash" aria-hidden="true"></i></a>';
            } else {
                $status = '<span class="badge badge-sm bg-warning">Inactive</span>';
                $activation_button = '<a href="#" data-id="' . $row->id . '" avatar="' . $row->avatar . '" name="' . $row->first_name . ' ' . $row->last_name . '" class="btn btn-outline-success btn-sm activate-user-btn" data-toggle="modal" data-bs-toggle="tooltip" data-bs-placement="top" title="Activate user"><i class="fa fa-user-check" aria-hidden="true"></i></a>';
            }
            if ($row->sa) {
                $btns = '<div class="btn-group">
                                <a href="' . DIRADMIN . 'users/view/' . HelperFunctions::encryptData($row->id) . '" user-id="' . $row->id . '" class="btn btn-outline-secondary btn-sm view-user-btn" data-toggle="modal"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>';
            } else {
                $btns = '<div class="btn-group">
                                <a href="#" data-id="' . $row->id . '" class="btn btn-outline-info btn-sm reset-password-btn"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                <a href="' . DIRADMIN . 'users/view/' . HelperFunctions::encryptData($row->id) . '" data-id="' . $row->id . '" class="btn btn-outline-secondary btn-sm view-user-btn" data-toggle="modal"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a href="#" data-id="' . $row->id . '" class="btn btn-outline-primary btn-sm edit-user-btn" data-toggle="modal"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                ' . $activation_button . '
                            </div>';
            }
            // $avatar = $row->avatar ? UPLOADS_PATH . '/avatars/' . $row->avatar . '?' . time() : ASSETS . '/admin/img/user-avatar.png';
            $table_row = array();
            $table_row[] = '<img src="" class="img-fluid img-thumbnail rounded-circle" style="height: 40px"/>';
            $table_row[] = $row->first_name . ' ' . $row->last_name . " (" . $row->username . ")";
            $table_row[] = $row->phone;
            $table_row[] = $row->email;
            $table_row[] = $status;
            $table_row[] = $row->created_at;
            $table_row[] = $btns;

            // if(!$row->sa){
            $data[] = $table_row;
            // }
        }
        echo json_encode(array(
            'draw' => intval($this->datatable->draw),
            'recordsTotal' => count($results),
            'recordsFiltered' => $this->totalUsers(),
            "data" => $data
        ), JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES);
    }
    public function totalUsers()
    {
        $connection =  DatabaseController::connect();
        $statement = "SELECT COUNT(id) FROM users ";
        $query_params = array();
        $keyword = (isset($this->datatable->search['value'])) ? '%' . $this->datatable->search['value'] . '%' : '%%';
        if (isset($this->datatable->search['value'])) {
            $statement .= "WHERE users.first_name LIKE ? ";
            $statement .= "OR users.last_name LIKE ? ";
            $statement .= "OR users.phone LIKE ? ";
            $statement .= "OR users.email LIKE ? ";
            $statement .= "OR users.username LIKE ? ";
            $statement .= "AND users.sa = ? ";
            for ($i = 0; $i < 5; $i++) {
                $query_params[] = $keyword;
            }
            $query_params[] = '0';
        } else {
            $statement .= "WHERE users.sa = ? ";
            $query_params[] = '0';
        }
        $query = $connection->prepare($statement);
        $query->execute($query_params);
         DatabaseController::disconnect();
        return $query->fetchColumn();
    }
    public static function getRoles()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT * FROM roles");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    public static function totalObjects()
    {
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT COUNT(object_id) FROM objects");
        $query->execute();
         DatabaseController::disconnect();
        return $query->fetchColumn();
    }
    public function login()
    {
        if (is_null($user->email) || is_null($user->password)) {
            echo json_encode(array(
                'status' => 0,
                'message' => 'Empty email and/or password'
            ), JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES);
        } else {
            if ($user->verify_user()) {
                $user_details = self::getByEmail($user->email);
                if ($user_details->active) {
                    $_SESSION['user'] = $user->email;
                    $_SESSION['user_details'] = $user_details;
                    // $user->role_id = $_SESSION['user_details']->user_roles;
                    // $_SESSION['user_permissions'] = $user->getRolePermissions();
                    echo json_encode(array(
                        'status' => 1,
                        'message' => 'Authentication successful, you\'ll be redirected shortly',
                        'redirect' => $user->redirect,
                        'user_details' => $_SESSION['user_details'],
                        // 'token' => $jwt
                    ), JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES);

                    if ($user_details->id) {
                        $data = array(
                            "user_id" => $user_details->id,
                            "subject" => "Logged In",
                            "description" => "logged in at " . date('d-m-Y H:i:s'),
                            "object" => $user->object,
                            "item_id" => $user_details->id,
                        );
                        $transaction_log = new UserTransactionLog();
                        $transaction_log->initializeParams($data);
                        $transaction_log->create();
                    }
                } else {
                    echo json_encode(array(
                        'status' => 0,
                        'message' => 'Inactive user account. Contact your administrator for assistance'
                    ), JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES);
                }
            } else {
                echo json_encode(array(
                    'status' => 0,
                    'message' => 'Wrong email and/or password'
                ), JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES);
            }
        }
    }
    public function authenticate()
    {
        if (!isset($_SESSION['user'])) {
            if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
                $user->email = $_COOKIE['email'];
                $user->password = $_COOKIE['password'];
                if ($user->verify_user()) {
                    $_SESSION['user'] = $user->email;
                    $_SESSION['user_details'] = self::getByEmail($user->email);
                    echo json_encode(array(
                        'status' => 1,
                        'title' => '<span class="text-success"><span class="fa fa-check"></span> Success!</span>',
                        'message' => '<p class="text-success">Authentication successful, you\'ll be redirected shortly.</p>',
                        'redirect' => DIRADMIN,
                        'user_details' => $_SESSION['user_details']
                    ));
                } else {
                    echo json_encode(array(
                        'status' => 0,
                        'title' => '<span class="text-danger"><span class="fa fa-warning"></span> Error!</span>',
                        'message' => '<p class="text-danger">Wrong email and/or password.</p>'
                    ));
                }
            } else {
                $redirect = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : DIRADMIN;
                header('Location:' . DIRADMIN . 'login?redirect=' . $redirect);
            }
        }
    }
    public function verify_user()
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("SELECT * FROM users WHERE email = ?");
            $query->execute(array($user->email));
             DatabaseController::disconnect();
            $result = $query->fetch(PDO::FETCH_OBJ);
            if ($result) {
                if (password_verify($user->password, $result->password)) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (PDOException $e) {
        }
    }
    public static function isValidEmail($email)
    {
        global $connection;
        $query = $connection->prepare("SELECT * FROM users WHERE `email` = ?");
        $query->execute(array($email));
        $result = $query->fetch(PDO::FETCH_OBJ);
        $is_valid = true;
        if ($result) {
            $is_valid = false;
        }
        return $is_valid;
    }
    public function getUserCreateEmailMessage()
    {
        $message =
            '
                <p>Dear ' . $this->user->first_name . ',<p>
                <p>An account has been created for you. Your account credentials are provided below</p>';
        $credentials =
            '
                <p>Email: <strong>' . $this->user->email . '</strong></p>
                <p>Password: <strong>' . $this->user->password . '</strong></p>';


        $email_body = array();
        $email_body[] = array(
            "type" => "body",
            "content" => $message
        );
        $email_body[] = array(
            "type" => "more_details",
            "content" => $credentials,
        );
        $email_body[] = array(
            "type" => "body",
            "content" => "<p>Click the link below to log in</p>"
        );
        $email_body[] = array(
            "type" => "button",
            'link' => DIRADMIN,
            'action' => "Login"
        );

        return $email_body;
    }
}

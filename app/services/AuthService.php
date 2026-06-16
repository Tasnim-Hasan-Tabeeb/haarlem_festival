<?php

namespace App\Services;

use App\Helpers\Validator;
use App\Models\Role;
use App\Repositories\UserRepository;
use App\Traits\Fileable;
use Exception;
use PDOException;
use PHPMailer\PHPMailer\PHPMailer;

class AuthService
{
    use Fileable;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * Summary of authenticateUser
     */
    public function authenticateUser()
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string'
        ];

        Validator::validate($_POST, $rules);

        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $user = $this->userRepository->authenticateUser($username, $password);
        if ($user) {
            return $user;
        }
        return null;
    }

    /**
     * Summary of setSession
     * @param mixed $user
     * @return void
     */
    public function setSession($user)
    {
        $_SESSION['user']            = $user;
        $_SESSION['username']        = $user['name'];
        $_SESSION['role']            = $user['role'];
        $_SESSION['profile_picture'] = $user['profile_picture'];
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Summary of hashPassword
     * @param mixed $password
     * @return string
     */
    public function hashPassword($password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @throws Exception
     */
    public function handleUserImage($image)
    {
        try {
            $ext          = pathinfo($image['name'], PATHINFO_EXTENSION);
            $newImageName = uniqid() . '.' . $ext;
            $upload_dir   = __DIR__ . '/../public/images/';
            if (!move_uploaded_file($image['tmp_name'], $upload_dir . $newImageName)) {
                throw new Exception('Failed to move uploaded file.');
            }
            return $newImageName;
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * Summary of registerUser
     * @return bool
     */
    public function registerUser(): bool
    {
        $rules = [
                'name'            => 'required|string|max:120',
                'email'           => 'required|email',
                'password'        => 'required|string|min:6|confirmed',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        Validator::validate($_POST, $rules);

        $name     = htmlspecialchars($_POST['name']);
        $email    = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $role     = Role::Customer();

        $newUser = [
            'name'            => $name,
            'email'           => $email,
            'password'        => $this->hashPassword($password),
            'profile_picture' => '/images/default.php',
            'role'            => $role
        ];
        $newUser['profile_picture'] = '/images/default.php';

        if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $newUser['profile_picture'] = $this->uploadImage($_FILES['profile_picture']);
        }

        if ($this->checkIfUserExists(htmlspecialchars($email))) {
            throw new Exception('User already exists');
        }

        if (!$this->isStrongPassword(htmlspecialchars($password))) {
            throw new Exception('Password must be at least 6 characters long and include uppercase, lowercase, number, and special character.');
        }

        return $this->userRepository->registerUser($newUser);
    }

    /**
     * Summary of checkIfUserExists
     * @param mixed $email
     */
    public function checkIfUserExists($email)
    {
        return $this->userRepository->checkUserExistenceByEmail($email);
    }

    /**
     * Summary of captchaVerification
     * @return bool
     */
    public function captchaVerification()
    {
        $secret   = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';
        $response = $_POST['g-recaptcha-response'];
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $url      = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
        $data     = file_get_contents($url);
        $row      = json_decode($data);
        return $row->success == 'true';
    }

    /**
     * Summary of getUserByEmail
     * @param mixed $email
     * @throws Exception
     */
    public function getUserByEmail($email)
    {
        try {
            return $this->userRepository->getUserByEmail($email);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of resetPassword
     * @param mixed $email
     * @param mixed $password
     * @param mixed $token
     * @throws Exception
     * @return bool
     */
    public function resetPassword($email, $password, $token)
    {
        if ($token !== $_SESSION['password_reset_token']) {
            throw new Exception('Invalid token.');
        }
        try {
            $result = $this->userRepository->resetPassword($email, $password);
            unset($_SESSION['password_reset_token']);
            unset($_SESSION['email']);

            return true;
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of isValidEmail
     * @param mixed $email
     * @return bool
     */
    public function isValidEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Check if password is strong
     *
     * Requirements:
     * - Minimum 6 characters
     * - At least 1 uppercase letter
     * - At least 1 lowercase letter
     * - At least 1 number
     * - At least 1 special character
     *
     * @param string $password
     * @return bool
     */
    public function isStrongPassword($password): bool
    {
        return preg_match(
            '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/',
            $password
        ) === 1;
    }

    /**
     * Summary of sendResetPasswordEmail
     * @param mixed $email
     * @param mixed $reset_link
     * @param mixed $mailConfig
     * @return bool
     */
    public function sendResetPasswordEmail($email, $reset_link, $mailConfig): bool
    {
        $user = $this->getUserByEmail($email);
        $name = $user['name'];

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $mailConfig['host'];
            $mail->SMTPAuth   = $mailConfig['SMTPAuth'];
            $mail->Username   = $mailConfig['username'];
            $mail->Password   = $mailConfig['password'];
            $mail->SMTPSecure = $mailConfig['SMTPSecure'];
            $mail->Port       = $mailConfig['port'];

            // Recipients
            $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Dear $name,<br><br>Click the following link to reset your password: <a href='$reset_link'>$reset_link</a>";

            $mail->send();

            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    /**
     * Summary of updatePassword
     * @param mixed $email
     * @param mixed $password
     * @param mixed $token
     * @throws Exception
     * @return bool
     */
    public function updatePassword($email, $password, $token)
    {
        if ($token !== $_SESSION['password_reset_token']) {
            throw new Exception('Invalid token.');
        }
        try {
            $this->userRepository->resetPassword($email, $password);
            unset($_SESSION['password_reset_token']);
            unset($_SESSION['email']);

            return true;
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of isPasswordUpdateRequest
     * @return bool
     */
    public function isPasswordUpdateRequest(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['token']) && isset($_SESSION['password_reset_token']) && isset($_SESSION['email']) && $_GET['token'] === $_SESSION['password_reset_token'];
    }
}

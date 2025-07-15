<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #fbecec;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-box {
        width: 350px;
        padding: 30px;
        background: #fff2f2;
        border-left: 6px solid #b05b5b;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    h2 {
        text-align: center;
        color: #741b1b;
        margin-bottom: 20px;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 12px 0;
        border: 1px solid #c99797;
        border-radius: 6px;
        background: #fffafa;
        box-sizing: border-box;
        font-size: 14px;
        transition: border 0.3s ease;
    }

    input:focus {
        border-color: #a94442;
        outline: none;
        box-shadow: 0 0 4px rgba(169, 68, 66, 0.2);
    }

    button {
        width: 100%;
        padding: 10px;
        background: #a94442;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background: #822626;
    }

    a {
        text-decoration: none;
        color: #992e2e;
        font-size: 13px;
        display: block;
        text-align: center;
        margin-top: 10px;
        transition: color 0.2s ease;
    }

    a:hover {
        color: #6b1414;
        text-decoration: underline;
    }

    p {
        text-align: center;
        font-size: 14px;
        color: #c0392b;
        margin-bottom: 0;
    }
</style>

</head>
<body>
    <div class="login-box">
        <h2>LOGIN</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = sha1($_POST['password']);

            $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                $_SESSION['user'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: index.php");
                exit();
            } else {
                echo "<p style='color:red;'>Invalid login credentials.</p>";
            }
        }
        ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="signup.php">Don't have an account? Sign up</a>
        <a href="forgot_password.php">Forgot your password?</a>
    </div>
</body>
</html>

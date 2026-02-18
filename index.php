<?php
session_start(); // Session start

// Agar already login hai to dashboard redirect
if(isset($_SESSION['admin_id'])){
    header("Location: dashboard.php");
    exit;
}

include 'includes/db_connect.php';

// Login process
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if($stmt->rowCount() == 1){
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hostel Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* === Global Styles === */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        /* === Animated Background === */
        body::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.05) 25%, transparent 25%),
                        radial-gradient(circle at 75% 75%, rgba(255,255,255,0.05) 25%, transparent 25%);
            background-size: 50px 50px;
            animation: moveBackground 20s linear infinite;
            z-index: 0;
        }

        @keyframes moveBackground {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* === Card Styling === */
        .card {
            border: none;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.5);
            transition: all 0.4s ease;
            z-index: 1;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 50px rgba(0, 0, 0, 0.6);
        }

        /* === Heading === */
        .card-title {
            font-weight: 700;
            color: #fff;
            text-align: center;
            font-size: 2rem;
            text-shadow: 0 2px 10px rgba(255,255,255,0.3);
        }

        /* === Form Fields === */
        label {
            color: #e0e0e0;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
            border: none;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 10px rgba(255,255,255,0.3);
            color: #fff;
        }

        /* === Button === */
        .btn-primary {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: 12px 0;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,114,255,0.4);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
            box-shadow: 0 6px 20px rgba(0,114,255,0.5);
            transform: translateY(-2px);
        }

        /* === Error Message === */
        .alert-danger {
            border: none;
            border-radius: 10px;
            background: rgba(255, 0, 0, 0.2);
            color: #ffaaaa;
            text-align: center;
            font-weight: 500;
        }

        .card-body {
            padding: 2rem;
        }

        /* === Responsive === */
        @media (max-width: 768px) {
            .card {
                margin: 0 1rem;
                border-radius: 15px;
            }

            .card-title {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem;
            }
        }

        /* === Subtle Appear Animation === */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            animation: fadeIn 1s ease-in-out;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title mb-4">Admin Login</h3>

                    <?php if(isset($error)){ ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>

                    <form method="post">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

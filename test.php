

<!DOCTYPE html>
<html>
<head>
    <title>My Contact Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: skyblue;
    }
    .contact-info {
        width: 300px;
        margin: 0 auto;
        text-align: center;
    }
    .contact-info img {
        width: 100%;
        height: auto;
    }
    .contact-info h1 {
        font-size: 24px;
        margin-bottom: 20px;
    }
    .contact-info p {
        font-size: 18px;
        margin-bottom: 10px;
    }
</style>
</head>
<body>
    <div class="contact-info">
        <img src="us.jpeg" alt="Icon">
        <h1>Contact Information</h1>
        <p>Name: John Doe</p>
        <p>Phone Number: <span id="phone-number">(123) 456-7890</span> <i class="fas fa-copy" onclick="copyPhoneNumber()"></i></p>
        <p>Email: john.doe@example.com</p>
    </div>
    <script>
        function copyPhoneNumber() {
            var phoneNumber = document.getElementById('phone-number').textContent;
            navigator.clipboard.writeText(phoneNumber);
        }
    </script>
</body>
</html>

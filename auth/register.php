<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Register RentGo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

body{

min-height:100vh;

background:
linear-gradient(
rgba(0,0,0,.75),
rgba(0,0,0,.75)
),
url('../assets/img/hero.jpg');

background-size:cover;
background-position:center;

display:flex;
align-items:center;
justify-content:center;

padding:40px 0;
}

.register-box{

width:500px;

background:rgba(10,10,10,.92);

backdrop-filter:blur(20px);

border:1px solid rgba(212,175,55,.3);

border-radius:25px;

padding:40px;
}

.logo{

font-size:42px;

font-weight:800;

color:#d4af37;

text-align:center;

margin-bottom:10px;
}

.subtitle{

text-align:center;

color:#bbb;

margin-bottom:30px;
}

.form-control{

height:55px;

background:#111;

border:1px solid #333;

color:white;
}

.form-control:focus{

background:#111;

color:white;

border-color:#d4af37;

box-shadow:none;
}

.btn-gold{

background:#d4af37;

color:#000;

font-weight:700;

height:55px;

border:none;

border-radius:12px;
}

.btn-gold:hover{

background:#c79e20;
}

a{

color:#d4af37;

text-decoration:none;
}

</style>

</head>
<body>

<div class="register-box">

<div class="logo">
RentGo
</div>

<div class="subtitle">
Create Your Premium Account
</div>

<form action="proses_register.php" method="POST">

<div class="mb-3">
<input type="text"
name="nama"
class="form-control"
placeholder="Nama Lengkap"
required>
</div>

<div class="mb-3">
<input type="email"
name="email"
class="form-control"
placeholder="Email"
required>
</div>

<div class="mb-4">
<input type="password"
name="password"
class="form-control"
placeholder="Password"
required>
</div>

<button type="submit"
class="btn btn-gold w-100">

Daftar Sekarang

</button>

</form>

<div class="text-center mt-4">

Sudah punya akun?

<a href="login.php">

Login

</a>

</div>

</div>

</body>
</html>
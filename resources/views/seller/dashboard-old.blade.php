<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard</title>
</head>
<body>
    <h1>Welcome Seller, {{ Auth::user()->name }}</h1>
    <p>Email: {{ Auth::user()->email }}</p>
    <a href="{{ route('logout') }}">Logout</a>
</body>
</html>

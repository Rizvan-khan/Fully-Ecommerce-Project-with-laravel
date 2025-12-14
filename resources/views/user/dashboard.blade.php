<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome User, {{ Auth::user()->name }}</h1>
    <p>Email: {{ Auth::user()->email }}</p>
    <a href="{{ route('logout') }}">Logout</a>
</body>
</html>

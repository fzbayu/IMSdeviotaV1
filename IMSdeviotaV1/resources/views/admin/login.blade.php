<h2>Login Admin</h2>
<form action="{{ route('admin.login.submit') }}" method="POST">
    @csrf
    <label>Username:</label>
    <input type="text" name="username" required><br><br>

    <label>Password:</label>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

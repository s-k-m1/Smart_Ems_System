<h1>Add Employee</h1>

<form method="POST" action="/employees">
    @csrf

    <label>Name</label>
    <input type="text" name="name"><br><br>

    <label>Email</label>
    <input type="email" name="email"><br><br>

    <label>Department</label>
    <input type="text" name="department"><br><br>

    <label>Position</label>
    <input type="text" name="position"><br><br>

    <label>Basic Salary</label>
    <input type="number" name="basic_salary"><br><br>

    <button type="submit">Save Employee</button>
</form>
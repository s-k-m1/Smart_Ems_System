<h1>Generate Payroll</h1>
<form method="POST" action="/payroll">
    @csrf
    <label>Employee</label>
    <select name="employee_id" >
        @foreach($employees as $employee)
        <option value="{{$employee->id}}">
            {{$employee->name}}
        </option>
        @endforeach
    </select>
    <br><br>
    <label >Month</label>
    <input type="text" name="month">
    <br><br>
    <label > Year</label>
    <input type="number" name="year">
    <br><br>
    <label > Bonus</label>
    <input type="number" name="bonus">
    <br><br>
    <label > Unpaid Leave Days</label>
    <input type="number" name="unpaid_leave_days">
    <br><br>
    <input type="submit" value="Generate Payroll">
</form>
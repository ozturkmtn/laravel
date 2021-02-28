<h1>User Account</h1>

@if($errors->any())
<div>
    <ul>
        @foreach($errors->all() as $err)
            <li>{{$err}}</li>
        @endforeach
    </ul>
</div>
@endif


<form action="usercontroller" method="post">
    {{@csrf_field()}}
    <input type="text" name="email">
    <br>
    <br>
    <input type="password" name="password">
    <br>
    <br>
    <button type="submit" >Submit</button>
</form>

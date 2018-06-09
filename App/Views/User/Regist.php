<form class="w-25 mx-auto my-5" action="/user/regist" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">First Name</label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="first_name" placeholder="First Name">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Last Name</label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="last_name" placeholder="Last Name">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp"
               placeholder="Email">
    </div>

     <div class="form-group">
        <label for="exampleInputEmail1">Login</label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="login" aria-describedby="emailHelp"
               placeholder="Login">
    </div

    <div class="form-group">
        <label for="exampleInputEmail1">Role</label>
        <select name="role" class="form-control">
            <?
            foreach (self::$data['roles'] as $role) {
                $name = ucfirst($role['name']);
                echo "<option value='{$role['id']}'>$name</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <?
    if(self::$data['e_message']) {
      echo "<div class='my-5 mx-auto alert alert-danger' role='alert'>";
      echo  self::$data['e_message'];
      echo "</div>";
    }
    ?>
</form>

<form class="w-25 mx-auto my-5" action="/head/createHead" method="post">

    <div class="form-group">
        <label for="exampleInputEmail1">Parent</label>
        <select name="parentName" class="form-control">
            <?
            foreach (self::$data['parentHeads'] as $head) {
                $name = ucfirst($head['name']);
                echo "<option value='{$head['id']}'>$name</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" class="form-control"  name="name" placeholder="Name">
    </div>

    <button type="submit" class="btn btn-primary">Add</button>
</form>

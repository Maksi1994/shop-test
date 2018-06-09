<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">Admin Panel</a>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav nav-pills w-100 mr-auto mt-2 mt-lg-0">
      <li class="nav-item dropdown mr-2">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown"
      href="/controllProducts/showAll" role="button" aria-haspopup="true" aria-expanded="false">Products</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="/controllProducts/showAll">Administer products</a>
        <a class="dropdown-item" href="/controllProducts/showFormAdd">Add products</a>
        <a class="dropdown-item" href="/controllProducts/showFormCategories">Administer categories</a>
      </div>
      </li>

      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Customers & Orders</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">All Orders</a>
      </div>
      </li>

      <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        <?if (!USER['auth']) {?>
        <li class="nav-item active">
          <a class="nav-link" href="/user/login">Login</a>
        </li>
      <?}?>
      <?if (USER['auth']) {?>
      <li class="nav-item active">
        <a class="nav-link" href="/user/logout">Logout</a>
      </li>
    <?}?>
      </ul>
    </ul>
  </div>
</nav>

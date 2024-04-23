<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item"><a class="nav-link" href="/get_posts.php">Get Posts</a></li>
        <?php
        if(isset($_COOKIE['username']) && $_COOKIE['admin'] == 'true') {
            echo '<li class="nav-item"><a class="nav-link" href="/users.php">Users</a></li>';
        }
        ?>
        <?php
        if(isset($_COOKIE['username'])) {
            echo '<li class="nav-item"><a class="nav-link" href="/insertpost.php">Add Post</a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="/logout.php">Logout</a></li>';
        } else {
            echo '<li class="nav-item"><a class="nav-link" href="/login.php">Login</a></li>';
        }
        ?>
    </ul>
    <form class="d-flex" role="search" action="post_search.php">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="keyword">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
</nav>
</nav>
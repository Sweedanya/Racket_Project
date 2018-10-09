    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <form id="signin" class="navbar-form navbar-right" role="form" method="post" action="">
                <?php if(isset($_SESSION["email"])): ?>
                <div class="container">
                    <form class="form-inline"action="" method="post">
                        <div class="form-group">
                            <label for="logout"><?php echo "Hi, $_SESSION[first_name]  $_SESSION[last_name]";?></label>
                            <button id="logout" name="logout">Logout</button>
                        </div>
                    </form>
                </div>
                <?php else: ?>                
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="email" type="email" class="form-control" name="email" value="" placeholder="Email Address">
                </div>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="pwd" value="" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-primary" name="login">Login</button>
                <?php endif; ?>
            </form>
            
        </div>
    </div>
</nav>
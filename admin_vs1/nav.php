<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="login.php">Voting System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Dashboard
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <?php
          include "session.php";
           if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3){
             ?>
            <a class="nav-link" href="#" onclick="logout()" >Logout</a>
             <?php
           }
           else {
             ?>
               <a class="nav-link" href="login.php">Login</a>
             <?php
           }
           ?>

        </li>
         <?php
                  if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3){
                        ?>

                  <li class="nav-item">
                      <a class="nav-link" href="changepassword.php">Profile</a>
                  </li>

                        <?php
                      }
         ?>
        <li class="nav-item">
          <?php
           if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3){
             ?>
             <a class="nav-link" href="records.php">Records</a>
             <?php
           }
           else {
             ?>
             <?php
           }
           ?>
        </li>
          <li class="nav-item">
              <?php
              if(!empty($_SESSION['id']) && $_SESSION['user_role'] == 3){
                  ?>
                  <a class="nav-link" href="adddata.php">Add New Voter</a>
                  <?php
              }
              else {
                  ?>

                  <?php
              }
              ?>
          </li>
      </ul>
    </div>
  </div>
</nav>

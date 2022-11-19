<?php 
include('server.php');
if(!isset($_SESSION['id'])) header('location:logIn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>

                    <!-- Font Awesome -->
                <link
                href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
                rel="stylesheet"
                />
                <!-- Google Fonts -->
                <link
                href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
                rel="stylesheet"
                />
                <!-- MDB -->
                <link
                href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css"
                rel="stylesheet"
                />
                
                <style>
                    body {
  background-color: #fbfbfb;
}
@media (min-width: 991.98px) {
  main {
    padding-left: 240px;
  }
 
}

/* Sidebar */
.sidebar {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  padding: 58px 0 0; /* Height of navbar */
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
  width: 240px;
  z-index: 600;
}

@media (max-width: 991.98px) {
  .sidebar {
    width: 100%;
  }

}
.sidebar .active {
  border-radius: 5px;
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
}

.sidebar-sticky {
  position: relative;
  top: 0;
  height: calc(100vh - 48px);
  padding-top: 0.5rem;
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}



</style>

</head>
<body>
 <!-- Sidebar -->
 <nav id="sidebarMenu" class="  collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
          <a
            href="dashboaed.php"
            class="list-group-item list-group-item-action py-2 ripple"
            
          >
          🏠 Main dashboard
          </a>
          <a href="profileSettings.php" class="list-group-item list-group-item-action py-2 ripple ">
          👨‍💼 My profile
          </a>
          <a href="bookmodifs.php" class="list-group-item list-group-item-action py-2 ripple ">
          📚 Book modifications
          </a>
          <form >
          <button type="submit" name="logout" class="list-group-item list-group-item-action py-2 ripple  ">
            🚪🚶 log out 
          </button>
          </form>
            </div>
          
            
   
        </div>
      </div>
    </nav>
    <!-- Sidebar -->
  
    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <!-- Container wrapper -->
      <div class="container-fluid">
        <!-- Toggle button -->
        <button
          class="navbar-toggler"
          type="button"
          data-mdb-toggle="collapse"
          data-mdb-target="#sidebarMenu"
          aria-controls="sidebarMenu"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <i class="fas fa-bars"></i>
        </button>
  
        <!-- Brand -->
        <a class="navbar-brand" href="dashboaed.php">
          <img
            src="pics/icons8-bookcase-48.png"
            height="30"
            alt="MDB Logo"
            loading="lazy"
          /><h3 class="mb-0" >Books</h3>
        </a>
        <!-- Right links -->
        <ul class="navbar-nav ms-auto d-flex flex-row">
          <!-- Avatar -->
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center"
              href="#"
              id="navbarDropdownMenuLink"
              role="button"
              data-mdb-toggle="dropdown"
              aria-expanded="false"
            >
              <img
                src="pics/icons8-administrator-male-48.png"
                class="rounded-circle"
                height="30"
                alt="Avatar"
                loading="lazy"
              />
            </a>
            <ul
              class="dropdown-menu dropdown-menu-end"
              aria-labelledby="navbarDropdownMenuLink"
            >
              <li>
                <a class="dropdown-item" href="profileSettings.php">My profile</a>
              </li>
             
            </ul>
          </li>
        </ul>
      </div>
      <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
  </header>
  <!--Main Navigation-->
  
  <!--Main layout-->
  <main style="margin-top: 58px;">

    <ol class="breadcrumb pt-3 ps-3 h5">
      <li class="breadcrumb-item active" aria-current="page"><a href="dashboaed.php">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">my profile</li>
    </ol>
    <h3 class=" ps-3 ">
      My profile
    </h3>

    <?php 
      include('connection.php');
      $userId=$_SESSION['id']; 

      $requete= "SELECT * from admin WHERE id = $userId";
      $query=mysqli_query($linkDB , $requete);
      $rows=mysqli_fetch_assoc($query);

                    ?>

    <div class="container rounded bg-white mt- mb-5">
      <div class="row">
          <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"><?php echo $_SESSION["name"]; ?></span><span class="text-black-50"> <?php echo $_SESSION["email"];?> </span><span> </span></div>
          </div>
          <div class="col-md-9 border-right">
              <div class="p-3 py-5">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                      <h4 class="text-right">Settings</h4>
                  </div>
                  <div class="row mt-2">
                      <div class="col-md-6"><label class="labels">Name</label><input type="text" class="form-control" placeholder="first name" value="<?php echo $rows['first_name']; ?>"></div>
                      <div class="col-md-6"><label class="labels">Surname</label><input type="text" class="form-control" value="<?php echo $rows['last_name']; ?>" placeholder="surname"></div>
                  </div>
                  <div class="row mt-3">
                      <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text" class="form-control" placeholder="enter phone number" value=""></div>
                      <div class="col-md-12"><label class="labels">Email ID</label><input type="text" class="form-control" placeholder="enter email id" value="<?php echo $rows['email']; ?>"></div>
                      <div class="col-md-12"><label class="labels">password</label><input type="text" class="form-control" placeholder="enter new password" value="<?php echo $rows['user_password']; ?>"></div>
                      <div class="col-md-12"><label class="labels">confirme password</label><input type="text" class="form-control" placeholder="confirme password" value="<?php echo $rows['user_password']; ?>"></div>

                  </div>
                 
                  <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div>
              </div>
          </div>
         
      </div>
  </div>
  </div>
  </div>
         
  </main>
  <!--Main layout-->
                
  
              <script
                type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"
                ></script>
  
    
  
</body>
</html>
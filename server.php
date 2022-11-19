<?php

session_start();

    //PHP code to logout user from website
    if(isset($_GET['logout']))  logout() ;
    if(isset($_POST['save_book']))   saveBook();
    if(isset($_GET['delete']))  deleteTask();
    if(isset($_GET['update']))  updateBook();
$error="";
$error3="";
if(array_key_exists('SignUp',$_POST)){
    include('connection.php');

    //header("Location: dashboaed.php");

    //taking data frome user
    $Fname = mysqli_real_escape_string($linkDB,$_POST['Firstname']);
    $Lname = mysqli_real_escape_string($linkDB,$_POST['Lastname']);
    $Email = mysqli_real_escape_string($linkDB,$_POST['YourEmail']);
    $Password = mysqli_real_escape_string($linkDB,$_POST['Password']);
    $RPassword = mysqli_real_escape_string($linkDB,$_POST['Repeatyourpassword']);
    //data filter
    if(!$Fname){
        $error .= "first name is required <br>";
    }
    if(!$Lname ){
        $error .= " last name is required<br>";
    }
    if(!$Email){
        $error .= "Email faild is empty <br>";
    }
    if(!$Password ){
        $error .= "password is faild is empty<br>";
    }
    if($Password !== $RPassword ){
        $error .= "passwords did not matched ! <br>";
    }

    if ($error){
        $error = "there was following errors in your form ".$error;
    }else{
        //check if the email is already exist in database 
        $queary = "SELECT id From admin where email = '$Email' ";
        $result = mysqli_query($linkDB,$queary);
        if(mysqli_num_rows($result)>0){
            $error = "your email is already exist <br>";

        }else{
            //password encryption 
            $hashedPassword= password_hash($Password,PASSWORD_DEFAULT);
            $queary= "INSERT INTO admin (`first_name`, `last_name`, `email`, `user_password`) VALUES ('$Fname','$Lname','$Email','$hashedPassword')";
            $result = mysqli_query($linkDB,$queary);
            if (!$result){

                $error = " you are not logged in -try again later ";

            }else{
                // $_SESSION['id']= mysqli_insert_id($linkDB);
                // $_SESSION['first_name']= mysqli_insert_id($linkDB);
                // $_SESSION['last_name']= mysqli_insert_id($linkDB);
                echo " you are signed up <br>";
                header("Location: logIn.php");

            }

        }
    }
   
}


// -------User Login PHP Code ------------
$error2="";

if (array_key_exists("logIn", $_POST)) {
    
    // Database Link
    include('connection.php'); 
 
      //Taking form Data From User
      $email = mysqli_real_escape_string($linkDB, $_POST['email']);
      $password = mysqli_real_escape_string($linkDB,  $_POST['password']); 
       
      //Check if input Field are empty
      if (!$email) {
          $error2 .= "Email is required <br>";
       }
      if (!$password) {
          $error2 .= "Password is required <br>";
       } 
       if ($error2) {
          $error2 = "<b>There were error(s) in your form!</b><br>".$error2;
       }
        
      else {        
          //matching email and password
 
            $query = "SELECT * FROM admin WHERE email='$email'";
            $result = mysqli_query($linkDB, $query);
            $row = mysqli_fetch_array($result);
         
            if (isset($row)) {
                 
                if (password_verify($password, $row['user_password'])) {
                    
                    //session variables to keep user logged in

                    $_SESSION['id'] = $row['id'];  
                    $_SESSION["name"] = $row["first_name"]." ".$row["last_name"] ;
                    $_SESSION["email"] = $row["email"] ;

                    header("Location: dashboaed.php");

                } else {
                    $error2 = "Combination of email/password does not match!";
                     }
   
            }  else {
                $error2 = "Combination of email/password does not match!";
                 }
        }

      
    }




function logout(){  

    unset($_SESSION["name"]);
    session_destroy();
    header("Location:logIn.php");
    exit();
}







 // if you push the button save 

 function saveBook(){ 
    include('connection.php');  
    global $linkDB;
    //CODE HERE

    //  saving inputs that the user writed in the modal into database by using (1) and (2)

    //(1) import iput values from modal



    if(empty($_POST['title'] && $_POST['writer'] && $_POST['type'] && $_POST['date'] && $_POST['about'] && $_POST['price'])){
        $_SESSION['errore']=" please fill all the modal inputs. ";
        header("location:bookmodifs.php");
    }else{
    $title=$_POST['title'];
    $writer=$_POST['writer'];
    $type=$_POST['type'];
    $date=$_POST['date'];
    $about=$_POST['about'];
    $price=$_POST['price'];
    $quantity=$_POST['quantity'];
  

    // (2) SQL INSERT
    
    $req= "INSERT INTO `books`(`quantity`,`book_name`,`writer_name`,`book_type`,`book_date`,`about`,`price`) VALUES ('$quantity','$title','$writer','$type','$date','$about','$price')";

    mysqli_query($linkDB,$req);
   
   $_SESSION['message'] = "Book has been added successfully !";
   header('location: bookmodifs.php');
    }
    

 }



 function getbooks(){

    include('connection.php');
    $userId=$_SESSION['id']; 

    $requete= "SELECT * from books ";
    $query=mysqli_query($linkDB , $requete);
   
while($rows=mysqli_fetch_assoc($query)){

  ?>  
  
  
  
  <tbody>
        <tr>
          
          <td>

            <div class="d-flex align-items-center ">
              <img
                  src="pics/Green_Book_poster.jpg"
                  alt="bookpic"
                  style="width: auto; height: 200px"
                  class="rounded-2"
                  />
            <div class="ms-3">
                <p class="fw-bold mb-1">🌟<span class="h5 idoftab"><?php echo $rows['id']; ?></span><span class="nameoftabl"><?php echo $rows['book_name']; ?></span></p>
            </div>
            </div>
          </td>

          <td>
            <p class="fw-normal mb-1 writeroftab"><?php echo $rows['writer_name']; ?></p>
            
          </td>
           <td>
            <span class="badge badge-success rounded-pill d-inline typeoftab"><?php echo $rows['book_type']; ?></span>
          </td>
          <td class="dateoftab"><?php echo $rows['book_date']; ?></td>
          <td class="abuotoftab"><?php echo $rows['about']; ?></td>
          <td class="dateofquantity"><?php echo $rows['quantity']; ?></td>
          <td class="dateofprice"><?php echo $rows['price']; ?> DH</td>

          <td>
            <button type="button" class=" m-2 btn  btn-l btn-info btn-rounded" data-mdb-toggle="modal" data-mdb-target="#modalform">update</button>
            <span class="m-2 btn  btn-danger btn-rounded  " > <a class="text-decoration-none text-light " href="bookmodifs.php? delete='<?php echo $rows['id'] ?>'" >Delete</a> </span>
             
            </button>
          </td>
        </tr>

        
      </tbody>
 <?php 
 }
?>
      
 <?php 
 }

function updateBook(){

    include('connection.php');
    global $linkDB ;
    //CODE HERE

    // id of book you want to delete,got it from the delete button


    $title=$_POST['title'];
    $writer=$_POST['writer'];
    $type=$_POST['type'];
    $date=$_POST['date'];
    $about=$_POST['about'];
    $price=$_POST['price'];
    $quantity=$_POST['quantity'];
    $bookId = $_GET['update'];
    //SQL DELETE 
    mysqli_query($linkDB ," UPDATE `books` SET ``book_name`='$title',`writer_name`='$writer',`book_type`='$type',`admin_id`='$date',`book_date`='$date',`about`='$about',`quantity`='$quantity',`price`='price' WHERE books.id = $bookId");




}



 function deleteBook(){
    include('connection.php');
    global $linkDB ;
    //CODE HERE

    // id of book you want to delete,got it from the delete button

    $id_book = $_GET['delete'];

    //SQL DELETE 
    mysqli_query($linkDB, "DELETE FROM books WHERE books.id = $id_book");


    $_SESSION['message'] = "Task has been deleted successfully !";
    header('location:bookmodifs.php');
}

// counter of buttons in every task 

function countT(){

    include('connection.php');
    global $linkDB ;
    //SQL COUNTER OF 
    $sql = "SELECT count(*) FROM books"; 
    $result = mysqli_query($linkDB, $sql);
    $row =mysqli_fetch_array($result);
    echo  $row[0];
   
}


function adminscount(){

    include('connection.php');
    global $linkDB ;
    //SQL COUNTER OF
    $sql = "SELECT count(*) FROM admin"; 
    $result = mysqli_query($linkDB, $sql);
    $row =mysqli_fetch_array($result);
    echo  $row[0];
   
}

// function adminscount(){

//     include('connection.php');
//     global $linkDB ;
//     //SQL COUNTER OF
//     $sql = "SELECT count(*) FROM admin"; 
//     $result = mysqli_query($linkDB, $sql);
//     $row =mysqli_fetch_array($result);
//     echo  $row[0];
   
// }
  




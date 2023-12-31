<?php require("./config/db.php"); 

if(isset($_COOKIE['email']) && isset($_COOKIE['user_id'])){
   
    $email = $_COOKIE['email'];
    $user_id = $_COOKIE['user_id'];

}else{
    header("location: index.php");
    die;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="Home Page" />
    <title>Chatpro | Users</title>
    <link rel="stylesheet" href="css/chat.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
<script type="module" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule="" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  
    <script src="./js/jquery.js"></script>
    <script src="./js/bootstrap.min.js"></script>
  
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    
    
  </head>
<body>


<div class="users-container">
  <div class="logged-in-user">
    <?php  
        if(isset($_COOKIE['email']) && isset($_COOKIE['user_id'])){
            $query_user = mysqli_query($conn, "SELECT * FROM user_info WHERE email='$email' AND userId='$user_id'");

            $data =mysqli_fetch_assoc($query_user);

    ?>
        <div class="user-img" style="background:url('user_img_uploads/<?php echo $data['user_img']; ?>'); background-size:cover;background-position:center;"></div>
        <div class="user-action">
        <button class="button" id="formuploadbtn">
            <span></span><ion-icon class="uploadicon" name="cloud-upload-outline"></ion-icon></span>
        </button>
        </div>
        <div class="user-info1">
        <p class="username"><?php echo $data['username'];?></p>
        </div>
        <div class="user-info">
       
        <div class="clear-fix">
            <?php if($data['status'] === "On"){?>
                <div class="float-right ml-2">
                <span><ion-icon class="online-circle" name="ellipse"></ion-icon></span>
                </div>
            <?php }?>
        </div>
        <br>
        <div class="logout-cont mt-4">
            <a href="logic/user_logout.php?uid=<?php echo $data['userId']; ?>" class="logout"><ion-icon name="lock-open"></ion-icon>  Logout</a>
        </div>
        </div>

    <?php }?>
  </div>

  <div class="users-fields mt-2">
    <div class="searchbar">
        <form class="form form-group" id="form-upload-cont">
            <input type="text" placeholder="Search available user" id="searchinp" class="searchinp mr-2">

          
            </button>
        </form>
    </div>
    <div class="users-container-section">
      <p id="search-error" class="ml-3"></p>
      <div class="users-cont" id="users-cont"></div>
    </div>
  </div>
</div>


<div id="myModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <p>Upload Profile Pics</p>
      <br>
      <span class="close">&times;</span>
    </div>
    <div class="modal-body">
        <div class="img-preview">
            <img id="img-preview" alt="">
        </div>

        <p class="text-danger upload_err text-center"></p>
        
        <form id="upload_form">
            <input type="file" name="file" id="hidden_file">

            <!-- <button id="file_choose_btn"><ion-icon name="cloud-upload-outline"></ion-icon> Choose file</button> -->
            <!-- <label class="fileval">No file choosen</label> -->

            <button id="file_upload_btn" class="mt-1"><ion-icon name="cloud-upload-outline" type="submit"></ion-icon>Upload file</button>
        </form>
      <hr>
    </div>
  </div>
</div>

<script>
  let searchbtn = document.querySelector(".searchbtn");
  let searchinp = document.querySelector(".searchinp")
  let isclicked = false;

  searchbtn.addEventListener("click", (e)=>{
    e.preventDefault();
    if(isclicked == false){
      searchinp.style.visibility = "visible";
      isclicked = true;
      searchbtn.innerHTML = `<ion-icon name="close-outline"></ion-icon>`;
    }else{
      searchinp.style.visibility = "hidden";
      searchbtn.innerHTML = `<ion-icon name=""></ion-icon>`;
      isclicked = false;
    }  
  });

  let usersSectionCont = document.querySelector(".users-container-section");

  usersSectionCont.style.height = "50vh";
  if(usersSectionCont.style.height == "50vh"){
    usersSectionCont.style.overflowY = "scroll";
  }
</script>

<script src="./js/insert_data.js"></script>
<script src="./js/fetch_user.js"></script>
<br>
<footer id="footer11">
      <!-- <div class="only2">


      <div class="offcanvas offcanvas-start" id="demo">
  <div class="offcanvas-header">
    <h1 class="offcanvas-title">Rate Us</h1>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <p>Hope you enjoyed Chatbook.</p>

    <form id="commentForm">
    <input type="text" id="commentText" placeholder="Write a comment">
    <button type="submit" id="subcom">Submit</button>
    </form>

   

<br>
    <span class="heading">User Rating</span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star"></span>
<p>4.1 average based on 254 reviews.</p>
<hr style="border:3px solid #f1f1f1">

<div class="row">
  <div class="side">
    <div>5 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-5"></div>
    </div>
  </div>
  <div class="side right">
    <div>150</div>
  </div>
  <div class="side">
    <div>4 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-4"></div>
    </div>
  </div>
  <div class="side right">
    <div>63</div>
  </div>
  <div class="side">
    <div>3 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-3"></div>
    </div>
  </div>
  <div class="side right">
    <div>15</div>
  </div>
  <div class="side">
    <div>2 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-2"></div>
    </div>
  </div>
  <div class="side right">
    <div>6</div>
  </div>
  <div class="side">
    <div>1 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-1"></div>
    </div>
  </div>
  <div class="side right">
    <div>20</div>
  </div>
</div>
    <br>
   


  </div>
</div>   -->

<!-- its static removed it -->


<center><p><b> copywrite &copy;</b></p></center>
      <center>  <b> <p>Chatbook all rights has been reserved.</p></b></center>




      
            </div>
            <br>
          </footer>

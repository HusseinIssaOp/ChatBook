
<!-- i got all js and css and php with html in this file for comments -->

<?php
session_start();

$loggedIn = false;

// if (isset($_SESSION['loggedIn']) && isset($_SESSION['name'])) {
//     $loggedIn = true;
// }
if (isset($_SESSION['loggedIn']) && isset($_SESSION['name']) && isset($_SESSION['userID'])) {
    $loggedIn = true;
}

$conn = new mysqli('localhost', 'root', '', 'chatsys');

function createCommentRow($data) {
    global $conn;

    $response = '
            <div class="comment">
                <div class="user">' . $data['username'] . ' <span class="time">' . $data['createdOn'] . '</span></div>
                <div class="userComment">' . $data['comment'] . '</div>
                <div class="reply"><a href="javascript:void(0)" data-commentID="' . $data['id'] . '" onclick="reply(this)">REPLY</a></div>
                <div class="replies">';

    $sql = $conn->query("SELECT replies.id, username, comment, DATE_FORMAT(replies.createdOn, '%Y-%m-%d') AS createdOn FROM replies INNER JOIN user_info ON replies.userID = user_info.id WHERE replies.commentID = '" . $data['id'] . "' ORDER BY replies.id DESC LIMIT 1");
    while ($dataR = $sql->fetch_assoc())
        $response .= createCommentRow($dataR);

    $response .= '
                        </div>
            </div>
        ';

    return $response;
}

if (isset($_POST['getAllComments'])) {
    $start = $conn->real_escape_string($_POST['start']);

    $response = "";
    $sql = $conn->query("SELECT comments.id, username, comment, DATE_FORMAT(comments.createdOn, '%Y-%m-%d') AS createdOn FROM comments INNER JOIN user_info ON comments.userID = user_info.id ORDER BY comments.id DESC LIMIT $start, 20");
    while ($data = $sql->fetch_assoc())
        $response .= createCommentRow($data);

    exit($response);
}

if (isset($_POST['addComment'])) {
    $comment = $conn->real_escape_string($_POST['comment']);
    $isReply = $conn->real_escape_string($_POST['isReply']);
    $commentID = $conn->real_escape_string($_POST['commentID']);

   
    if ($loggedIn && isset($_SESSION['userID'])) {
        if ($isReply != 'false') {
            $conn->query("INSERT INTO replies (comment, commentID, userID, createdOn) VALUES ('$comment', '$commentID', '" . $_SESSION['userID'] . "', NOW())");
            $sql = $conn->query("SELECT replies.id, username, comment, DATE_FORMAT(replies.createdOn, '%Y-%m-%d') AS createdOn FROM replies INNER JOIN user_info ON replies.userID = user_info.id ORDER BY replies.id DESC LIMIT 1");
        } else {
            $conn->query("INSERT INTO comments (userID, comment, createdOn) VALUES ('" . $_SESSION['userID'] . "','$comment',NOW())");
            $sql = $conn->query("SELECT comments.id, username, comment, DATE_FORMAT(comments.createdOn, '%Y-%m-%d') AS createdOn FROM comments INNER JOIN user_info ON comments.userID = user_info.id ORDER BY comments.id DESC LIMIT 1");
        }

        $data = $sql->fetch_assoc();
        exit(createCommentRow($data));
    } else {
        ?>
        <script>
            alert('User not logged in. Please log in to add a comment.');
            window.location.reload();
        </script>
        <?php
        exit(); 
    }
}

// i dont want him to register

// if (isset($_POST['register'])) {
//     $name = $conn->real_escape_string($_POST['name']);
//     $email = $conn->real_escape_string($_POST['email']);
//     $password = $conn->real_escape_string($_POST['password']);

//     if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $sql = $conn->query("SELECT id FROM user_info WHERE email='$email'");
//         if ($sql->num_rows > 0)
//             exit('failedUserExists');
//         else {
//             $ePassword = password_hash($password, PASSWORD_BCRYPT);
//             $conn->query("INSERT INTO user_info (username, email, password, active_at, status) VALUES ('$name', '$email', '$ePassword', NOW(), 'Off')");

//             $sql = $conn->query("SELECT id FROM user_info ORDER BY id DESC LIMIT 1");
//             $data = $sql->fetch_assoc();

//             $_SESSION['loggedIn'] = 1;
//             $_SESSION['name'] = $name;
//             $_SESSION['email'] = $email;
//             $_SESSION['userID'] = $data['id'];

//             exit('success');
//         }
//     } else
//         exit('failedEmail');
// }


if (isset($_POST['logIn'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = $conn->query("SELECT id, password, username FROM user_info WHERE email='$email'");
        if ($sql->num_rows == 0)
            exit('failed');
        else {
            $data = $sql->fetch_assoc();
            $passwordHash = $data['password'];

            if (password_verify($password, $passwordHash)) {
                $_SESSION['loggedIn'] = 1;
                $_SESSION['name'] = $data['username'];
                $_SESSION['email'] = $email;
                $_SESSION['userID'] = $data['id'];

                exit('success');
            } else
                exit('failed');
        }
    } else
        exit('failed');
}


$sqlNumComments = $conn->query("SELECT id FROM comments");
$numComments = $sqlNumComments->num_rows;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comment System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
    body {
        background: linear-gradient(to right, #56ab2f, #a8e063);
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .comment {
        margin-bottom: 20px;
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .user {
        font-weight: bold;
        color: #333;
    }

    .time, .reply {
        color: #888;
    }

    .userComment {
        color: #000;
    }

    .replies .comment {
        margin-top: 20px;
    }

    .replies {
        margin-left: 20px;
    }

    #logInModal,
    #registerModal {
        background: linear-gradient(to right, #56ab2f, #a8e063);
        color: #fff;
    }

    #logInModal .modal-content,
    #registerModal .modal-content {
        background: transparent;
        border: none;
        box-shadow: none;
    }

    #logInModal input,
    #registerModal input {
        margin-top: 10px;
        background: rgba(255, 255, 255, 0.8);
    }

    #logInModal button,
    #registerModal button {
        background: #fff;
        color: #56ab2f;
    }

    #logInModal button:hover,
    #registerModal button:hover {
        background: #a8e063;
        color: #fff;
    }

    .container {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
    }

    .btn-primary {
        background: #56ab2f;
        color: #fff;
    }

    .btn-primary:hover {
        background: #a8e063;
        color: #fff;
    }

    .btn-default {
        background: #fff;
        color: #56ab2f;
    }

    .btn-default:hover {
        background: #e0ffe0;
        color: #56ab2f;
    }

    .replyRow {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        display: none;
    }

    .row {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .iframe-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
    }

    .iframe-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: black; 
    color: black !important; 
    border-radius: 50%; 
}

.visually-hidden {
    color: black; 
}


</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<div class="modal" id="logInModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Log In Form</h5>
            </div>
            <div class="modal-body">
                <input type="email" id="userLEmail" class="form-control" placeholder="Your Email">
                <input type="password" id="userLPassword" class="form-control" placeholder="Password">
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="loginBtn">Log In</button>
                <button class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-12" align="right">
            <?php
            if (!$loggedIn)
                echo '
                        <button class="btn btn-success" data-toggle="modal" data-target="#logInModal">Log In</button>
                ';
            else
                echo '
                    <a href="logout.php" class="btn btn-warning">Log Out</a>
                ';
            ?>
        </div>
    </div>
    <div class="row" style="margin-top: 20px;margin-bottom: 20px;">
        <div class="col-md-12" align="center">
                <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <!-- Image 1 -->
        <div class="carousel-item active">
            <img src="team1.jpg" class="d-block w-70" alt="Image 1">
        </div>
        <!-- Image 2 -->
        <div class="carousel-item">
            <img src="team2.jpg" class="d-block w-70" alt="Image 2">
        </div>
        <!-- Image 3 -->
        <div class="carousel-item">
            <img src="team4.jpg" class="d-block w-70" alt="Image 3">
        </div>
    </div>

   
    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

       
       
            </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <textarea class="form-control" id="mainComment" placeholder="Add Public Comment" cols="30" rows="2"></textarea><br>
            <button style="float:right" class="btn-primary btn" onclick="isReply = false;" id="addComment">Add Comment</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2><b id="numComments"><?php echo $numComments ?> Comments</b></h2>
            <div class="userComments">

            </div>
        </div>
    </div>
</div>

<div class="row replyRow" style="display:none">
    <div class="col-md-12">
        <textarea class="form-control" id="replyComment" placeholder="Add Public Comment" cols="30" rows="2"></textarea><br>
        <button style="float:right" class="btn-primary btn" onclick="isReply = true;" id="addReply">Add Reply</button>
        <button style="float:right" class="btn-default btn" onclick="$('.replyRow').hide();">Close</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript">
    var isReply = false, commentID = 0, max = <?php echo $numComments ?>;

    $(document).ready(function () {
        $("#addComment, #addReply").on('click', function () {
            var comment;

            if (!isReply)
                comment = $("#mainComment").val();
            else
                comment = $("#replyComment").val();

            if (comment.length > 5) {
                $.ajax({
                    url: 'comment.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        addComment: 1,
                        comment: comment,
                        isReply: isReply,
                        commentID: commentID
                    }, success: function (response) {
                        max++;
                        $("#numComments").text(max + " Comments");

                        if (!isReply) {
                            $(".userComments").prepend(response);
                            $("#mainComment").val("");
                        } else {
                            commentID = 0;
                            $("#replyComment").val("");
                            $(".replyRow").hide();
                            $('.replyRow').parent().next().append(response);
                        }
                    }
                });
            } else
                alert('Please Check Your Inputs');
        });

        $("#registerBtn").on('click', function () {
            var name = $("#userName").val();
            var email = $("#userEmail").val();
            var password = $("#userPassword").val();

            if (name != "" && email != "" && password != "") {
                $.ajax({
                    url: 'comment.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        register: 1,
                        name: name,
                        email: email,
                        password: password
                    }, success: function (response) {
                        if (response === 'failedEmail')
                            alert('insert valid email address!');
                        else if (response === 'failedUserExists')
                            alert('User with this email already exists!');
                        else
                            window.location = window.location;
                    }
                });
            } else
                alert('Please Check Your Inputs');
        });

        $("#loginBtn").on('click', function () {
            var email = $("#userLEmail").val();
            var password = $("#userLPassword").val();

            if (email != "" && password != "") {
                $.ajax({
                    url: 'comment.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        logIn: 1,
                        email: email,
                        password: password
                    }, success: function (response) {
                        if (response === 'failed')
                            alert('Please check your login details!');
                        else
                            window.location = window.location;
                    }
                });
            } else
                alert('Please Check Your Inputs');
        });

        getAllComments(0, max);
    });

    function reply(caller) {
        commentID = $(caller).attr('data-commentID');
        $(".replyRow").insertAfter($(caller));
        $('.replyRow').show();
    }

    function getAllComments(start, max) {
        if (start > max) {
            return;
        }

        $.ajax({
            url: 'comment.php',
            method: 'POST',
            dataType: 'text',
            data: {
                getAllComments: 1,
                start: start
            }, success: function (response) {
                $(".userComments").append(response);
                getAllComments((start+20), max);
            }
        });
    }
</script>
<br>
<footer id="footer11">
    <br>
<center><p><b> copywrite &copy;</b></p></center>
      <center>  <b> <p>Chatbook all rights has been reserved.</p></b></center>




      
            </div>
            <br>
          </footer>
</body>
</html>
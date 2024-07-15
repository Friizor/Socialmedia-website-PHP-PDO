

<?php
require("auth.php");
require("connection.php");
// following code
$follower_id = $_SESSION["user_id"];
$following = $db -> prepare("SELECT count(followed_id) as following_num FROM follow WHERE follower_id = :follower_id");
$following -> execute(array("follower_id"=> $follower_id));

$followingCount = $following -> fetch();
?>


<?php
// followers code
$followed_id = $_SESSION["user_id"];
$followers = $db -> prepare("SELECT count(follower_id) as follower_num FROM follow WHERE followed_id = :followed_id");
$followers -> execute(array("followed_id"=> $followed_id));

$followersCount = $followers -> fetch();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   

<?php
 require('header.php');

?>

<div class="profileContainer">

<div class="followers" id="followers">
    <div class="close">
    <img onclick="closeFollowers()" src="icons/close.png" alt="close">
    </div>
    <b>Followers</b><br>
    <?php

$user_id = $_SESSION['user_id'];

$followersP = $db ->prepare ("SELECT users.id as id, users.username, users.email, users.pdp
    FROM users
    JOIN follow ON users.id = follow.follower_id
    WHERE follow.followed_id = :user_id");
    $followersP -> execute(array("user_id"=> $user_id));

    while($peoplefollow = $followersP -> fetch()){


?>
<div class="followersProfile" onclick="window.location.href = 'info.php?id=<?php echo $peoplefollow['id']; ?>'">
            
            <?php
            
if ($peoplefollow['pdp'] === 'default') {
echo '<img src="uploads/default.png" alt="default Image">';
} elseif ($peoplefollow['pdp'] === 'sara') {
echo "<img src='uploads/sara.png' alt='sara Image'>";
} elseif ($peoplefollow['pdp'] === 'dalia') {
echo "<img  src='uploads/dalia.png' alt='dalia Image'>";
}  elseif ($peoplefollow['pdp'] === 'islam') {
echo"<img src='uploads/islam.png' alt='islam Image'>";
}
elseif ($peoplefollow['pdp'] === 'mohamed') {
echo"<img class='image' src='uploads/mohamed.png' alt='mohamed Image'>";
} else {
echo '<img src="uploads/default.png" alt="default Image">';
}

?>
                <div class="followersInfo" >
                <b><?php echo $peoplefollow['username']; ?></b>
                <span><?php echo $peoplefollow['email']; ?></span>
            </div>
            </div>
            <?php } ?>

</div>


    <div class="followers" id="following">

    <div class="close">
    <img onclick="closeFollowing()" src="icons/close.png" alt="close">
    </div>
    <b>following</b><br>
    <?php

$user_id = $_SESSION['user_id'];

$followingP = $db ->prepare ("SELECT users.id as id, users.username, users.email, users.pdp
    FROM users
    JOIN follow ON users.id = follow.followed_id
    WHERE follow.follower_id = :user_id");
    $followingP -> execute(array("user_id"=> $user_id));

    while($peopleIfollow = $followingP -> fetch()){


?>
<div class="followersProfile" onclick="window.location.href = 'info.php?id=<?php echo $peopleIfollow['id']; ?>'">
            
            <?php
if ($peopleIfollow['pdp'] === 'default') {
echo '<img src="uploads/default.png" alt="default Image">';
} elseif ($peopleIfollow['pdp'] === 'sara') {
echo "<img src='uploads/sara.png' alt='sara Image'>";
} elseif ($peopleIfollow['pdp'] === 'dalia') {
echo "<img  src='uploads/dalia.png' alt='dalia Image'>";
}  elseif ($peopleIfollow['pdp'] === 'islam') {
echo"<img src='uploads/islam.png' alt='islam Image'>";
}
elseif ($peopleIfollow['pdp'] === 'mohamed') {
echo"<img class='image' src='uploads/mohamed.png' alt='mohamed Image'>";
} else {
echo '<img src="uploads/default.png" alt="default Image">';
}

?>
                <div class="followersInfo" >
                <b><?php echo $peopleIfollow['username']; ?></b>
                <span><?php echo $peopleIfollow['email']; ?></span>
            </div>
            </div>
            <?php } ?>



    </div>


<div class="userprofile">

<?php
 require("connection.php");



 $id = $_SESSION["user_id"];
 $select = $db ->prepare("SELECT * FROM users WHERE id= :id");
 $select -> execute(array("id"=> $id));


    $data = $select -> fetch();
    
?>
    <div class="userpdp">
        <?php

        
if ($data['pdp'] === 'default') {
    echo '<img src="uploads/default.png" alt="default Image">';
} elseif ($data['pdp'] === 'sara') {
    echo "<img src='uploads/sara.png' alt='sara Image'>";
} elseif ($data['pdp'] === 'dalia') {
    echo "<img  src='uploads/dalia.png' alt='dalia Image'>";
}  elseif ($data['pdp'] === 'islam') {
    echo"<img src='uploads/islam.png' alt='islam Image'>";
}
elseif ($data['pdp'] === 'mohamed') {
    echo"<img class='image' src='uploads/mohamed.png' alt='mohamed Image'>";
} else {
    echo '<img src="uploads/default.png" alt="default Image">';
}

?>
    </div>
    <div class="userinfo">
    <div class="usertop">

        <h3><?php echo $data['username'] ?></h3> 
        <?php
if($data['verified']) {
    echo "<img src='icons/verified.png' class='verified'>";
} ?>
    </div>
        <span><?php echo $data['email'] ?></span> 
    <button onclick="location.href='editform.php'">Edit profile</button>
    </div>
    </div>


    <div class="stats">
    <div >   
        <b><?php echo $followersCount['follower_num']; ?></b>
         <span>Posts</span>
    </div>
     
     <div onclick="showFollowers()">
        <b><?php echo $followersCount['follower_num']; ?></b>
     <span>Followers</span>
     </div>  
     <div onclick="showFollowing()">
     <b> <?php echo $followingCount['following_num']; ?> </b>
     <span>Following</span>
     </div>

    </div>
  
    

    <div class="addpost" >
        <form action="post.php" method="post">
            <div class="input">
        <?php
if ($data['pdp'] === 'default') {
    echo '<img src="uploads/default.png" alt="default Image">';
} elseif ($data['pdp'] === 'sara') {
    echo "<img src='uploads/sara.png' alt='sara Image'>";
} elseif ($data['pdp'] === 'dalia') {
    echo "<img  src='uploads/dalia.png' alt='dalia Image'>";
}  elseif ($data['pdp'] === 'islam') {
    echo"<img src='uploads/islam.png' alt='islam Image'>";
}
elseif ($data['pdp'] === 'mohamed') {
    echo"<img class='image' src='uploads/mohamed.png' alt='mohamed Image'>";
} else {
    echo '<img src="uploads/default.png" alt="default Image">';
}

?>

            <textarea  name="content" placeholder="Add new post..." required></textarea>
            </div>
            <div class="btn">
            <input  type="submit" value="Add">

            </div>
        </form>
    </div>
    
    <div class="posts">
      <div style="max-width: 470px; width:100%;"><h3 style="margin-top: 0;">Your posts</h3></div>
    <?php
$userid = $_SESSION["user_id"];

$show = $db->prepare('SELECT posts.id as post_id, posts.content, DATE(posts.created_at) as post_date, 
                            users.username, users.id , users.pdp, 
                            COUNT(comments.id) as comments_count
                     FROM posts 
                     INNER JOIN users ON posts.user_id = users.id 
                     LEFT JOIN comments ON posts.id = comments.post_id
                     WHERE users.id = :user_id
                     GROUP BY posts.id, posts.content, users.username, users.id, users.pdp
                     ORDER BY posts.created_at DESC');

$show->execute([':user_id' => $userid]);
              

if($show->rowCount() > 0){
while ($data = $show->fetch(PDO::FETCH_ASSOC)){

    
    echo '<div class="post">';
    echo "<div class='username'>";
    if ($data['pdp'] === 'default') {
        echo '<img src="uploads/default.png" alt="default Image">';
    } elseif ($data['pdp'] === 'sara') {
        echo "<img src='uploads/sara.png' alt='sara Image'>";
    } elseif ($data['pdp'] === 'dalia') {
        echo "<img  src='uploads/dalia.png' alt='dalia Image'>";
    }  elseif ($data['pdp'] === 'islam') {
        echo"<img src='uploads/islam.png' alt='islam Image'>";
    }
    elseif ($data['pdp'] === 'mohamed') {
        echo"<img class='image' src='uploads/mohamed.png' alt='mohamed Image'>";
    } else {
        echo '<img src="uploads/default.png" alt="default Image">';
    }
    echo "<div class='userdiv' >";
    echo "<h3 >" . htmlspecialchars($data['username']) . '</h3>';
    echo "<span>" .$data['post_date'] . "</span>";
    echo '</div>';

    echo "</div>";

    
    echo '<p>' . htmlspecialchars($data['content']) . '</p>'; 
    echo "<div><div class='comment' onclick=\"window.location.href='postview.php?id={$data['post_id']}'\">{$data['comments_count']} Comment</div> </div>";
    
 
    echo '</div>';
}
}else {
    echo "You haven't posted anything yet.";

}

?>
    </div>
    </div>

    <style>
     *{
        box-sizing: border-box;
     }
        body {
            padding: 0;
            position: relative;
           
        }
        .profileContainer {
           
            width: 100%;
            padding: 50px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .addpost {
            max-width: 470px;
            width: 100%;
            display: flex;
           
            justify-content: center;
            background-color: #fff;
            flex-direction: column;
            margin-top: 50px;
            padding: 10px 10px;
            border-radius: 8px;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
        }

        .addpost .btn {
            width: 100%;
            margin-top: 10px;
        }
        .input {
            display: flex;
            justify-content: center;
        }

        .input img {
            height: 48px;
            width: 48px;
            margin-right: 7px;

        }

        .addpost form textarea {
            width: 100%;
    min-height: 70px; 
   
    
    padding: 10px;
    resize: none; 
    outline: none;
    border: none;
    font-size: 16px; 
    line-height: 1.5; 
    box-sizing: border-box;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    
        }

        .addpost form input[type=submit] {
    background-color: #0866ff;
    border: none;
   border-radius:100px;
    padding: 10px 40px;
    color: #fff;
    font-weight: bold;
    float: right;
   
    margin-bottom: 5px;
    cursor: pointer;

} 
input[type=submit]:hover {
    opacity: 0.7;
 
}


.post {
    width:100%;
    max-width: 400px;
    padding: 10px;
    margin-bottom: 10px;
    background-color: #e0f2f1;
    border-radius: 8px;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
}


.stats {
    display: flex;
    width: 100%;
    max-width: fit-content;
    padding: 10px;
    background-color: #fff;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.stats div {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 7px 25px;
    cursor: pointer;
    width: 115px;

}

.stats div:hover {
    background-color: #f0f2f5;
}

.stats div:first-child {
    cursor: text;
}
.stats div:nth-child(2) {
   
    border-left: 1px solid rgba(0, 0, 0, 0.1);
    border-right: 1px solid rgba(0, 0, 0, 0.1);

}





    .userprofile {
        display: flex;
        max-width: 365px;
        width: 100%;
        margin: 30px 0 30px;
    }
    .userinfo {
        display: flex;
        flex-direction: column;
        margin-left: 15px;
    }

    .userinfo h3 {
font-size: 2rem;   
margin: 0;


}

.userinfo button {
    font-size: 16px;
    cursor: pointer;
    margin-top: 20px;
    border-radius: 4px;
    width: fit-content;
    padding: 5px 35px;
    background-color:#fff;
    border: none;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);

   
}
    .userpdp img {
        width: 150px;
        height: 150px;
    }


    .followers {
        display: none;
        flex-direction: column;
        position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    width: 360px;
    padding: 20px;
    border-radius: 8px;
        max-height: calc(100vh - 190px);
        overflow-y: scroll;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    z-index: 1000;


    }

    .followers img {
        height: 48px;
        width: 48px;
    }

    .followersProfile {
        display: flex;
        border-radius: 8px;
        padding: 5px;
        margin-bottom: 7px;
        cursor: pointer;
    }

    .followersProfile:hover {
     background-color: #e4e4e4;
    }

    .followersInfo {
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-left: 10px;
    }
  

    .close {
        width: 100%;
        margin-bottom: 5px;
    }
    .close img {
        height: 25px;
        width: 25px;
        cursor: pointer;
       float: right;
    }

     
    .posts {
            margin-top: 50px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
           padding: 0 10px;
        }
        .post {
            width: 100%;
            max-width: 470px;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
        }

        .comment {
            background-color: #f6f6f6;
            padding: 5px 10px;
            cursor: pointer;
        }

        .username {
            display: flex;
            align-items: center;
        }
        .username img {
            width: 38px;
            margin-right: 7px;
            height: 38px;
           
        }
    
        .username h3 {
            margin: 0;
        }

        .userdiv span {
            font-size: 12px;
            color: rgb(101, 103, 107);
        }

        .usertop {
            display: flex;
           align-items: center;
          }
        .usertop img {
            margin:0 3px;
            height: 18px;
            width: 18px;
           user-select: none;
         
           -webkit-user-drag: none;
            
        }

        @media (max-width: 768px) {

            .userpdp img {
        width: 90px;
        height: 90px;
    }

    
    .userinfo h3 {
font-size: 1.6rem;   

}


.userinfo span {
font-size: 14px;    



}
        }
    </style>



<script>
    function closeFollowers() {
        
 let followers =document.getElementById('followers')

 followers.style.display = 'none'
    }

    function showFollowers() {
        let followers =document.getElementById('followers')
        let following =document.getElementById('following')
        
 followers.style.display = 'flex'
 following.style.display = 'none'
 
    }
    function closeFollowing() {
        
 let followers =document.getElementById('following')

 following.style.display = 'none'
    }

    function showFollowing() {
        let following =document.getElementById('following')
        let followers =document.getElementById('followers')

 following.style.display = 'flex'
 followers.style.display = 'none'
    }
</script>
</body>
</html>
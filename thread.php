<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tech-Discussions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

    <?php
    include 'partials/_header.php';
    include 'partials/_dbconnect.php';
    ?>
    <?php
    //LISTING THREADS FROM EACH CATEGORY
    $id = $_GET['threadid'];
    ?>
    <?php
    //SUBMITTING THE RESPONSES IN POST QUERY
    $method = $_SERVER['REQUEST_METHOD'];
    //echo $method;
    
    if($method=='POST'){
      //INSERT INTO DB.
      //var_dump($_POST['sno']);
      $disc =  $_POST['commdisc'];                  
      $slno = $_POST['sno'];
      
      $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_time`, `comment_by`) 
                             VALUES ( '$disc', '$id', current_timestamp(), '$slno')";
      $result = mysqli_query($conn,$sql);
      if($result){
          echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Comment posted Sucessfully</strong> 
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
      }
      else{
          echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Unable to post Your Comment</strong> 
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
      }
    }
    ?>
    <?php
    //LISTING THREADS FROM EACH CATEGORY
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id = $id";
    $result = mysqli_query($conn,$sql);
    $num = mysqli_num_rows($result);
    //echo $num;
    $p=1;
    if($num>0){
        while($p<=$num){
            $row = mysqli_fetch_assoc($result);
            $id= $row['thread_id'];
            $heading = $row['thread_title'];
            $desc = $row['thread_desc'];
            $timestamp = $row['time stamp']; 
            $threaduser = $row['thread_user_id'];

            $sql2 = "SELECT user_email  FROM `users` where slno = '$threaduser' ";
           $result2 = mysqli_query($conn,$sql2);
           $row2 = mysqli_fetch_assoc($result2); 
            $posted_by = $row2['user_email'];
            $p++;
        }
    }
    ?>
    <div class="container my-3">
        <div class="container mt-3 my-3">
            <div class="mt-2 p-4 bg-secondary text-white rounded">
                <h1 class="display-4"><?php echo $heading?> </h1>
                <p class="lead"><?php echo $desc ?></p>
                <p class="lead"><b>Asked on :</b> <?php echo $timestamp ?></p>
                <hr class="my-4">
                <list>
                    <ul>Keep it friendly.</ul>
                    <ul>Be courteous and respectful.</ul>
                    <ul>Appreciate that others may have an opinion different from yours.</ul>
                    <ul>Stay on topic. ...</ul>
                </list>
                <p><strong>This is a peer-to-peer forum for sharing knowledge with Each other</strong></p>
                <h5><b>Posted by : <?php echo $posted_by;?></b></h5></br>
                <a class="btn btn-warning btn-lg" href="#" role="button">View Thread</a>

            </div>
        </div>
    </div>

    <div class="conatiner my-8" id="ques">
        <h1 style="margin-left:8%; padding-top:3%; padding-bottom:3%;">Comments</h1>
        <?php
    //DISPLAYING QUESTIONS FROM DATA BASE
    $id = $_GET['threadid'];
    //echo $id;
    $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
    $result = mysqli_query($conn,$sql);
    $nums = mysqli_num_rows($result);
    //echo $nums;
    $p=1;
    if($nums!=0){
        while($p<=$nums)
      {
        $row = mysqli_fetch_assoc($result);
        $content = $row['comment_content']; 
        $timestamp = $row['comment_time'];
        $commentby =  $row['comment_by'];
          //echo $commentby;
        //$user_id = $row['thread_user_id'];

        $sql2 = "SELECT user_name  FROM `users` where slno = '$commentby' ";
        $result2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($result2); 
        $number = mysqli_num_rows($result2);
        //echo $number;
        //echo $row2['user_email'];
        $p=$p+1;
        echo '
           <div class="d-flex my-3 hello container">
           <img src="images/human_default.png" alt="Loading...." class="me-3 rounded-circle"
            style="width: 60px; height: 60px;" />
           <div>
           <strong class="text-muted">Posted by : '.$row2['user_name'].' on  '.$timestamp.' </strong>
           </br></br>
           <h4><p><i>'.$content.'</i></p></h4>
           
           </div>
           </div>';
      }
    }
    else{
        echo'
            <div class="mt-4 p-5 bg-secondary text-white rounded container">
            <h1><i>No Comments Found </i>&#128542</h1>
            <p><h4>Be the first person to Comment &#128519</h4></p>
           </div>';
    }
    ?>
    </div>
    </br>
    <?php
    if(isset($_SESSION['loggedin'] )&& $_SESSION['loggedin']==true){
        $no = $_SESSION["sno"];
    echo'
    <div class="container">
        <h1>Post Your Comment</h1>
        <form action=" '.$_SERVER["REQUEST_URI"] .'" method="post">
            <div class="form-floating">

                <textarea class="form-control" id="floatingTextarea2" style="height: 100px;" name="commdisc"
                    placeholder="Enter Here">
                </textarea>
                <div id="emailHelp" class="form-text">Enter Your Comment</div> ';
                 //echo $_SESSION["sno"];
                echo'<input type="hidden" name="sno" value=" '.$no.' ">
            </div>
            <br />
            <button type="submit" class="btn btn-success">post Comment</button>
        </form>
    </div>';
    }
    else{
        echo '<div class="container my-3">
        <div class="container mt-3 my-3">
        <h1>Post Your Query</h1>
            <div class="mt-2 p-4 bg-secondary text-white rounded">
               <p><b><i>You are not logged in .Login to post your comments &#128519!!! </i></b></p>
            </div>
        </div>
    </div>';
    }
    ?>
    </br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
        integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous">
    </script>
    <?php
    include 'partials/_footer.php';
    ?>
</body>

</html>
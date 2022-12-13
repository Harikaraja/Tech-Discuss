<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tech-Discussions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="styles1.css">
</head>

<body>
    <?php
    include 'partials/_header.php';
    include 'partials/_dbconnect.php';
    ?>
    <div class="container row" id="cat">
      
        <?php
             $sql = "SELECT * FROM `categories`";
             $result = mysqli_query($conn,$sql);
             $num = mysqli_num_rows($result);
             //echo "number of rows: ".$num."<br>";
             $p=1;
             $s=1;
             //use a loop to iterate categories
             while($p<=$num){
              $row = mysqli_fetch_assoc($result);
              $id= $row['category_id'];
              $cat = $row['category_name'];
              $disc = $row['category_discription']; 
              echo 
              '<div class="col-md-4 my-2">
                 <div class="card " style="width: 18rem;">
                      <img src="images/card'.$s.'.jpg" height="250px" width="500px" class="card-img-top" alt="python">
                      <div class="card-body">
                         <h5 class="card-title"><a href="threadlist.php?catid=' . $id . '">'.$cat.'</a></h5>
                         <p class="card-text">'.substr($disc,0,50).'....</p>
                         <a href="threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
                      </div>
                 </div>
               </div>';
              $p=$p+1;
              $s=$s+1;
             }
             
           ?>
           
    </div>
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
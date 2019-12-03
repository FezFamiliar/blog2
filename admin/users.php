<?

include 'config.php';
include 'header.php';
if(!isset($_GET['page'])) $_GET['page'] = 1;
$page = $_GET['page'];
$max_query = mysqli_query($conn,"SELECT count(id) FROM users");
$max = mysqli_fetch_array($max_query);
$end = 10;
$_SESSION['users_total'] = ceil($max[0]/$end);
$start = ($page * $end) - $end;
if($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_GET['added']) && $_GET['added'] == 'true'){

    $category = mysqli_real_escape_string($conn,$_POST['category']);
    $sql = "INSERT INTO `users` (name) VALUES('".$category."')";
    mysqli_query($conn,$sql);
  //  header("refresh:0;category.php");
}

if(isset($_GET['action']) && $_GET['action'] == 'remove'){

  $query = "DELETE FROM `users` WHERE id = '".$_GET['edit_id']."'";
  //echo $query;
  mysqli_query($conn,$query);
  header("refresh:0;users.php");

}

?>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <h1>Users</h1>
      </div>
<!--       <div class="col-md-6 pull">
        <a href="users.php?page=<?= $_GET['page']; ?>&action=add" class="btn btn-primary">Adauga</a>
      </div> -->
    </div>
    <? if(isset($_GET['action']) && $_GET['action'] == 'add'): ?>
      <div class="col-md-12">
        <form  action="users.php?added=true" method="POST" autocomplete="off">
          Category:
          <br><br>
          <input type="text" name="category" class="form-control">
          <br>
          <input type="submit" class="btn btn-primary submit" value="Adauga">
        </form>
      </div>
    <? endif; ?>
    <br><br>
    <table>
      <tr>
        <th width=600><b>ID</b></th>
        <th width=600><b>Username</b></th>
        <th width=600><b>Email</b></th>
        <th width=600><b>Joined</b></th>
        <th width=400><b>Action</b></th>
      </tr>
      <?
        $result = mysqli_query($conn,"SELECT * FROM users LIMIT $start,$end");
         while($row = mysqli_fetch_array($result)):
       ?>
       <tr>
         <td><? echo $row['id']; ?></td>
         <td><? echo $row['username']; ?></td>
         <td><? echo $row['email']; ?></td>
         <td><? echo $row['joined']; ?></td>
         <td>
           <i class="far fa-times-circle" onclick="if(confirm('Are you sure?'))window.location='users.php?page=<? echo $_GET['page']; ?>&edit_id=<? echo $row['id']; ?>&action=remove'"></i>
         </td>
       </tr>
     <? endwhile;?>
    </table>
    <br>
    <a href="users.php?page=<?= ($_GET['page'] - 1 == 0) ? $_SESSION['users_total'] : $_GET['page'] - 1;?>">
      <i class="fas fa-arrow-left arrow-page"></i>
    </a>
    &nbsp;&nbsp;&nbsp;
    <? for($i = 1;$i<=$_SESSION['users_total'] ; $i++): ?>
      <a href="posts.php?page=<? echo $i; ?>" class="<? if($_GET['page'] == $i) echo 'selected'; ?>"><? echo $i; ?></a>
    <? endfor; ?>
    &nbsp;&nbsp;&nbsp;
    <a href="users.php?page=<?=  ($_GET['page'] + 1 == $_SESSION['users_total']+1) ? 1 : $_GET['page'] + 1; ?>">
      <i class="fas fa-arrow-right arrow-page"></i>
    </a>
  </div>

  </script>

</body>

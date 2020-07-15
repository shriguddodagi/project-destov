<?php
include_once('./includes/admin-header.php');
include_once('./config.php');

if(isset($_POST['hide'])) {
  $id = $_POST['id'];
  mysqli_query($cn, "UPDATE `feedbacks` SET `status`='0' WHERE id=$id");
  unset($_POST);
  header('Location: feedbacks.php');
}
if(isset($_POST['show'])) {
  $id = $_POST['id'];
  mysqli_query($cn, "UPDATE `feedbacks` SET `status`='1' WHERE id=$id");
  unset($_POST);
  header('Location: feedbacks.php');
}

$feedbacks  = mysqli_query($cn, 'SELECT * FROM feedbacks');

?>
<?php include_once('./includes/admin-header.php'); ?>
  <main>
    <div class="container m-5">


          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>                
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Message</th>
                <th scope="col">Arrived On</th>
                <th scope="col">Display On Home Page</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while($row = mysqli_fetch_array($feedbacks)) {
                $status = ($row['status']) ? 
                  "<form action='' method='POST'>
                    <input type='hidden' name='id' value='". $row['id'] ."'>
                    <button type='submit' name='hide' class='btn btn-danger'>Hide</button>
                  </form>" : 
                  "<form action='' method='POST'>
                    <input type='hidden' name='id' value='". $row['id'] ."'>
                    <button type='submit' name='show' class='btn btn-success'>Show</button>
                  </form>";
                echo "<tr>
                  <th scope='row'>".$row['id']."</th>
                  <td>".$row['name']."</td>
                  <td>".$row['email']."</td>
                  <td>".$row['phone']."</td>
                  <td>".$row['message']."</td>
                  <td>". date('jS F, Y', strtotime($row['created_at']))."</td>
                  <td>$status</td>
                </tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      



    </div>
  </main>

</body>


<script src="./vendor/bootstrap 5/js/bootstrap.min.js"></script>

</html>
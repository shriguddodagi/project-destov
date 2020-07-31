<?php
include_once('./includes/admin-header.php');

if (!in_array('feedbacks', $permissions)) {
  header('Location: admin-' . $permissions[0] . '.php');
  exit;
}

if(isset($_POST['hide'])) {
  $id = $_POST['id'];
  mysqli_query($cn, "UPDATE `feedbacks` SET `status`='0' WHERE id=$id");
  unset($_POST);
  header('Location: admin-feedbacks.php');
}
if(isset($_POST['show'])) {
  $id = $_POST['id'];
  mysqli_query($cn, "UPDATE `feedbacks` SET `status`='1' WHERE id=$id");
  unset($_POST);
  header('Location: admin-feedbacks.php');
}


  // Pagination
  $page_no = 1;
  $total_records_per_page = 3;

  if(isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no'];
  }

  $offset = ($page_no - 1) * $total_records_per_page;
  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;

  $total_records = mysqli_fetch_array(mysqli_query($cn, "SELECT COUNT(*) AS total_records FROM `feedbacks`"))['total_records'];

  $total_no_of_pages = ceil($total_records / $total_records_per_page);
  $second_last = $total_no_of_pages - 1; // total pages minus 1

  $feedbacks = mysqli_query($cn, "SELECT * FROM `feedbacks` ORDER BY id DESC LIMIT $offset, $total_records_per_page");

?>
<?php include_once('./includes/admin-header.php'); ?>
  <main>
    <div class="container">

      <div class="row p-2">
        <div class="col">
          <h2>Feedbacks</h2>
        </div>
      </div>

      <div class="row">
        <div class="text-center m-2">
          <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
        </div>
      </div>


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
      
        <div class="row m-5">
          <div class="col d-flex justify-content-center">
            <div aria-label="Page navigation">
              <ul class="pagination">
                <?php 
                if($page_no > 1){
                  echo "<li class='page-item '><a class='page-link' href='?page_no=1'>First Page</a></li>";
                } 
                ?>      
                <li class='page-item <?php if($page_no <= 1){ echo "disabled"; } ?>'>
                  <a class='page-link' <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?> aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                  </a>
                </li>
                    
                <li class='page-item <?php if($page_no >= $total_no_of_pages){ echo "disabled";} ?>'>
                  <a class='page-link' <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?> aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
                
                <?php if($page_no < $total_no_of_pages){
                echo "<li class='page-item'><a class='page-link' class='' href='?page_no=$total_no_of_pages'>Last &raquo;</a></li>";
              } ?>
              </ul>
            </div>
          </div>
        </div>

        <?php
        if($feedbacks->num_rows == 0) {
          echo "<div class='row'>
            <div class='col text-center'>
              <div class='display-3'>
                Nothing Found!
              </div>
            </div>
          </div>";
        }
      ?>
    </div>
  </main>
<?php include_once('./includes/admin-script.php'); ?>
<?php include_once('./includes/admin-footer.php'); ?>
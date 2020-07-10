<?php
include_once('./includes/admin-header.php');
include_once('./config.php');

if(isset($_POST['close'])) {
  $id = $_POST['id'];
  mysqli_query($cn, "UPDATE `inquiries` SET mode='close' WHERE id=$id");
  unset($_POST);
  header('Location: inquiries.php');
}
if(isset($_POST['open'])) {
  $id = $_POST['id'];
  mysqli_query($cn, "UPDATE `inquiries` SET mode='open' WHERE id=$id");
  unset($_POST);
  header('Location: inquiries.php');
}

$openInquirie  = mysqli_query($cn, 'SELECT * FROM inquiries WHERE mode="open" ORDER BY id DESC');
$closeInquirie  = mysqli_query($cn, 'SELECT * FROM inquiries WHERE mode="close" ORDER BY id DESC');

?>
<?php include_once('./includes/admin-header.php'); ?>
  <main>
    <div class="container m-5">

      <ul class='nav nav-tabs' id='myTab' role='tablist'>
        <li class='nav-item'>
          <a class='nav-link active text-capitalization' id='open-tab' data-toggle='tab' href='#open' role='tab'
            aria-controls='open' aria-selected='true'>open</a>
        </li>
        <li class='nav-item'>
          <a class='nav-link text-capitalization' id='closed-tab' data-toggle='tab' href='#closed' role='tab'
            aria-controls='closed' aria-selected='false'>closed</a>
        </li>
      </ul>

      <div class='tab-content channelContent' id='myTabContent'>
        <div class='tab-pane fade show active' id='open' role='tabpanel' aria-labelledby='open-tab'>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Message</th>
                <th scope="col">Arrived On</th>
                <th scope="col">Close</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while($row = mysqli_fetch_array($openInquirie)) {
                echo "<tr>
                  <th scope='row'>".$row['id']."</th>
                  <td>".$row['name']."</td>
                  <td>".$row['email']."</td>
                  <td>".$row['phone']."</td>
                  <td>".$row['message']."</td>
                  <td>".$row['created_at']."</td>
                  <td>
                    <form action='' method='POST'>
                      <input type='hidden' name='id' value='". $row['id'] ."'>
                      <button type='submit' name='close' class='btn btn-danger'>Close</button>
                    </form>
                  </td>
                </tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
        <div class='tab-pane fade' id='closed' role='tabpanel' aria-labelledby='closed-tab'>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Message</th>
                <th scope="col">Arrived On</th>
                <th scope="col">Reopen</th>
              </tr>
            </thead>
            <tbody>
            <?php
              while($row = mysqli_fetch_array($closeInquirie)) {
                echo "<tr>
                  <th scope='row'>".$row['id']."</th>
                  <td>".$row['name']."</td>
                  <td>".$row['email']."</td>
                  <td>".$row['phone']."</td>
                  <td>".$row['message']."</td>
                  <td>".$row['created_at']."</td>
                  <td>
                    <form action='' method='POST'>
                      <input type='hidden' name='id' value='". $row['id'] ."'>
                      <button type='submit' name='open' class='btn btn-success'>Reopen</button>
                    </form>
                  </td>
                </tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>




    </div>
  </main>

</body>


<script src="./vendor/bootstrap 5/js/bootstrap.min.js"></script>

</html>
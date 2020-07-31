<?php
include_once('./includes/admin-header.php');

if (!in_array('inquiries', $permissions)) {
  header('Location: admin-' . $permissions[0] . '.php');
  exit;
}

if(isset($_POST['close'])) {
  $id = $_POST['id'];
  mysqli_query($cn, "UPDATE `inquiries` SET mode='close' WHERE id=$id");
  unset($_POST);
  header('Location: admin-inquiries.php');
}
if(isset($_POST['open'])) {
  $id = $_POST['id'];
  mysqli_query($cn, "UPDATE `inquiries` SET mode='open' WHERE id=$id");
  unset($_POST);
  header('Location: admin-inquiries.php');
}

$openInquirie  = mysqli_query($cn, 'SELECT * FROM inquiries WHERE mode="open" ORDER BY id DESC');
$closeInquirie  = mysqli_query($cn, 'SELECT * FROM inquiries WHERE mode="close" ORDER BY id DESC');

?>
<?php include_once('./includes/admin-header.php'); ?>
  <main>
    <div class="container">
      <div class="row p-2">
        <div class="col">
          <h2>Inquiries</h2>
        </div>
      </div>
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
                <th scope="col">Position</th>
                <th scope="col">Company</th>
                <th scope="col">Port</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Message</th>
                <th scope="col">Product</th>
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
                  <td>".$row['position']."</td>
                  <td>".$row['company']."</td>
                  <td>".$row['destination_port']."</td>
                  <td>".$row['email']."</td>
                  <td>".$row['phone']."</td>
                  <td>".$row['message']."</td>
                  <td class='font-weight-bold text-primary'>".$row['product']."</td>
                  <td>". date('jS F, Y', strtotime($row['created_at']))."</td>
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
                <th scope="col">Position</th>
                <th scope="col">Company</th>
                <th scope="col">Port</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Message</th>
                <th scope="col">Product</th>
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
                  <td>".$row['position']."</td>
                  <td>".$row['company']."</td>
                  <td>".$row['destination_port']."</td>
                  <td>".$row['email']."</td>
                  <td>".$row['phone']."</td>
                  <td>".$row['message']."</td>
                  <td class='font-weight-bold text-primary'>".$row['product']."</td>
                  <td>". date('jS F, Y', strtotime($row['created_at']))."</td>
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
<?php include_once('./includes/admin-script.php'); ?>
<?php include_once('./includes/admin-footer.php'); ?>
<?php include 'header.php'; ?>
<?php include 'code.php';?>
<div class="box1">
    <h1>ALL STUDENTS</h1>
    <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal">ADD STUDENT</button>
</div>
<table class="table table-hover  table-bordered table-striped  ">
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>AGE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM hocsinh";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row['ID']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
<?php
if(isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']); // Sanitize the input
    echo "<h6>" . $message . "</h6>"; // Output the sanitized message
}
?>
<?php
if(isset($_GET['insert_msg'])) {
    $message = htmlspecialchars($_GET['insert_msg']); // Sanitize the input
    echo "<h6>" . $message . "</h6>"; // Output the sanitized message
}
?>

<!-- Modal -->
<form action="insert_data.php" method="post">
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">ADD STUDENTS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
     
            <div class="form-group">
                <label for="f_name">
                    First Name
                </label>
                <input type="text" name="f_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="l_name">
                    Last Name
                </label>
                <input type="text" name="l_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="age">
                  Age
                </label>
                <input type="text" name="age" class="form-control">
            </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-success" name="add_students" value ="ADD"></input>
      </div>
    </div>
  </div>
</div>
</form>
<?php include 'footer.php'; ?>

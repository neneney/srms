<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (isset($_GET['blockid'])) {
  $blockedid = intval($_GET['blockid']);
  $sql = "update tblusers set status='1' where id=:blockedid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':blockedid', $blockedid, PDO::PARAM_STR);
  $query->execute();
  echo "<script>window.location.href = 'userregister.php'</script>";
}
?>

<div class="card-body">
  <div class="modal fade" id="unblockModal" tabindex="-1" role="dialog" aria-labelledby="unblockModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="unblockModalLabel">Confirm Unblock</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Do you really want to unblock this user?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a href="#" id="confirmUnblock" class="btn btn-danger">Unblock</a>
        </div>
      </div>
    </div>
  </div>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="text-center">Names</th>
        <th class="text-center">Permission</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $sql = "SELECT * from tblusers where status='0'";
      $query = $dbh->prepare($sql);
      $query->execute();
      $results = $query->fetchAll(PDO::FETCH_OBJ);
      $cnt = 1;
      if ($query->rowCount() > 0) {
        foreach ($results as $row) { ?>
          <tr>
            <td><?php echo htmlentities($row->name); ?> <?php echo htmlentities($row->lastname); ?></td>
            <td class="text-left"><?php echo htmlentities($row->permission); ?></td>
            <td class="text-left">
              <a class="btn btn-secondary btn-sm text-center unblock-btn" href="#" data-id="<?php echo ($row->id); ?>" title="Restore this User">Unblock</a>
            </td>
          </tr>
      <?php
        }
      } ?>
    </tbody>
  </table>
</div>
<!-- /.card-body -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Attach click event listener to all unblock buttons
    document.querySelectorAll('.unblock-btn').forEach(function(button) {
      button.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior
        var userId = this.getAttribute('data-id');
        // Update the confirmUnblock button href with the correct user ID
        document.getElementById('confirmUnblock').setAttribute('href', 'blockedusers.php?blockid=' + userId);
        // Show the modal
        $('#unblockModal').modal('show');
      });
    });
  });
</script>
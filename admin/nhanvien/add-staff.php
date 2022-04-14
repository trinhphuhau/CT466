<?php require ("../connect.php"); ?>
<div class="px-5 py-4 border rounded">
    <div>
    <h3 class="display-4 mb-3">Add New Staff</h3>
    <button type="button" class="close" id="closeNewStaffForm">
        <span>&times;</span>
    </button>
    </div>
    <div id="alertNewStaff">
    </div>
    <form id="newStaff"
        name="newStaff"
        onsubmit="return formUpload();"
        class="needs-validation"
        novalidate>
      <div class="row pb-3">
          <div class="col-6 pr-2">
          <label for="name">Full Name</label>
          <input type="text" class="form-control" name="name" required>
          <div class="invalid-feedback">Enter staff's full name</div>
          </div>
          <div class="col-6 pl-2">
          <label for="phone">Phone Number</label>
          <input type="text" class="form-control" name="phone" required>
          <div class="invalid-feedback">Enter staff's phone number</div>
          </div>
      </div>
      <div class="row pb-3">
          <div class="col-6 pr-2">
          <label for="username">Username</label>
          <input type="text" class="form-control" name="username" required>
          <div class="invalid-feedback">Enter username</div>
          </div>
          <div class="col-6 pl-2">
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" required>
          <div class="invalid-feedback">Enter password</div>
          </div>
      </div>
      <div class="row pb-3">
          <div class="col-12 pb-3">
          <label for="address">Address</label>
          <input type="text" class="form-control" name="address" required>
          <div class="invalid-feedback">Enter address</div>
          </div>
          <div class="col-4 pr-2">
          <select class="custom-select" name="tinhtp" id="tinhtp" onchange="alibaba(this.value)" required>
              <option value="">Province/City</option>
              <?php
              $tinhtp = $conn->query("SELECT * FROM tinhthanhpho ORDER BY name");
              while ($row_tinhtp = $tinhtp->fetch_assoc()) { ?>
              <option value="<?php echo $row_tinhtp["matp"] ?>"><?php echo $row_tinhtp["name"] ?></option>
              <?php    }
              ?>
          </select>
          <div class="invalid-feedback">Select province/city</div>
          </div>
          <div class="col-4 pr-2 pl-2">
          <select class="custom-select" name="quanhuyen" id="quanhuyen" onchange="xaphuong(this.value)" required>
              <option value="">District</option>
              <?php
              $quanhuyen = $conn->query("SELECT * FROM quanhuyen WHERE matp = '01'");
              while ($row_qh = $quanhuyen->fetch_assoc()) { ?>
              <option value="<?php echo $row_qh["maqh"]; ?>"><?php echo $row_qh["name"]; ?></option>
              <?php } ?>
          </select>
          <div class="invalid-feedback">Select district</div>
          </div>
          <div class="col-4 pl-2">
          <select class="custom-select" name="xaphuongtt" id="xaphuongtt" required>
              <option value="">Commune/Ward/Townlet</option>
          </select>
          <div class="invalid-feedback">Select commune/ward/townlet</div>
          </div>
      </div>
      <div class="row pb-3">
          <div class="col-12">
          <label for="job">Job</label>
          <select class="custom-select" name="macv" required>
              <option value="">Select job</option>
              <?php
              $job = $conn->query("SELECT * FROM congviec");
              while($row_job = $job->fetch_assoc()) {
              ?>
              <option value="<?php echo $row_job["macv"] ?>"><?php echo $row_job["tencv"] ?></option>
              <?php } ?>
          </select>
          <div class="invalid-feedback">Please select job</div>
          </div>
      </div>
      <div class="row pb-3">
          <div class="col-6 pr-2">
          <input type="reset" class="btn btn-secondary w-100" value="Reset">
          </div>
          <div class="col-6 pl-2">
          <input type="submit" class="btn btn-primary w-100" value="Add">
          </div>
      </div>
    </form>
</div>
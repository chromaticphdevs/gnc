<?php build('content') ?>
  <div class="container-fluid">
    <div class="card">
    <?php echo wCardHeader(wCardTitle('Search Address'))?>
    <div class="card-body">
      <?php if(isset($result)): ?>
        <form action="/UserTools/export_2" method="post">
            <input type="hidden" name="users" 
                value="<?php echo base64_encode(serialize($result))?>">

            <input type="submit" class="btn btn-primary btn-sm" value="Export As Excell">
        </form>
        <br>
      <?php endif;?> 
        <form action="/UserTools/user_search_tool" method="post">
          <input type="text" class="form-control" name="address" placeholder="Enter Address" required>
          <br>
          <select name="level" class="form-control" required>
            <option value="">--Select</option>
            <?php foreach($levels as $row) :?>
              <option value="<?php echo $row?>">
                <?php echo $row?>
              </option>
            <?php endforeach;?>
          </select>
          <br>
        <input type="submit" class="btn btn-success btn-sm" value="Search">
        </form>
        <br>
        <?php if(isset($result)): ?>
          <div class="x_content">
          <div style="overflow-x:auto;">
              <table class="table">
                <thead>
                      <th>#</th>
                      <th>Username</th> 
                      <th>Full Name</th> 
                      <th>Address</th> 
                      <th>phone</th>
                </thead>
                    <tbody>
                          <?php $counter = 1;?>
                          <?php foreach($result as $data) :?>
                            <tr>
                                  <td><?php echo $counter++; ?></td>
                                  <td><a href="/FNProductBorrower/get_user_loans_details/<?php echo $data->id; ?>" target="_blank"><?php echo $data->username; ?></a></td>
                                  <td><?php echo $data->firstname.' '.$data->lastname; ?></td>
                                  <td><?php echo $data->address; ?></td>
                                  <td><?php echo $data->mobile; ?></td>   
                            </tr>
                          <?php endforeach;?>
                  </tbody>
              </table>
          </div>
          </div>
      <?php endif; ?>
    </div>
    </div>
  </div>
<?php endbuild()?>
<?php occupy()?>
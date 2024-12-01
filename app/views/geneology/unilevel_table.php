<?php build('content')?>

<div class="container-fluid">
  <div class="card">
  <?php echo wCardHeader(wCardTitle('Refferal Lists'))?>
  <div class="card-body">
    <div class="mt-3 mb-2 text-center">
      <div>
        <?php echo wReferralLinkButton(createReferralLink())?>
        <a href="/UserController/preRegister" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New</a>
      </div>
      <p>Invite</p>
    </div>
    <hr>

    <?php Flash::show() ?>
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable">
        <thead>
          <th>#</th>
          <th>Name</th>
          <th>Registration Status</th>
          <th>Verification Status</th>
          <th>Mobile</th>
          <th>Date</th>
          <th>Facebook</th>
          <th>Sponsor Approval Video</th>
        </thead>

        <tbody>
          <?php foreach($mergedUsers as $key => $row) :?>
            <tr data-userid="<?php echo seal($row->id)?>">
              <td><?php echo ++$key?></td>
              <td><?php echo userVerfiedText($row)?> <?php echo $row->fullname?></td>
              <td><?php echo $row->registration_status ?></td>
              <td><?php echo $row->is_user_verified ? 'Verified' : 'Pending' ?></td>
              <td><?php echo $row->mobile?></td>
              <td>
                <?php echo get_date($row->created_at , 'M d , Y h:i:s A')?>
              </td>
              <td>
                <?php if($row->fb_link) :?>
                  <label for="#">No FB Link</label>
                <?php else:?>
                  <a href="<?php echo $row->fb_link?>" target="_blank">View Media</a>
                <?php endif;?>
              </td>
              <td>
                <?php if($row->sp_video_file) :?>
                  <a href="/UserDirectsponsor/viewVideo/<?php echo seal($row->sp_id)?>">Show</a>
                <?php else :?>
                  <a href="/UserDirectsponsor/uploadVideo/<?php echo seal($row->id)?>">Add Video</a>
                <?php endif?>
              </td>
            </tr>
          <?php endforeach?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<?php endbuild()?>

<?php build('scripts') ?>
    <script>
      $(document).ready(function(){
          $('.ref-link').click(function(){
            let referralLink = $(this).data('link');
            copyStringToClipBoard(referralLink);
            alert(referralLink);
          });
      });
    </script>
<?php endbuild()?>
<?php occupy('templates/layout')?>

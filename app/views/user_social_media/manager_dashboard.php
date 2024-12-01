<?php build('content') ?>

<div class="row">
  <div class="col-sm-12 col-md-4">
    <h3>Processed ID Today</h3>
    <div class="tile-stats col-sm-12">
      <section>
        <div class="icon green"><i class="fa fa-id-badge" aria-hidden="true"></i></div>
        <div class="count"><?php echo $user_id->approved; ?></div>
        <h3>Total Approved ID</h3>
      </section>

      <section>
        <div class="count"><?php echo $user_id->denied; ?></div>
        <h3>Total Denied ID</h3>
      </section>
    </div>
  </div>

  <div class="col-sm-12 col-md-4">
    <h3>Processed ID For the week</h3>
     <div class="tile-stats col-sm-12">
      <section>
        <div class="icon green"><i class="fa fa-id-badge" aria-hidden="true"></i></div>
        <div class="count"><?php echo $user_id_week->approved; ?></div>
        <h3>Total Approved ID</h3>
      </section>

      <section>
        <div class="count"><?php echo $user_id_week->denied; ?></div>
        <h3>Total Denied ID</h3>
      </section>
    </div>
  </div>

  <!-- FOR THE MONTH -->
  <div class="col-sm-12 col-md-4">
    <h3>Processed ID For the Month</h3>
     <div class="tile-stats col-sm-12">
      <section>
        <div class="icon green"><i class="fa fa-id-badge" aria-hidden="true"></i></div>
        <div class="count"><?php echo $user_id_month->approved; ?></div>
        <h3>Total Approved ID</h3>
      </section>

      <section>
        <div class="count"><?php echo $user_id_month->denied; ?></div>
        <h3>Total Denied ID</h3>
      </section>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12 col-md-4">
    <h3>Processed Social Media Today</h3>
    <div class="tile-stats">
      <section>
        <div class="count"><?php echo $social->approved; ?></div>
        <h3>Total Approved Social Media</h3>
      </section>

      <section>
        <div class="count"><?php echo $social->denied; ?></div>
        <h3>Total Denied Social Media</h3>
      </section>
    </div>
  </div>

  <div class="col-sm-12 col-md-4">
    <h3>Processed Social Media for a Week</h3>

    <div class="tile-stats">
      <section>
        <div class="count"><?php echo $social_week->approved; ?></div>
        <h3>Total Approved Social Media</h3>
      </section>

      <section>
        <div class="count"><?php echo $social_week->denied; ?></div>
        <h3>Total Denied Social Media</h3>
      </section>
    </div>
  </div>

  <!-- FOR THE MONTH -->

  <div class="col-sm-12 col-md-4">
    <h3>Processed Social Media for a MONTH</h3>

    <div class="tile-stats">
      <section>
        <div class="count"><?php echo $social_month->approved; ?></div>
        <h3>Total Approved Social Media</h3>
      </section>

      <section>
        <div class="count"><?php echo $social_month->denied; ?></div>
        <h3>Total Denied Social Media</h3>
      </section>
    </div>
  </div>
</div>
<?php endbuild()?>

<?php occupy('templates/layout')?>
<?php build('content') ?>
  <div class="container-fluid">
    <?php echo wControlButtonLeft('ID Viewer', [
      $navigationHelper->setNav('', 'Back', '/UserIdVerification/upload_id_html')
    ])?>
    <div class="card">
      <?php echo wCardHeader(wCardTitle($idDetail->type))?>

      <div class="card-body">
        <?php if(isEqual(whoIs('type'), 1) && isEqual($idDetail->status, 'unverified')): ?>
          <section class="mb-5">
            <a class="btn btn-success" href="/UserIdVerification/verify_id/<?php echo $id?>">Verify</a>
            <a class="btn btn-danger " href="/UserIdVerification/cancel_id/<?php echo $id; ?>">Cancel This ID</a>
          </section>
        <section class="mb-5">
          <p>Confirm the following User Information <b><?php echo $idDetail->status?></b></p>
          <div><label> Name : <?php echo $idDetail->firstname?> <?php echo $idDetail->lastname?></label></div>
          <div><label> Address : <?php echo $idDetail->address?> </label></div>
          <div><label> Esig : <div><img src="<?php echo URL.DS.'public/assets/signatures/'.$idDetail->esig?>" alt="" 
                            style="width: 150px; margin-left:30px; display:inline-block"></div></label> </div>
        </section>
        <?php endif; ?>
        <?php Flash::show()?>
        <section class="mb-5">
          <h3><b>Front ID</b></h3>
          <img style="width:100%; max-width: 650px"  
            src="<?php echo URL.DS.'assets/user_id_uploads/'.$idDetail->id_card ?>" >
        </section>
        <section>
          <h3><b>Back ID</b></h3>
          <img style="width:100%; max-width: 650px"   
            src="<?php echo URL.DS.'assets/user_id_uploads/'.$idDetail->id_card_back; ?>" >
        </section>
      </div>
    </div>
  </div>
<?php endbuild()?>

<?php occupy()?>
<?php include_once VIEWS.DS.'templates/market/header.php'?>
</head>
<body>
    <?php include_once VIEWS.DS.'templates/market/navigation.php'?>

    <div class="container">
      <div class="col-md-6">
        <form method="get">
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username">
            <input type="submit" name="" class="btn btn-success btn-sm">
          </div>
        </form>

        <form method="get">
          <div class="form-group">
            <label>Start Id at</label>
            <input type="number" name="startat">
            <input type="submit" name="" class="btn btn-success btn-sm">
          </div>
        </form>
      </div>
        <table class="table">
          <thead>
            <th>Username</th>
            <th>Name</th>
            <th>DRC</th>
            <th>UNILEVEL</th>
            <th>MENTOR</th>
            <th>BINARY</th>
            <th>WITHDRAWABLE</th>
          </thead>
          <tbody>
            <?php foreach($userList as $user):?>
                <tr>
                  <td><?php echo $user->username?></td>
                  <td><?php echo $user->firstname . ' ' . $user->lastname?></td>
                  <td><?php echo $user->commission['drc']?></td>
                  <td><?php echo $user->commission['unilvl']?></td>
                  <td><?php echo $user->commission['mentor']?></td>
                  <td><?php echo $user->commission['binary']?></td>
                  <td><?php echo $user->commission['totalEarning']?></td>
                </tr>
            <?php endforeach;?>
          </tbody>
        </table> 
    </div>
<?php include_once VIEWS.DS.'templates/market/footer.php'?>
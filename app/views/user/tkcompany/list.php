<?php include_once VIEWS.DS.'templates/market/header.php'?>
</head>
<body>
    <div class="container">
      <h3>Company List</h3>
      <ul>   
        <li><a href="/timeKeeper/admin/?page=panel">Panel</a></li>
      </ul>
     <table class="table">
       <thead>
         <th>Name</th>
         <th>Email</th>
         <th>Phone</th>
         <th>Address</th>
         <th>Geolocation</th>
         <th>Action</th>
       </thead>

       <tbody>
         <?php foreach($company_list as $comp):?>
          <tr>
            <td><?php echo $comp->name?></td>
            <td><?php echo $comp->email?></td>
            <td><?php echo $comp->phone?></td>
            <td><?php echo $comp->address?></td>
            <td>
              <ul>
                <li>Region Name : <?php echo $comp->readableLocation['regionName'];?></li>
                <li>City : <?php echo $comp->readableLocation['city'];?></li>
                <li>Country : <?php echo $comp->readableLocation['country'];?></li>
                <li>Longhitud : <?php echo $comp->readableLocation['longitude'];?></li>
                <li>Latitud : <?php echo $comp->readableLocation['latitude'];?></li>
              </ul>
            </td>
            <td>
              <a href="/tkCompany/preview/<?php echo $comp->id;?>" class="btn btn-success">Preview</a>
            </td>
          </tr>
         <?php endforeach;?>
       </tbody>
     </table>
    </div>
<?php include_once VIEWS.DS.'templates/market/footer.php'?>
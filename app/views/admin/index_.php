<!DOCTYPE html>
<html>
<head>
    <title>Boiler palte</title>
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>vendors/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>css/main.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>css/custom.css">
    <link rel="stylesheet" type="text/css" href="<?php echo URL.DS?>css/user/socialplanet.css">

    <script src="<?php echo URL?>/js/conf.js"></script>
    <script src="<?php echo URL?>/js/jquery.js"></script>
</head>
<body>
    <div class="login background">
        <?php if(!empty($orders)) :?>
        <h1>
            ORDERS
        </h1>
        <table class="table">
            <thead>
                <th>Track#</th>
                <th>Name</th>
                <th>Address</th>
                <th>Total</th>
                <th>View</th>
            </thead>
            <tbody>
                <?php foreach($orders as $order) : ?>
                <tr>
                    <td><?php echo $order->track_no?></td>
                    <td><?php echo $order->fullname?></td>
                    <td><?php echo $order->address?></td>
                    <td><?php echo $order->total?></td>
                    <td><a href="/orders/view_order/<?php echo $order->order_id?>" class="btn btn-primary btn-sm">Preview</a></td>
                </tr>
                <?php endforeach;?>
                
            </tbody>
        </table>
        <?php endif;?>
        <div>
            <h3>Admin Dashboard</h3>
            <?php var_dump_pre($user);?>
        </div>
    </div>

    <!-- Custom Theme Scripts -->

    </div>
</body>
</html>
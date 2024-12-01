<?php build('content') ?>
<div class="container-fluid">
    <?php echo wControlButtonRight('Inventories', [
        $navigationHelper->setNav('', 'Distribute Box Of Coffee', '/InventoryController/distributeBoxOfCoffee')
    ])?>
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Inventory logs'))?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Branch</th>
                        <th>Item Type</th>
                        <th>Quantity</th>
                        <th>Price Per Quantity</th>
                        <th>Amount Total</th>
                    </thead>

                    <tbody>
                        <?php
                            $totalQuantity = 0;
                            $totalAmount = 0;
                        ?>
                        <?php foreach($inventories as $key => $row) : ?>
                            <?php
                                $quantityAmountTotal = $row->price_per_item * $row->quantity;
                                $totalQuantity += $row->quantity;

                                $totalAmount += $quantityAmountTotal;
                            ?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->warehouse_id?></td>
                                <td><?php echo $row->item_type?></td>
                                <td><?php echo $row->quantity?></td>
                                <td><?php echo $row->price_per_item?></td>
                                <td><?php echo $quantityAmountTotal?></td>
                            </tr>
                        <?php endforeach?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo number_format($totalQuantity)?></td>
                            <td></td>
                            <td><?php echo number_format($totalAmount)?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endbuild()?>
<?php occupy('templates/layout')?>
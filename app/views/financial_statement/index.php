<?php build('headers')?>
    <style>
        h2 {
            color: #fff !important;
            padding: 8px;
        }
    </style>
<?php endbuild()?>
<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Financial Statement</h4>
            <a href="/Usermeta/create">Add Statement</a>
        </div>

        <div class="card-body">
            <?php if($userMeta) :?>
                <?php
                    $uMetaExpensesTotal = 0;
                    $uMetaIncomeTotal = 0;
                ?>
                <h2 style="background-color:#94C9A9;">Income</h2>
                <?php wTableBuilder($userMeta, $userService::incomeKeys(), $uMetaIncomeTotal)?>

                <h2 style="background-color: #D7263D;">Expenses</h2>
                <?php wTableBuilder($userMeta, $userService::expensesKeys(), $uMetaExpensesTotal)?>

                <h2 style="background-color:#94C9A9;">Assets</h2>
                <?php wTableBuilder($userMeta, $userService::assets(), $uMetaIncomeTotal)?>

                <h2 style="background-color: #D7263D;">Liabilitties</h2>
                <?php wTableBuilder($userMeta, $userService::liabilities(), $uMetaExpensesTotal)?>
                <h2 style="background-color: #777DA7;">Cash Flow</h2>
                <div style="margin-bottom: 50px">..Not available at the moment</div>
                ((income + asset) - (expenses + liabilities))
                <h4>Net : <?php echo to_number($uMetaIncomeTotal - $uMetaExpensesTotal) ?></h4>
            <?php endif?>
        </div>
    </div>
<?php endbuild()?>

<?php
    function wTmpMetaAttribute($meta) {
        $html = '';
        if(!empty($meta->meta_attribute)) {
            $html .= '<table class="table table-bordered">';
            $metaKeyPair = (array) json_decode($meta->meta_attribute);
                foreach ($metaKeyPair as $key => $value) {
                    $html .= '<tr>';
                        $html .= "<td>{$key}</td>";
                        $html .= "<td>{$value}</td>";
                    $html .= '</tr>';
                }
            $html .= '</table>';
        }

        return $html;
    }
?>

<?php
    function wTableBuilder($userMeta, $keys, &$referenceTotal) {
        ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th style="width: 5%;">#</th>
                    <th style="width: 25%;">Statement</th>
                    <th style="width: 15%;">Amount</th>
                    <th style="width: 15%;">Others</th>
                    <th style="width: 5%;">Action</th>
                </thead>

                <tbody>
                <?php $categoryTotal = 0?>
                <?php foreach($userMeta as $uMeta => $uMetaRow) :?>
                    <?php 
                        if(!isEqual($uMetaRow->meta_key, $keys)){
                            continue;
                        }
                        $referenceTotal += $uMetaRow->meta_value;
                        $categoryTotal  += $uMetaRow->meta_value;
                    ?>
                    <tr>
                        <td><?php echo ++$uMeta?></td>
                        <td><?php echo $uMetaRow->meta_key?></td>
                        <td><?php echo to_number($uMetaRow->meta_value)?></td>
                        <td><?php echo wTmpMetaAttribute($uMetaRow)?></td>
                        <td><a href="/Usermeta/edit/<?php echo $uMetaRow->id?>">Edit</a></td>
                    </tr>
                <?php endforeach?>
                    <td colspan="3">
                        <h4>Total : <?php echo to_number($categoryTotal)?></h4>
                    </td>
                </tbody>
            </table>
        </div>
        <?php
    }
?>
<?php occupy('templates/layout')?>
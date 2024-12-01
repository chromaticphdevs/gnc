<!DOCTYPE html>
<html>
<head>
	<title></title>

	<style type="text/css">
		
		table{
			border: 1px solid #000;
		}
		table td , table th{
			padding: 10px;
		}
	</style>
</head>
<body>
	<div>
		<h3>DIRECT SPONSOR COMMISSION</h3>
		<table>
			<thead>
				<th>USERNAME</th>
				<th>COMMISSION</th>
				<th>AMOUNT</th>
			</thead>
			<tbody>
				<?php foreach($d_sponsors as $sponsor) :?>
					<tr>
						<td><?php echo $sponsor->username?></td>
						<td><?php echo $sponsor->type?></td>
						<td><?php echo $sponsor->amount?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>

	<div>
		<h3>BINARY TREE COMMISSION</h3>
		<table>
			<thead>
				<th>USERNAME</th>
				<th>POSITION</th>
				<th>POINTS</th>
			</thead>
			<tbody>
				<?php foreach($b_tree as $tree) :?>
					<tr>
						<td><?php echo $tree->username?></td>
						<td><?php echo $tree->position?></td>
						<td><?php echo $tree->points?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>

	<div>
		

		<?php 	

			$left_points  = empty($b_tree_income['left']) ? 0:$b_tree_income['left']->points;

			$right_points = empty($b_tree_income['right']) ? 0:$b_tree_income['right']->points;

			$binary_income = generate_binary_income($right_points , $left_points);

			//@param 700 , 600
			function generate_binary_income($right , $left)
			{	
				$greater;
				$lower;

				if($right > $left){
					$greater = $right;
					$lower = $left;
				}else{
					$greater = $left;
					$lower   = $right;
				}
				$amount = 0 ;

				$pair = 0;

				while($lower >= 100)
				{
					$right -= 100;
					$left -= 100;

					$lower   -= 100;

					$pair ++;

					$amount += 100;
				}

				return array(
					'right'   => $greater,
					'left'    => $lower ,
					'pair'    => $pair,
					'amount'  => $amount
				);
			}
		?>

		<h1>Binary tree</h1>
		<table>
			<thead>
				<th>Left Point</th>
				<th>Right Point</th>
				<th>Left Carry</th>
				<th>Right Carry</th>
				<th>Total Pair</th>
				<th>Amount</th>
			</thead>

			<tbody>
				<tr>
					<td>
						<?php 	
							if(!empty($b_tree_income['left']))
							{
								echo $b_tree_income['left']->points;
							}
						?>
					</td>
					<td>
						<?php 	
							if(!empty($b_tree_income['right']))
							{
								echo $b_tree_income['right']->points;
							}
							else{
								echo 0;
							}
						?>
					</td>
					<td>
						<?php echo $binary_income['left'] ?>
					</td>
					<td>
						<?php echo $binary_income['right'] ?>
					</td>
					<td>
						<?php echo $binary_income['pair'] ?>
					</td>
					<td>
						<?php echo $binary_income['amount'] ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>
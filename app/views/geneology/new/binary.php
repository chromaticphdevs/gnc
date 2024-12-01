<?php build('scripts')?>
<script type="text/javascript">
  $(document).ready(function(evt)
  {
    const btnAddLevel = $('.addLevel');

    btnAddLevel.click(function(evt)
    {
      let lastLevels = $('.last-level');

      let uplines = [];

      $.each(lastLevels , function(index , element)
      {
        let userid = $(element).attr('data-userid');
        uplines.push(userid);
      });

      $.post( get_url('binary/') );
    });

  });

</script>
<?php endbuild()?>
<?php build('content')?>

  <?php
    $list = "";

    for($i = 1 ; $i < 5 ; $i++)
    {
      $list .= "<li class='binary-list last-level level-3' data-userid='{$i}'>
        $i
      </li>";
    }

    echo "<ul>
      $list
    </ul>";
  ?>

  <a href="#" class="btn btn-primary btn-sm addLevel">Add Level</a>
<?php endbuild()?>


<?php build('headers')?>

<style media="screen">
  .binary-list {
    padding: 10px;
    border:1px solid #000;
  }
</style>

<?php endbuild()?>
<?php occupy('templates/layout')?>

<?php build('content')?>
<?php Flash::show()?>

               <div class="x_panel">
                <div class="x_content">


                    <table class="table">
                      <thead>
                        <th>#</th>
                        <th>Requester</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                      </thead>

                      <tbody>
                        <?php foreach($List as $key => $row) :?>
                          <tr>
                            <td><?php echo ++$key?></td>
                            <td><?php echo $row->name?></td>
                            <td><?php echo $row->amount?></td>
                            <td><?php echo $row->note; ?></td>
                            <td><a class="btn btn-info btn-sm" target="_blank" href="<?php echo URL.DS.'uploads/expense_proof/'.$row->filename; ?>">
                                  View Image
                              </a>
                            </td>
                            <td>
                                <form action="/Expense/change_status" method="post" enctype="multipart/form-data">
                                  <input type="hidden" name="id" value="<?php echo $row->expenseID ?>">
                                  <input type="text" name="note"  class="form-control" required>
                                  <input type="hidden" name="processed_by" value="<?php echo $userid; ?>">
                                  <input type="hidden" name="status"  class="form-control"  value="approved">
                                  <input type="submit"  value="Approved" class="btn btn-success btn-sm" id='approved' >
                                </form>

                                <br>
                                <form action="/Expense/change_status" method="post" enctype="multipart/form-data">
                                  <input type="hidden" name="id" value="<?php echo $row->expenseID ?>">
                                  <input type="hidden" name="status" value="canceled">
                                  <input type="hidden" name="processed_by" value="<?php echo $userid; ?>">
                                  <input type="text" name="note"  class="form-control" required>
                                  <input type="submit"  value=" Cancel " class="btn btn-danger btn-sm" id='cancel'>
                                </form>
                            </td>
                          </tr>
                        <?php endforeach?>
                      </tbody>
                    </table>
                  </div>
              </div>
         </div>


<?php endbuild()?>


<?php build('scripts')?>
<script defer>
  $( document ).ready(function() {

    $("#approved").on('click' , function(e)
    {
       if (confirm("Are You Sure?"))
       {
          return true;
       }else
       {
         return false;
       }
    });

    $("#cancel").on('click' , function(e)
    {
       if (confirm("Are You Sure?"))
       {
          return true;
       }else
       {
         return false;
       }
    });

  });


</script>
<?php endbuild()?>
<?php occupy('templates/layout')?>

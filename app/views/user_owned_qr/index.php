<?php build('content') ?>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">YOUR QRS</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th width="2%">#</th>
                        <th width="30%"><?php echo WordLib::get('directSponsor')?></th>
                        <th width="30%"><?php echo WordLib::get('upline')?></th>
                        <th width="5%">Position</th>
                        <th width="5%">Is Used</th>
                        <th width="5%">Copy</th>
                        <th width="5%">Copy QR</th>
                        <th>Img Share</th>
                        <th width="5%">Send To</th>
                        <th width="5%">Top Up</th>
                        <th width="5%">Select</th>
                    </thead>

                    <tbody>
                        <?php foreach($qr_codes as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->direct_username?></td>
                                <td><?php echo $row->upline_username?></td>
                                <td>
                                    <select name="#" id="qr_id<?php echo $row->id?>" class="qr-position"
                                        data-id="<?php echo $row->id?>">
                                        <option value=""></option>
                                        <option value="LEFT" <?php echo $row->downline_position == 'LEFT' ? 'selected' : ''?>>LEFT</option>
                                        <option value="RIGHT" <?php echo $row->downline_position == 'RIGHT' ? 'selected' : ''?>>RIGHT</option>
                                    </select>
                                </td>
                                <td>
                                    
                                    <?php if( $row->is_used) :?>
                                        <span class="badge bg-blue">Used</span>
                                    <?php else:?>
                                        <span class="badge bg-green">Available</span>
                                    <?php endif?>
                                </td>
                                <td>
                                    <a href="#" 
                                        class="btn btn-primary btn-sm share"
                                        data-copy="<?php echo URL?>/RaffleRegistrationController/register/?owned_qr=<?php echo $row->id?>"
                                        data-qrid="qr_id<?php echo $row->id?>">Share</a>
                                </td>
                                <td>
                                    <a href="/UniversalCodeController/show/<?php echo $row->id?>"  
                                        class="btn btn-primary btn-sm">Copy QR</a>
                                </td>
                                <td>
                                    <a href="/UniversalCodeController/show/<?php echo $row->id?>&share=image"  
                                        class="btn btn-primary btn-sm">Img Share</a>
                                </td>
                                <td>
                                    <a href="/UserOwnedQRController/sendTo/<?php echo $row->id?>" class="btn btn-primary btn-sm">
                                        Send To
                                    </a>
                                </td>
                                <td>
                                    <?php
                                        Form::open([
                                            'method' => 'post',
                                            'action' => '/UserOwnedQRController/topUp'
                                        ]);

                                        Form::hidden('qr_id' , $row->id);
                                        Form::hidden('user_id' , $user_id);

                                        Form::submit('' , 'Top Up');

                                        Form::close();
                                    ?>
                                </td>
                                <td><input type="checkbox" name="" value="<?php echo $row->id?>" class="selected-qr"></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>

            <a href="#" id="sendSelectCode">Send Selected Codes</a>
        </div>
    </div>
<?php endbuild()?>

<?php build('scripts')?>
    <script defer>
        $( document ).ready( function() {


            $("#sendSelectCode").click(function(e) {
                let checkBoxes = $(".selected-qr");
                let selectedQrs = [];
                $.each(checkBoxes, function(i, element) {
                    if($(element).is(':checked')) {
                        selectedQrs.push(element.value);
                    }
                });

                if(!selectedQrs.empty) {
                    window.location = '<?php echo URL?>/UserOwnedQRController/sendMultiple/?ids='+selectedQrs.toString();
                }
                
            });

            $('.share').click( function(e) {

                let target = $(this).data('qrid');

                if( $("#"+target).val() != '' )
                {
                    copyToClipboardByAttrCopy( $(this) );
                }else{
                    alert('set code position first before sharing')
                }
                
            });

            $(".qr-position").change( function(e) {
                
                let position = $(this).val();
                let data_id = $(this).data('id');

                if( position != '')
                {
                    $.ajax({
                        url: '/UserOwnedQRController/update_position',
                        method :'post',
                        data:{
                            position: position,
                            user_qr_id : data_id
                        },
                        success: function(response) 
                        {
                            //ok
                        }
                    });
                }

                
            });
        });

        function copyToClipboardByAttrCopy( element )
        {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).attr('data-copy')).select();
            document.execCommand("copy");
            $temp.remove();

            alert('copied to clipboard');
        }
    </script>
<?php endbuild()?>
<?php occupy('templates/layout')?>
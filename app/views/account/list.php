<?php build('content') ?>
<div class="container-fluid">
    <div class="card">
        <?php echo wCardHeader(wCardTitle('Accounts')) ?>
        <div class="card-body">
            <input type="text" placeholder="search user.." id="keywordsearch">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <th>USERID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Mobile Number</th>
                        <th>Action</th>
                    </thead>

                    <tbody id="tableRows">
                        <?php foreach($userList as $key => $user) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo userVerfiedText($user)?> <?php echo $user->firstname?> <?php echo $user->lastname?></td>
                                <td><?php echo $user->username?></td>
                                <td><?php echo $user->mobile?></td>
                                <td><a href="/Account/doSearch?username=<?php echo $user->username?>&searchOption=username">Show</a></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>

            <?php echo wPaginator($pagination['totalUserCount'], $pagination['itemsPerPage'], 'account:list')?>
        </div>
    </div>
</div>

<?php endbuild()?>

<?php build('scripts') ?>
    <script>
        $(document).ready(function(){
            $('#keywordsearch').on('keyup', function(e){
                let keyword = $(this).val();

                $.ajax({
                    url  : '/account/api_fetch_all',
                    type : 'GET',
                    data : {
                        keyword : keyword
                    },
                    success : function(response) {
                        response = JSON.parse(response);
                        let responseData = response['data'];
                        $("#tableRows").html(tableBuilder(responseData['users']));
                    }
                });
            });

            function tableBuilder(rows) {
                let retVal = '';
                if(rows) {
                    let counter = 1;
                    for(let i in rows) {
                        let row = rows[i];
                        retVal += `
                            <tr>
                                <td>${counter}</td>
                                <td>${row['is_verified_text']} ${row['firstname']} ${row['lastname']}</td>
                                <td>${row['username']}</td>
                                <td>${row['mobile']}</td>
                                <td><a href="/Account/doSearch?username=${row['username']}&searchOption=username">Show</a></td>
                            </tr>
                        `;
                        counter++;
                    }
                }

                return retVal;
            }
        });
    </script>
<?php endbuild()?>

<?php occupy()?>